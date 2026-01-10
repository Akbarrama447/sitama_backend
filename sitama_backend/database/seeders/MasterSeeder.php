<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterSeeder extends Seeder
{
    public function run()
    {
        // =============== MENU ===============
        $menu = Menu::firstOrCreate(
            ['nama_menu' => 'Menu Manajemen'],
            ['url' => '#', 'icon' => '', 'parent_id' => 0, 'urutan' => 1]
        );

        Menu::firstOrCreate(
            ['nama_menu' => 'Dashboard'],
            ['url' => 'home', 'icon' => 'fas fa-home', 'parent_id' => $menu->id, 'urutan' => 1]
        );

        $submenu = Menu::firstOrCreate(
            ['nama_menu' => 'Manajemen Pengguna'],
            ['url' => '#', 'icon' => 'fas fa-users-cog', 'parent_id' => $menu->id, 'urutan' => 2]
        );

        // Kelola Pengguna
        $menuUser = Menu::firstOrCreate(
            ['nama_menu' => 'Kelola Pengguna'],
            ['url' => 'manage-user', 'parent_id' => $submenu->id, 'urutan' => 1]
        );

        foreach (['create_user', 'read_user', 'update_user', 'delete_user'] as $perm) {
            Permission::firstOrCreate(['name' => $perm], ['menu_id' => $menuUser->id]);
        }

        // Kelola Role
        $menuRole = Menu::firstOrCreate(
            ['nama_menu' => 'Kelola Role'],
            ['url' => 'manage-role', 'parent_id' => $submenu->id, 'urutan' => 2]
        );

        foreach (['create_role', 'read_role', 'update_role', 'delete_role'] as $perm) {
            Permission::firstOrCreate(['name' => $perm], ['menu_id' => $menuRole->id]);
        }

        // Kelola Menu
        $menuMenu = Menu::firstOrCreate(
            ['nama_menu' => 'Kelola Menu'],
            ['url' => 'manage-menu', 'parent_id' => $submenu->id, 'urutan' => 3]
        );

        foreach (['create_menu', 'read_menu', 'update_menu', 'delete_menu'] as $perm) {
            Permission::firstOrCreate(['name' => $perm], ['menu_id' => $menuMenu->id]);
        }

        // Backup Server
        $menuBackupServer = Menu::firstOrCreate(
            ['nama_menu' => 'Backup Server'],
            ['url' => '#', 'icon' => '', 'parent_id' => 0, 'urutan' => 2]
        );

        $menuBackup = Menu::firstOrCreate(
            ['nama_menu' => 'Backup Database'],
            ['url' => 'dbbackup', 'icon' => 'fas fa-database', 'parent_id' => $menuBackupServer->id, 'urutan' => 1]
        );

        Permission::firstOrCreate(['name' => 'backup_database'], ['menu_id' => $menuBackup->id]);


        // =============== ROLE HAS MENU ===============
        foreach (Menu::all() as $m) {
            DB::table('role_has_menus')->updateOrInsert(
                ['menu_id' => $m->id, 'role_id' => 1],
                [] // No extra data
            );
        }


        // =============== SUPER ADMIN USER ===============
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('adminadmin')
            ]
        );

        // =============== ROLE SUPERADMIN ===============
        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);

        // assign all permissions ke superadmin
        $superadmin->syncPermissions(Permission::all());

        // assign role ke user
        if (!$user->hasRole('superadmin')) {
            $user->assignRole('superadmin');
        }
    }
}
