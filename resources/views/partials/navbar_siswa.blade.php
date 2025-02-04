        <!-- partial:partials/_horizontal-navbar.html -->
        <div class="horizontal-menu">
            <nav class="navbar top-navbar col-lg-12 col-12 p-0">
                <div class="container-fluid">
                    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                            <a class="navbar-brand brand-logo" href="index.html">
                                {{-- <img src="images/logo.svg" alt="logo" /> --}}
                                <h2>LMS64</h2>
                            </a>
                            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg"
                                    alt="logo" /></a>
                        </div>
                        <ul class="navbar-nav navbar-nav-right">
                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                    id="profileDropdown">
                                    <span class="nav-profile-name">{{ auth()->user()->fullname }}</span>
                                    <span class="online-status"></span>
                                    <img src="{{ asset('assets/images/faces/adel.jpg') }}" alt="profile"
                                        style="object-fit: cover" />
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                    aria-labelledby="profileDropdown">
                                    {{-- <a class="dropdown-item">
                                        <i class="mdi mdi-settings text-primary"></i>
                                        Settings
                                    </a> --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        <i class="mdi mdi-logout text-primary"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                            data-toggle="horizontal-menu-toggle">
                            <span class="mdi mdi-menu"></span>
                        </button>
                    </div>
                </div>
            </nav>
            <nav class="bottom-navbar">
                <div class="container col-6">
                    <ul class="nav page-navigation">
                        <li class="nav-item {{ $title === 'Dashboard' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('siswa.index') }}">
                                <i class="mdi mdi-file-document-box menu-icon"></i>
                                <span class="menu-title">Pelajaran</span>
                            </a>
                        </li>

                        <li class="nav-item {{ $title === 'Tugas' ? 'active' : '' }}">
                            <a href="{{ route('siswa.tugas', [$pelajaran->id]) }}" class="nav-link">
                                <i class="mdi mdi-chart-areaspline menu-icon"></i>
                                <span class="menu-title">Tugas</span>
                                {{-- <i class="menu-arrow"></i> --}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="mdi mdi-cube-outline menu-icon"></i>
                                <span class="menu-title">Absensi</span>
                                <i class="menu-arrow"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- partial -->
