import os
import re
import subprocess
from pathlib import Path
import json


def sanitize_table_name(table_name):
    """Sanitize table name for Laravel migration filename"""
    # Convert to lowercase and replace spaces/underscores with hyphens
    sanitized = re.sub(r'[^a-zA-Z0-9_-]', '_', table_name.lower())
    return sanitized.replace(' ', '_')


def get_column_type(sql_type, column_name):
    """Convert MySQL column type to Laravel migration method"""
    sql_type = sql_type.strip().lower()
    
    # Handle VARCHAR with length
    if sql_type.startswith('varchar'):
        match = re.search(r'\((\d+)\)', sql_type)
        length = int(match.group(1)) if match else 255
        return f"string('{column_name}', {length})"
    
    # Handle INT with unsigned
    elif 'bigint' in sql_type:
        if 'unsigned' in sql_type:
            return f"bigInteger('{column_name}')->unsigned()"
        return f"bigInteger('{column_name}')"
        
    elif 'int' in sql_type and 'tinyint' not in sql_type:
        if 'unsigned' in sql_type:
            return f"integer('{column_name}')->unsigned()"
        return f"integer('{column_name}')"
        
    elif 'tinyint' in sql_type:
        # Usually tinyint(1) represents boolean in Laravel
        if '(1)' in sql_type:
            return f"boolean('{column_name}')"
        else:
            return f"tinyInteger('{column_name}')"
            
    elif 'text' in sql_type:
        return f"text('{column_name}')"
        
    elif 'date' in sql_type:
        return f"date('{column_name}')"
        
    elif 'datetime' in sql_type:
        return f"dateTime('{column_name}')"
        
    elif 'timestamp' in sql_type:
        return f"timestamp('{column_name}')"
        
    elif 'time' in sql_type:
        return f"time('{column_name}')"
        
    elif 'year' in sql_type:
        return f"year('{column_name}')"
        
    elif 'decimal' in sql_type or 'double' in sql_type or 'float' in sql_type:
        match = re.search(r'\((\d+),(\d+)\)', sql_type)
        if match:
            precision, scale = match.groups()
            return f"decimal('{column_name}', {precision}, {scale})"
        else:
            return f"decimal('{column_name}')"
            
    elif 'mediumtext' in sql_type:
        return f"mediumText('{column_name}')"
        
    elif 'longtext' in sql_type:
        return f"longText('{column_name}')"
        
    elif sql_type.startswith('enum'):
        # Extract enum values from SQL
        enum_match = re.search(r"enum\((.*)\)", sql_type)
        if enum_match:
            values = enum_match.group(1).replace("'", "")
            enum_values = [f"'{val.strip()}'" for val in values.split(',')]
            return f"enum('{column_name}', [{', '.join(enum_values)}])"
    
    else:
        # Default to string if type is unrecognized
        return f"string('{column_name}')"


def parse_sql_table(sql_content):
    """Parse CREATE TABLE statement and extract table info"""
    # Find CREATE TABLE statement
    create_table_pattern = r'CREATE TABLE `(.*?)` \((.*?)\)(?: ENGINE|CHARSET|=)'
    match = re.search(create_table_pattern, sql_content, re.DOTALL | re.IGNORECASE)
    
    if not match:
        return None
    
    table_name = match.group(1)
    columns_section = match.group(2)
    
    # Split by commas not within parentheses (for enum values)
    columns = []
    paren_count = 0
    current_col = ""
    
    for char in columns_section:
        if char == '(':
            paren_count += 1
        elif char == ')':
            paren_count -= 1
        elif char == ',' and paren_count == 0:
            columns.append(current_col.strip())
            current_col = ""
            continue
        current_col += char
    
    if current_col.strip():
        columns.append(current_col.strip())
    
    table_info = {
        'name': table_name,
        'columns': [],
        'primary_keys': [],
        'foreign_keys': [],
        'indexes': []
    }
    
    for col in columns:
        col = col.strip()
        
        # Skip constraint definitions for now
        if col.upper().startswith(('CONSTRAINT', 'PRIMARY KEY', 'FOREIGN KEY', 'KEY ', 'INDEX ')):
            continue
            
        # Parse column definition
        col_match = re.match(r'^`(.*?)`\s+(.+?)(?:\s+COMMENT\s+\'(.*?)\')?\s*(,|$)', col, re.IGNORECASE)
        if col_match:
            col_name = col_match.group(1)
            col_def = col_match.group(2).strip()
            
            # Check for attributes like NOT NULL, AUTO_INCREMENT, DEFAULT
            not_null = 'NOT NULL' in col_def.upper()
            auto_inc = 'AUTO_INCREMENT' in col_def.upper()
            default_val = None
            
            default_match = re.search(r"DEFAULT\s+([\'\"]?[\w\.]+[\'\"]?)", col_def, re.IGNORECASE)
            if default_match:
                default_val = default_match.group(1).strip("'\"")
                
            column_data = {
                'name': col_name,
                'definition': col_def,
                'laravel_method': get_column_type(col_def, col_name),
                'nullable': not not_null,
                'auto_increment': auto_inc,
                'default': default_val
            }
            
            table_info['columns'].append(column_data)
    
    # Extract primary keys and constraints
    for col in columns:
        col_upper = col.upper()
        if 'PRIMARY KEY' in col_upper:
            pk_match = re.search(r'PRIMARY KEY \(`(.+?)`\)', col)
            if pk_match:
                table_info['primary_keys'].extend([name.strip() for name in pk_match.group(1).split('`,`')])
            else:
                # Single field primary key
                field_match = re.search(r'^`(.+?)`', col)
                if field_match:
                    table_info['primary_keys'].append(field_match.group(1))
    
    # Extract foreign keys
    for col in columns:
        if 'FOREIGN KEY' in col.upper():
            fk_match = re.search(r'FOREIGN KEY \(`(.+?)`\) REFERENCES `(.+?)` \(`(.+?)`\)', col, re.IGNORECASE)
            if fk_match:
                table_info['foreign_keys'].append({
                    'column': fk_match.group(1),
                    'references_table': fk_match.group(2),
                    'references_column': fk_match.group(3)
                })
    
    return table_info


