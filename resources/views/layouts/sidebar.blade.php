<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    {{-- 1. LOGIKA DATABASE --}}
    @php
        $userRoleIds = auth()->user()->roles->pluck('id');
        
        $allowedMenuIds = \Illuminate\Support\Facades\DB::table('role_has_menus')
                            ->whereIn('role_id', $userRoleIds)
                            ->pluck('menu_id')
                            ->toArray();
    @endphp

    {{-- 2. LOOPING MENU --}}
    @foreach (json_decode(MenuHelper::Menu()) as $menu)
        
        <li class="nav-header">{{ strtoupper($menu->name) }}</li>

        @foreach ($menu->submenus as $submenu)

            {{-- 3. FILTER ROLE (Versi Bersih: Hanya yang diizinkan yang lewat) --}}
            @if(in_array($submenu->id, $allowedMenuIds))

                {{-- KONDISI A: MENU TUNGGAL --}}
                @if (count($submenu->submenus) == '0')
                    <li class="nav-item">
                        <a href="{{ url($submenu->url) }}"
                           class="nav-link {{ Request::segment(1) == $submenu->url ? 'active' : '' }}">
                            <i class="nav-icon {{ $submenu->icon }}"></i>
                            <p>
                                {{ ucwords($submenu->name) }}
                            </p>
                        </a>
                    </li>
                
                {{-- KONDISI B: MENU DROPDOWN --}}
                @else
                    @php
                        $urls = [];
                        foreach ($submenu->submenus as $url) { 
                            $urls[] = $url->url; 
                        }
                    @endphp

                    <li class="nav-item {{ in_array(Request::segment(1), $urls) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ in_array(Request::segment(1), $urls) ? 'active' : '' }}">
                            <i class="nav-icon {{ $submenu->icon }}"></i>
                            <p>
                                {{ ucwords($submenu->name) }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        
                        <ul class="nav nav-treeview">
                            @foreach ($submenu->submenus as $endmenu)
                                
                                {{-- Filter Anak Menu (Opsional: Biar lebih aman) --}}
                                @if(in_array($endmenu->id, $allowedMenuIds))
                                    <li class="nav-item">
                                        <a href="{{ url($endmenu->url) }}" 
                                           class="nav-link {{ Request::segment(1) == $endmenu->url ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ ucwords($endmenu->name) }}</p>
                                        </a>
                                    </li>
                                @endif

                            @endforeach
                        </ul>
                    </li>
                @endif
            
            @endif 

        @endforeach
    @endforeach

</ul>