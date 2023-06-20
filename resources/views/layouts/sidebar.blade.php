@php
      $menus = [
            "admin" => [
                [
                    'menu' => 'dashboard',
                    'link' => '/admin',
                    'icon' => 'fas fa-home'
                ],
                [
                    'menu' => 'User',
                    'link' => '/admin/user',
                    'icon' => 'fas fa-users',
                ],[
                    'menu' => 'Kelas',
                    'link' => '/admin/kelas',
                    'icon' => 'fas fa-window-restore'
                ],[
                    'menu' => 'Dosen',
                    'link' => '/admin/dosen',
                    'icon' => 'fas fa-chalkboard-teacher'
                ]
            ],
            "dosen" => [
                [
                    'menu' => 'dashboard',
                    'link' => '/admin',
                    'icon' => 'fas fa-home'
                ],
                [
                    'menu' => 'Kelas',
                    'link' => '/dosen/kelas',
                    'icon' => 'fas fa-window-restore'
                ],
                [
                    'menu' => 'Riwayat Penugasan',
                    'link' => '/admin/penugasan',
                    'icon' => 'fas fa-history'
                ]
            ],
            "mahasiswa" => [
                [
                    'menu' => 'Dashboard',
                    'link' => '/mahasiswa',
                    'icon' => 'fas fa-home'
                ],
                [
                    'menu' => 'Penugasan',
                    'link' => '/mahasiswa/penugasan',
                    'icon' => 'fas fa-tasks'
                ],
                [
                    'menu' => 'Laporan',
                    'link' => '/mahasiswa/penugasan/laporan',
                    'icon' => "fas fa-chart-pie"
                ]
            ]
        ];

        $roles = [
            "1" => "admin",
            "2" => "dosen",
            "3" => "mahasiswa"
        ]
@endphp

<div id="sidebar-wrapper">
    <ul class="sidebar-nav sidebar-lg" >
        <li class="sidebar-brand">
            <a href="#" class="rounded text-center" style="color: #004A8E;font-size: 14pt;letter-spacing:1px;">
                SIPELABA
            </a>
        </li>
        @foreach ($menus as $key => $items)
            @if ($roles[Auth::user()->role_id] == $key)
                <li class="nav-item">
                    <p class="rounded m-0 text-uppercase" style="font-size: 12px;color:#9c9c9c; letter-spacing: 1px">
                        {{$key}}
                    </p>
                </li>
                @foreach ($items as $item)

                <li class="nav-item">
                    <a href="{{$item['link']}}">
                        <i class="{{$item['icon']}}"></i> &nbsp;
                        <span>
                            {{$item['menu']}}
                        </span>
                    </a>
                </li>
                @endforeach
            @endif
        @endforeach
    </ul>

    <ul class="sidebar-nav sidebar-sm" hidden>
        <li class="sidebar-brand">
            <a href="#" class="rounded" style="color: #004A8E;font-size: 14pt;letter-spacing:1px;font-size: 20px">
                SP
            </a>
        </li>
        @foreach ($menus as $key => $items)
            @if ($roles[Auth::user()->role_id] == $key)
                @foreach ($items as $item)
                <li class="nav-item my-2">
                    <a href="{{$item['link']}}">
                        <i class="{{$item['icon']}}" style="margin-left: -15px;font-size: 20px"></i>
                    </a>
                </li>
                @endforeach
            @endif
        @endforeach
{{--
        <li class="nav-item my-2">
            <a href="/admin/user">
                <i class="fas fa-users"  style="margin-left: -15px;font-size: 20px"></i>
            </a>
        </li>
        <li class="nav-item my-2">
            <a href="/admin/kelas">
                <i class="fas fa-window-restore"  style="margin-left: -15px;font-size: 20px"></i>

            </a>
        </li>
        <li class="nav-item my-2">
            <a href="/admin/dosen">
                <i class="fas fa-chalkboard-teacher"  style="margin-left: -15px;font-size: 20px"></i>

            </a>
        </li>
        <li class="nav-item my-2">
            <a href="/admin/mahasiswa">
                <i class="fas fa-user-graduate"  style="margin-left: -15px;font-size: 20px"></i>

            </a>
        </li>
        <li class="nav-item my-2">
            <a href="/admin/penugasan">
                <i class="fas fa-tasks"  style="margin-left: -15px;font-size: 20px"></i>

            </a>
        </li> --}}
    </ul>
</div>


