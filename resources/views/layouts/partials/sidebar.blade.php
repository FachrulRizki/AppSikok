<aside class="left-sidebar with-vertical">
    <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logos/dark-logo.png') }}" class="dark-logo" width="180"
                    alt="Logo-Dark" />
                <img src="{{ asset('assets/images/logos/light-logo.png') }}" class="light-logo" width="180"
                    alt="Logo-light" />
            </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                
                <li class="sidebar-item">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}" id="get-url" aria-expanded="false">
                        <span><i class="ti ti-home"></i></span>
                        <span class="hide-menu">Beranda</span>
                    </a>
                </li>

                @canany(['aktivitas_keperawatan.list'])
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex"><i class="ti ti-checkup-list"></i></span>
                            <span class="hide-menu">Aktifitas Harian</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('aktivitas_keperawatan.list')
                                <li class="sidebar-item">
                                    <a href="{{ route('aktivitas_keperawatan.index') }}"
                                        class="sidebar-link {{ request()->routeIs('aktivitas_keperawatan.*') ? 'active' : '' }}">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Keperawatan</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @can('refleksi.list')
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('refleksi.*') ? 'active' : '' }}"
                            href="{{ route('refleksi.index') }}">
                            <span><i class="ti ti-notebook"></i></span>
                            <span class="hide-menu">Refleksi Harian</span>
                        </a>
                    </li>
                @endcan

                @canany(['supervisi_kepru.list'])
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex"><i class="ti ti-eye-check"></i></span>
                            <span class="hide-menu">Supervisi</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('supervisi_kepru.list')
                                <li class="sidebar-item">
                                    <a href="{{ route('spv_kepru.index') }}"
                                        class="sidebar-link {{ request()->routeIs('spv_kepru.*') ? 'active' : '' }}">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Kepala Ruang</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <span class="d-flex"><i class="ti ti-gauge"></i></span>
                        <span class="hide-menu">Data Mutu</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('lima_r.index') }}"
                                class="sidebar-link {{ request()->routeIs('lima_r.*') ? 'active' : '' }}">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Data 5R</span>
                            </a>
                        </li>

                        @can('insiden.list')
                            <li class="sidebar-item">
                                <a href="{{ route('insiden') }}"
                                    class="sidebar-link {{ request()->routeIs('insiden.*') ? 'active' : '' }}">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Insiden Keselamatan Pasien</span>
                                </a>
                            </li>
                        @endcan

                        <li class="sidebar-item">
                            <a href="{{ route('cuci_tangan.create') }}"
                                class="sidebar-link {{ request()->routeIs('cuci_tangan.*') ? 'active' : '' }}">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Cuci Tangan</span>
                            </a>
                        </li>

                        @canany(['kuesioner.list', 'kuesioner.buat'])
                            <li class="sidebar-item">
                                <a href="{{ auth()->user()->can('kuesioner.list') ? route('kuesioner.index') : route('kuesioner.create') }}"
                                    class="sidebar-link {{ request()->routeIs('kuesioner.*') ? 'active' : '' }}">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Kepuasan Pasien</span>
                                </a>
                            </li>
                        @endcanany
                    </ul>
                </li>

                @canany(['kuis.list', 'materi.list'])
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-school"></i>
                            </span>
                            <span class="hide-menu">Mikrolearning</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('materi.index') }}" class="sidebar-link {{ request()->routeIs('materi.*') ? 'active' : '' }}">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Materi</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('quiz.index') }}" class="sidebar-link {{ request()->routeIs('quiz.*') || request()->routeIs('attempt.*') ? 'active' : '' }}">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Kuis</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-chart-bar"></i>
                        </span>
                        <span class="hide-menu">Sertifikat (Dev)</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../dark/frontend-landingpage.html" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">Unduh Sertifikat</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @role('Super Admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">Pengguna</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('users.index') }}"
                                    class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Data Pengguna</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('permissions.index') }}"
                                    class="sidebar-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Permissions</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('groups.index') }}"
                                    class="sidebar-link {{ request()->routeIs('groups.*') ? 'active' : '' }}">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Grup Pengguna</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endrole
            </ul>
        </nav>

        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
            <div class="hstack gap-3">
                <div class="john-img">
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40"
                        height="40" alt="modernize-img" />
                </div>
                <div class="john-title text-nowrap text-truncate">
                    <h6 class="mb-0 fs-4 fw-semibold">{{ Auth::user()->name }}</h6>
                    <span class="fs-2">{{ Auth::user()->getRoleNames()->first() }}</span>
                </div>
                <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="submit"
                    form="logout-form" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="logout">
                    <i class="ti ti-power fs-6"></i>
                </button>
                <form action="{{ route('logout') }}" method="post" id="logout-form" hidden>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</aside>
