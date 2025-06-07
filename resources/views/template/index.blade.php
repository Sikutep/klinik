<!DOCTYPE html>
<html lang="id">
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Pasien</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- SweetAlert2 CSS & JS (via CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


    <style>
        body {
            background-color: #EBF2FF;
            font-family: "Poppins", sans-serif;
        }

        .sidebar {
            min-width: 150px;
            max-width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: #495057;
            font-size: 13px;
            border-radius: 0.375rem;
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover {
            background-color: #006a4e;
            color: #f8f8f8;
        }

        .sidebar .nav-link.active {
            background-color: #006a4e;
            color: #f8f8f8;
        }

        .main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
            padding: 1rem;
        }

        .content-wrapper {
            flex: 1;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #006a4e;
            color: #fff;
            border-radius: 10px;
        }

        .dropdown-menu .dropdown-item i {
            width: 20px;
        }

        .heading-antrian {
            font-weight: bold;
            color: #006A4E;
            margin-bottom: 30px;
            margin-top: 1rem;
        }

        .box-antrian {
            background-color: #F8F8F8;
            padding: 60px;
            border-radius: 20px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
        }

        .box-antrian-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .btn-tambah-pasien {
            display: inline-block;
            text-align: center;
            text-decoration: none;
            line-height: 50px;
            border: none;
            background-color: #00426B;
            color: white;
            width: 160px;
            height: 50px;
            border-radius: 6px;
            transition: 0.3s;
            margin-right: 40px;
            cursor: pointer;
        }

        .btn-tambah-pasien:hover {
            background-color: #003454;
            transform: translateY(-2px);
        }

        .form-pencarian {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            flex-grow: 1;
            justify-content: center;
        }

        .input-pencarian {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .input-pencarian.nama {
            width: 180px;
        }

        .input-pencarian.nomor-antrian {
            width: 200px;
        }

        .select-pencarian {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            width: 150px;
        }

        .btn-cari {
            border: none;
            background-color: #418FC0;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            transition: 0.3s;
            cursor: pointer;
        }

        .btn-cari:hover {
            background-color: #2e6fa3;
            transform: translateY(-2px);
        }

        .btn-export-excel {
            border: none;
            background-color: #418FC0;
            color: white;
            width: 130px;
            height: 50px;
            border-radius: 6px;
            transition: 0.3s;
            cursor: pointer;
        }

        .btn-export-excel:hover {
            background-color: #2e6fa3;
            transform: translateY(-2px);
        }

        .status-badge {
            color: white;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .action-buttons button {
            border: none;
            border-radius: 8px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            cursor: pointer;
        }

        .action-buttons .btn-view {
            background-color: #7A5C00;
        }

        .action-buttons .btn-view:hover {
            background-color: #5c4700;
            transform: scale(1.05);
        }

        .action-buttons .btn-edit {
            background-color: #006A4E;
        }

        .action-buttons .btn-edit:hover {
            background-color: #004f3a;
            transform: scale(1.05);
        }

        .action-buttons .btn-delete {
            background-color: #7B0000;
        }

        .action-buttons .btn-delete:hover {
            background-color: #5a0000;
            transform: scale(1.05);
        }

        .pagination-wrapper {
            text-align: right;
        }

        .table thead td {
            background-color: #EBF2FF;
        }

        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        .table-container {
            width: auto;
            overflow-x: auto;
        }

        /* ========= RESPONSIVE STYLES ========= */
        @media (max-width: 768px) {
            .sidebar {
                min-width: 80px;
                max-width: 80px;
                padding: 1rem;
                align-items: center;
            }

            .sidebar .nav-link {
                text-align: center;
                font-size: 0;
                padding: 0.75rem 0;
            }

            .sidebar .nav-link i {
                font-size: 18px;
                margin: 5px;
            }

            .sidebar .nav-link span,
            .sidebar .nav-link div {
                display: none !important;
            }

            .sidebar .fs-4 {
                font-size: 0;
            }

            .main-content {
                margin-left: 80px;
                padding: 1rem;
            }

            .box-antrian {
                padding: 20px;
                margin: 10px;
            }

            .box-antrian-header {
                flex-direction: column;
                align-items: stretch;
            }

            .form-pencarian {
                flex-direction: column;
                align-items: stretch;
            }

            .form-pencarian input,
            .form-pencarian select,
            .form-pencarian .btn-cari {
                width: 100% !important;
            }

            .btn-tambah-pasien,
            .btn-export-excel {
                width: 100%;
                margin-right: 0;
            }

            .pagination-wrapper {
                text-align: center;
                margin-top: 20px;
            }
        }

        @media (max-width: 480px) {

            .input-pencarian.nama,
            .input-pencarian.nomor-antrian,
            .select-pencarian {
                width: 100%;
            }

            .btn-cari {
                width: 100%;
            }

            .action-buttons {
                flex-wrap: wrap;
                justify-content: center;
            }

            .action-buttons button {
                width: 36px;
                height: 36px;
                margin: 2px;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 1rem;
            }

            header .dropdown .btn {
                min-width: unset;
                width: auto;
                padding: 8px 12px;
            }

            header .dropdown .btn img {
                width: 36px;
                height: 36px;
            }

            header .dropdown .btn .text-start {
                margin-left: 8px;
            }

            header .dropdown .btn .text-start div:first-child {
                font-size: 13px;
                font-weight: 600;
            }

            header .dropdown .btn .text-start div:last-child {
                font-size: 11px;
                color: gray;
            }

            header .dropdown-menu {
                right: 0 !important;
                left: auto !important;
            }
        }
    </style>

</head>

<body class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar bg-light d-flex flex-column p-3 vh-100">
        <a href="#" class="d-flex justify-content-center align-items-center text-decoration-none"
            style="margin-top: 80px; margin-bottom: 60px">
            <span class="fs-4 fw-bold">Logo</span>
        </a>

        <ul class="nav nav-pills flex-column mb-auto">
            <a href="#" class="nav-link mb-2 {{ request()->is('dashboard') ? 'active' : '' }}"
                style="font-size: 16px; font-weight: bold">
                <i class="fa-solid fa-chart-area me-2"></i>
                <span>Dashboard</span>
            </a>

            <li>
                <a href="{{ url('/patiens') }}" class="nav-link mb-2 {{ request()->routeIs('patiens.*') ? 'active' : '' }}"
                    style="font-size: 16px; font-weight: bold">
                    <i class="fa-solid fa-user-plus me-1"></i>
                    <span>Pendaftaran Pasien</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/antrian') }}" class="nav-link mb-2 {{ request()->routeIs('antrian.*') ? 'active' : '' }}"
                    style="font-size: 16px; font-weight: bold">
                    <i class="fa-solid fa-users me-1"></i>
                    <span>Antrian</span>
                </a>
            </li>

            <li>
                <a href="{{ route('medicalrecord.index') }}"
                    class="nav-link mb-2 {{ request()->routeIs('medicalrecord.*') ? 'active' : '' }}"
                    style="font-size: 16px; font-weight: bold">
                    <i class="fa-solid fa-briefcase-medical me-2"></i>
                    <span>Rekam Medis</span>
                </a>
            </li>
            <li>
                <a href="{{ route('cashier.index') }}" class="nav-link mb-2 {{ request()->routeIs('cashier.*') ? 'active' : '' }}"
                    style="font-size: 16px; font-weight: bold">
                    <i class="fa-solid fa-money-check-alt me-2"></i>
                    <span>Kasir</span>
                </a>
            </li>
            <li>
                <a href="{{ route('observation.index') }}" class="nav-link mb-2 {{ request()->routeIs('observation.*') ? 'active' : '' }}"
                    style="font-size: 16px; font-weight: bold">
                    <i class="fa-solid fa-temperature-half me-2"></i>
                    <span>Observasi</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link mb-2 {{ request()->is('laporan ') ? 'active' : '' }}"
                    style="font-size: 16px; font-weight: bold">
                    <i class="fa-solid fa-file-invoice-dollar me-2"></i>
                    <span>Laporan</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="content-wrapper d-flex flex-column">
        <!-- Header Topbar -->
        <header class="d-flex justify-content-end align-items-center p-3 border-bottom"
            style="box-shadow: 5px 0 5px rgba(0, 0, 0, 0.3); background-color: #F8F8F8;">
            <!-- Profile -->
            <div class="dropdown">
                <button class="btn d-flex align-items-center justify-content-between" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false"
                    style="
                            background-color: #f8f8f8;
                            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
                            border: none;
                            padding: 10px 15px;
                            border-radius: 8px;
                            min-width: 230px;
                        ">
                    <div class="d-flex align-items-center">
                        <img src="image.png" alt="Profile" class="rounded" width="40" height="40"
                            style="object-fit: cover" />
                        <div class="ms-2 text-start">
                            <div style="font-weight: bold">
                                {{ session()->get('user_name', 'default') }}
                            </div>
                            <div style="font-size: 12px; color: gray">
                                {{ session()->get('user_role_name', 'default') }}
                            </div>
                        </div>
                    </div>
                    <i class="ms-3 bi bi-caret-down-fill"></i>
                    <!-- Bootstrap Icon -->
                </button>
                <ul class="dropdown-menu p-3" style="min-width: 260px; border-radius: 14px">
                    <!-- Profil Header -->
                    <li class="text-center mb-2">
                        <img src="image.png" alt="Profile" width="40" height="40"
                            style="object-fit: cover; border-radius: 6px; margin-top: 10px;" />
                        <div
                            style="
                                    font-size: 15px;
                                    font-weight: 600;
                                    margin-top: 5px;
                                ">
                            {{ session()->get('user_name', 'default') }}
                        </div>
                        <div style="font-size: 11px; color: gray">
                            {{ session()->get('user_role_name', 'default') }}
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider my-3" />
                    </li>

                    <!-- Menu Items -->
                    <li>
                        <a class="dropdown-item mt-2" href="#">
                            <i class="fa-solid fa-user-alt me-2"></i>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item mt-2" href="#">
                            <i class="fa-solid fa-wrench me-2"></i> Settings
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            @method('POST')
                            <button type="submit" class="dropdown-item mt-2">
                                <i class="fa-solid fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>

                    </li>
                </ul>
            </div>
        </header>

        <!-- Page Content -->
        <main class="main-content p-5">@yield('content')</main>
    </div>

    <!-- Bootstrap 5 JS (opsional, untuk komponen interaktif) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdown = document.querySelector(".dropdown");
            const button = dropdown.querySelector("button");
            const menu = dropdown.querySelector(".dropdown-menu");
            const icon = button.querySelector("i");

            // Pakai Bootstrap dropdown events
            button.addEventListener("click", () => {
                setTimeout(() => {
                    if (menu.classList.contains("show")) {
                        icon.classList.remove("bi-caret-down-fill");
                        icon.classList.add("bi-caret-up-fill");
                    } else {
                        icon.classList.remove("bi-caret-up-fill");
                        icon.classList.add("bi-caret-down-fill");
                    }
                }, 10);
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdowns = document.querySelectorAll(".dropdown");

            dropdowns.forEach((dropdown) => {
                const button = dropdown.querySelector("button");
                const icon = button.querySelector("i");

                // Saat dropdown ditampilkan
                dropdown.addEventListener("show.bs.dropdown", () => {
                    icon.classList.remove("bi-caret-down-fill");
                    icon.classList.add("bi-caret-up-fill");
                });

                // Saat dropdown disembunyikan
                dropdown.addEventListener("hide.bs.dropdown", () => {
                    icon.classList.remove("bi-caret-up-fill");
                    icon.classList.add("bi-caret-down-fill");
                });
            });
        });
    </script>

    <!-- Bootstrap Icons (opsional, jika ingin pakai icon seperti di contoh) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</body>

</html>
