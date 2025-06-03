<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu</div>
            <a class="nav-link" href={{('/')}}>
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            {{-- <div class="sb-sidenav-menu-heading">Interface</div> --}}
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Aktifitas Harian
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href={{ route ("aktivitas_keperawatan")}}>Aktivitas Keperawatan</a>
                    {{-- <a class="nav-link" href="kehadiran.html">Statistik kehadiran (Opsional) </a> --}}
                </nav>
            </div>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Refleksi Harian
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href={{ route ("refleksi")}}>Form Tulis Refleksi</a>
                    {{-- <a class="nav-link" href="komentar.html">Komentar Kepala Ruang </a> --}}
                </nav>
            </div>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                aria-expanded="false" aria-controls="collapseExample">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Supervisi
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseExample" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href={{ route ("spv_kepru")}}>Form Supervisi Kepala Ruang</a>
                    {{-- <a class="nav-link" href="komentar.html">Daftar Supervisi Perawat</a> --}}
                </nav>
            </div>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample1"
                aria-expanded="false" aria-controls="multiCollapseExample1">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Data Mutu <br>(Tahap Development)
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="multiCollapseExample1" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="#">5R</a>
                    <a class="nav-link" href="#">Insiden</a>
                    <a class="nav-link" href="#">Cuci Tangan</a>
                </nav>
            </div>

            {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2"
                aria-expanded="false" aria-controls="multiCollapseExample2">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Soft Skill (360°) <br>(Tahap Development)
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="multiCollapseExample2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="#">Penilaian oleh rekan sejawat dan atasan</a>
                    <a class="nav-link" href="#">Form penilaian komunikasi, kerja tim, kolaborasi</a>
                </nav>
            </div> --}}

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample3"
                aria-expanded="false" aria-controls="multiCollapseExample3">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Pelatihan Mikrolearning <br>(Tahap Development)
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="multiCollapseExample3" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="#">Daftar materi video / PDF</a>
                    <a class="nav-link" href="#">Kuis</a>
                </nav>
            </div>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample4"
                aria-expanded="false" aria-controls="multiCollapseExample4">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Evaluasi <br>(Tahap Development)
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="multiCollapseExample4" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="#">Ruang, Perawat, Bulan</a>
                    <a class="nav-link" href="#">Unduh PDF/Excel</a>
                    <a class="nav-link" href="#">Kebutuhan SDM dan Akreditasi</a>
                </nav>
            </div>

            {{-- 
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Refleksi Harian
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                        Form Tulis Refleksi
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="login.html">Login</a>
                            <a class="nav-link" href="register.html">Register</a>
                            <a class="nav-link" href="password.html">Forgot Password</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                        Error
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="401.html">401 Page</a>
                            <a class="nav-link" href="404.html">404 Page</a>
                            <a class="nav-link" href="500.html">500 Page</a>
                        </nav>
                    </div>
                </nav>
            </div> --}}

            {{-- <div class="sb-sidenav-menu-heading">Addons</div>
            <a class="nav-link" href="charts.html">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Charts
            </a>
            <a class="nav-link" href="tables.html">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Tables
            </a> --}}
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Product By:</div>
        asisten_spaceX
    </div>
</nav>