def generate_migration_content(table_info):
    """Generate Laravel migration file content"""
    table_name = table_info['name']
    
    content = f"""<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{{
    /**
     * Run the migrations.
     */
    public function up(): void
    {{
        if (!Schema::hasTable('{table_name}')) {{
            Schema::create('{table_name}', function (Blueprint $table) {{\n"""
    
    # Add columns
    for col in table_info['columns']:
        line = f"                ${col['laravel_method']}"
        
        if col['nullable']:
            line += "->nullable()"
        
        if col['auto_increment']:
            line += "->autoIncrement()"
        
        if col['default'] is not None:
            if isinstance(col['default'], bool):
                line += f"->default({str(col['default']).lower()})"
            elif col['default'].isdigit():
                line += f"->default({col['default']})"
            else:
                line += f"->default('{col['default']}')"
        
        line += ";\n"
        content += line
    
    # Handle primary keys
    if table_info['primary_keys']:
        primary_key_cols = [f"'{col}'" for col in table_info['primary_keys']]
        content += f"                $table->primary([{', '.join(primary_key_cols)}]);\n"
    
    # Handle foreign keys
    for fk in table_info['foreign_keys']:
        content += f"                $table->foreign('{fk['column']}')->references('{fk['references_column']}')->on('{fk['references_table']}');\n"
    
    content += """            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('""" + table_name + """');
    }
};"""
    
    return content


def find_existing_migrations(migrations_dir):
    """Find existing migration files for tables"""
    existing_migrations = {}
    
    for filename in os.listdir(migrations_dir):
        if filename.endswith('.php'):
            # Look for create_[table_name]_table pattern
            match = re.search(r'create_(.+)_table', filename)
            if match:
                table_name = match.group(1)
                # Convert snake_case to actual table name if needed
                table_name = table_name.replace('_', '')
                existing_migrations[table_name] = os.path.join(migrations_dir, filename)
    
    return existing_migrations


def main():
    # Configuration
    sql_file_path = 'database_structure.sql'  # Path to your SQL dump file
    migrations_dir = 'database/migrations'
    
    # Create migrations directory if it doesn't exist
    os.makedirs(migrations_dir, exist_ok=True)
    
    # Read SQL file
    try:
        with open(sql_file_path, 'r', encoding='utf-8') as f:
            sql_content = f.read()
    except FileNotFoundError:
        print(f"SQL file '{sql_file_path}' not found.")
        return
    
    # Find existing migrations
    existing_migrations = find_existing_migrations(migrations_dir)
    
    # Extract CREATE TABLE statements
    create_table_statements = re.findall(r'CREATE TABLE `(.*?)`.*?(?=CREATE TABLE `|\Z)', 
                                        sql_content, re.DOTALL | re.IGNORECASE)
    
    # Process each table
    for i, table_part in enumerate(re.findall(r'CREATE TABLE `.*?(?=CREATE TABLE `|\Z)', 
                                             sql_content, re.DOTALL | re.IGNORECASE)):
        
        table_info = parse_sql_table(table_part)
        if not table_info:
            continue
        
        table_name = table_info['name']
        sanitized_table_name = sanitize_table_name(table_name)
        
        print(f"Processing table: {table_name}")
        
        # Check if migration already exists
        migration_exists = False
        for existing_table_name, migration_path in existing_migrations.items():
            if existing_table_name.lower() == table_name.lower():
                print(f"Migration for {table_name} found at {migration_path}. Skipping schema creation.")
                migration_exists = True
                break
        
        if not migration_exists:
            # Generate migration content
            migration_content = generate_migration_content(table_info)
            
            # Create migration file
            timestamp = f"{2025}{i+1:02d}{i+1:02d}_{i+1:04d}"  # Format: YYYYMMDD_HHHH
            migration_filename = f"{timestamp}_create_{sanitized_table_name}_table.php"
            migration_path = os.path.join(migrations_dir, migration_filename)
            
            with open(migration_path, 'w', encoding='utf-8') as f:
                f.write(migration_content)
            
            print(f"Created migration: {migration_path}")
        else:
            print(f"Skipping {table_name} - migration already exists")
    
    print("\nMigration generation completed!")


if __name__ == "__main__":
    main()