<header class="topbar">
    <div class="with-vertical"><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Header -->
        <!-- ---------------------------------- -->
        <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
                <li class="nav-item nav-icon-hover-bg rounded-circle ms-n2">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>

            <div class="d-block d-lg-none py-4">
                <a href="../dark/index.html" class="text-nowrap logo-img">
                    <img src="{{ asset('assets/images/logos/dark-logo.png') }}" width="150" class="dark-logo" alt="Logo-Dark" />
                    <img src="{{ asset('assets/images/logos/light-logo.png') }}" width="150" class="light-logo"
                        alt="Logo-light" />
                </a>
            </div>
            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti ti-dots fs-7"></i>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        <li class="nav-item nav-icon-hover-bg rounded-circle">
                            <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                <i class="ti ti-moon moon"></i>
                            </a>
                            <a class="nav-link sun light-layout" href="javascript:void(0)">
                                <i class="ti ti-sun sun"></i>
                            </a>
                        </li>

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="overflow-hidden rounded-circle">
                                        <div class="ratio ratio-1x1" style="height: 35px; width: 35px">
                                            @if (Auth::user()->foto_profil)
                                                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="object-fit-cover w-100 h-100" alt="Profil" />
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=01C0C8&color=fff" class="rounded-circle" width="35" height="35" alt="Profil" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">Profil Pengguna</h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <div class="overflow-hidden rounded-circle">
                                            <div class="ratio ratio-1x1" style="width: 80px; height: 80px">
                                                @if (Auth::user()->foto_profil)
                                                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="object-fit-cover w-100 h-100" alt="Profil" />
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=01C0C8&color=fff" class="rounded-circle" width="80" height="80" alt="Profil" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-4 fw-semibold">{{ Auth::user()->name }}</h5>
                                            <span class="mb-1 d-block">{{ Auth::user()->getRoleNames()->first() }}</span>
                                            <p class="mb-0">
                                                <span>@</span>{{ Auth::user()->username }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <a href="{{ route('profile.index') }}"
                                            class="py-8 px-7 mt-8 d-flex align-items-center">
                                            <span
                                                class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-user text-primary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" /><path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" /></svg>
                                            </span>
                                            <div class="w-100 ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">Profil Saya</h6>
                                                <span class="fs-2 d-block text-body-secondary">Pengaturan Akun</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-grid py-4 px-7 pt-8">
                                        <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            class="btn btn-danger">Log Out</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- ---------------------------------- -->
        <!-- End Vertical Layout Header -->
        <!-- ---------------------------------- -->
    </div>
</header>
