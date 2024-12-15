<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Presensia</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('assets2/img/logo.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assets2/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets2/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets2/css/style.css') }}" rel="stylesheet">
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="51">
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0" id="home">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0 d-flex">
                    <img src="{{ asset('assets2/img/logo.png') }}" alt="Logo" height="35px">
                    <h1 class="m-0 ms-2 fs-2">Presensia</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="#home" class="nav-item nav-link active">Beranda</a>
                        <a href="#about" class="nav-item nav-link">Tentang Kami</a>
                        <a href="#feature" class="nav-item nav-link">Fitur Unggulan</a>
                        <a href="#works" class="nav-item nav-link">Cara Kerja</a>
                    </div>
                    <a href="{{ asset('assets2/apk/app-debug.apk') }}" download
                        class="btn
                        btn-primary-gradient rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Download</a>
                </div>
            </nav>

            <div class="container-xxl bg-primary hero-header">
                <div class="container px-lg-5">
                    <div class="row g-5">
                        <div class="col-lg-8 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated slideInDown">Aplikasi Revolusioner untuk Sistem Absensi
                                yang Cepat dan Aman</h1>
                            <p class="text-white pb-3 animated slideInDown">
                                Tingkatkan efisiensi dan keamanan dengan aplikasi berbasis teknologi pengenalan wajah
                                dan GPS. Solusi inovatif ini menghadirkan sistem absensi yang cepat, akurat, dan andal
                                melalui identifikasi wajah yang canggih.
                            </p>
                            <a href="#features"
                                class="btn btn-primary-gradient py-sm-3 px-4 px-sm-5 rounded-pill me-3 animated slideInLeft">Pelajari
                                Lebih Lanjut</a>
                            <a href="#contact"
                                class="btn btn-secondary-gradient py-sm-3 px-4 px-sm-5 rounded-pill animated slideInRight">Hubungi
                                Kami</a>
                        </div>
                        <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end wow fadeInUp"
                            data-wow-delay="0.3s">
                            <div class="owl-carousel screenshot-carousel">
                                <img class="img-fluid" src="{{ asset('assets2/img/splash.png') }}" alt="">
                                <img class="img-fluid" src="{{ asset('assets2/img/1.png') }}" alt="">
                                <img class="img-fluid" src="{{ asset('assets2/img/8.png') }}" alt="">
                                <img class="img-fluid" src="{{ asset('assets2/img/7.png') }}" alt="">
                                <img class="img-fluid" src="{{ asset('assets2/img/9.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- About Start -->
        <div class="container-xxl py-5" id="about">
            <div class="container py-5 px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <h5 class="text-primary-gradient fw-medium">Tentang Aplikasi</h5>
                        <h1 class="mb-4">Aplikasi #1 Untuk Sistem Absensi Modern</h1>
                        <p class="mb-4">
                            Aplikasi ini mengintegrasikan teknologi pengenalan wajah dan GPS untuk menghadirkan sistem
                            absensi yang cepat, akurat, dan aman. Dengan teknologi GPS, lokasi absensi dapat dipastikan
                            secara real-time, memastikan kehadiran pengguna sesuai dengan lokasi yang ditentukan.
                        </p>
                        <a href="" class="btn btn-primary-gradient py-sm-3 px-4 px-sm-5 rounded-pill mt-3">Read
                            More</a>
                    </div>
                    <div class="col-lg-6">
                        <img class="img-fluid wow fadeInUp" data-wow-delay="0.5s"
                            src="{{ asset('assets2/img/tentang.png') }}">
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Features Start -->
        <div class="container-xxl
                            py-5" id="feature">
            <div class="container py-5 px-lg-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary-gradient fw-medium">Fitur Aplikasi</h5>
                    <h1 class="mb-5">Fitur Unggulan Kami</h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle mb-4"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-user-check text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">Pengenalan Wajah</h5>
                            <p class="m-0">Teknologi pengenalan wajah untuk memastikan keamanan dan
                                keakuratan
                                identifikasi pengguna dalam sistem absensi.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-secondary-gradient rounded-circle mb-4"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-paper-plane text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">Pengajuan Izin</h5>
                            <p class="m-0">Fitur pengajuan izin untuk keperluan sakit, cuti, atau
                                keperluan lainnya,
                                mempermudah proses pengajuan dan persetujuan izin dalam sistem absensi.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle mb-4"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-map-marker-alt text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">GPS Terintegrasi</h5>
                            <p class="m-0">Memastikan lokasi absensi yang valid dengan teknologi GPS,
                                memberikan
                                fleksibilitas tanpa mengurangi keakuratan data.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-secondary-gradient rounded-circle mb-4"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-shield-alt text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">Keamanan Maksimal</h5>
                            <p class="m-0">Data Anda dilindungi dengan protokol keamanan terbaru,
                                memberikan rasa
                                tenang saat menggunakan aplikasi ini.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle mb-4"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-cloud text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">Penyimpanan Cloud</h5>
                            <p class="m-0">Semua data absensi tersimpan dengan aman di cloud,
                                memungkinkan akses
                                kapan saja dan di mana saja.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="feature-item bg-light rounded p-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-secondary-gradient rounded-circle mb-4"
                                style="width: 60px; height: 60px;">
                                <i class="fa fa-mobile-alt text-white fs-4"></i>
                            </div>
                            <h5 class="mb-3">Responsif Sepenuhnya</h5>
                            <p class="m-0">Aplikasi yang dirancang untuk berfungsi sempurna, memberikan
                                pengalaman
                                pengguna yang optimal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features End -->


        <!-- Screenshot Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                        <h5 class="text-primary-gradient fw-medium">Screenshot</h5>
                        <h1 class="mb-4">Antarmuka Ramah Pengguna dan Mudah Digunakan</h1>
                        <p class="mb-4">
                            Aplikasi ini dirancang dengan antarmuka yang intuitif dan mudah digunakan,
                            dilengkapi
                            teknologi canggih untuk mendukung sistem absensi modern. Pengenalan wajah,
                            pengajuan izin,
                            dan GPS bekerja secara harmonis untuk memastikan proses absensi yang akurat,
                            cepat, dan
                            aman.
                        </p>
                        <p><i class="fa fa-check text-primary-gradient me-3"></i>Teknologi pengenalan wajah
                            untuk
                            keamanan maksimal</p>
                        <p><i class="fa fa-check text-primary-gradient me-3"></i>Fitur pengajuan izin untuk
                            keperluan
                            sakit, cuti, atau keperluan lainnya</p>
                        <p class="mb-4"><i class="fa fa-check text-primary-gradient me-3"></i>GPS
                            memastikan absensi
                            sesuai lokasi</p>
                        <a href="" class="btn btn-primary-gradient py-sm-3 px-4 px-sm-5 rounded-pill mt-3">Read
                            More</a>
                    </div>
                    <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end wow fadeInUp"
                        data-wow-delay="0.3s">
                        <div class="owl-carousel screenshot-carousel">
                            <img class="img-fluid" src="{{ asset('assets2/img/8.png') }}" alt="">
                            <img class="img-fluid" src="{{ asset('assets2/img/7.png') }}" alt="">
                            <img class="img-fluid" src="{{ asset('assets2/img/9.png') }}" alt="">
                            <img class="img-fluid" src="{{ asset('assets2/img/3.png') }}" alt="">
                            <img class="img-fluid" src="{{ asset('assets2/img/6.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Screenshot End -->


        <!-- Process Start -->
        <div class="container-xxl py-5" id="works">
            <div class="container py-5 px-lg-5">
                <div class="text-center pb-4 wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary-gradient fw-medium">Cara Kerja</h5>
                    <h1 class="mb-5">3 Langkah Mudah</h1>
                </div>
                <div class="row gy-5 gx-4 justify-content-center">
                    <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="position-relative bg-light rounded pt-5 pb-4 px-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                                style="width: 100px; height: 100px;">
                                <i class="fa fa-cog fa-3x text-white"></i>
                            </div>
                            <h5 class="mt-4 mb-3">Install Aplikasi</h5>
                            <p class="mb-0">Unduh dan pasang aplikasi di perangkat Anda untuk memulai
                                pengalaman yang
                                lebih mudah dan aman.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="position-relative bg-light rounded pt-5 pb-4 px-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-secondary-gradient rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                                style="width: 100px; height: 100px;">
                                <i class="fa fa-address-card fa-3x text-white"></i>
                            </div>
                            <h5 class="mt-4 mb-3">Daftarkan Wajah</h5>
                            <p class="mb-0">Gunakan fitur pendaftaran wajah untuk memastikan akses yang
                                cepat dan
                                aman ke akun Anda.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="position-relative bg-light rounded pt-5 pb-4 px-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                                style="width: 100px; height: 100px;">
                                <i class="fa fa-check fa-3x text-white"></i>
                            </div>
                            <h5 class="mt-4 mb-3">Melakukan Absensi</h5>
                            <p class="mb-0">Gunakan aplikasi untuk melakukan absensi secara cepat,
                                praktis, dan aman
                                dengan wajah Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Process Start -->

        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Address</h4>
                        <p><i class="fa fa-map-marker-alt me-3"></i>Jl. Soekarno Hatta, Malang</p>
                        <p><i class="fa fa-phone-alt me-3"></i>+62 8345 67890</p>
                        <p><i class="fa fa-envelope me-3"></i>Presensia@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Quick Link</h4>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                        <a class="btn btn-link" href="">Career</a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Popular Link</h4>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                        <a class="btn btn-link" href="">Career</a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Newsletter</h4>
                        <p>Stay updated with the latest news and updates from us.</p>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text"
                                placeholder="Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
                                    class="fa fa-paper-plane text-primary-gradient fs-4"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="col-md-6 mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Presensia</a>, All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-lg-square back-to-top pt-2"><i
                class="bi bi-arrow-up text-white"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets2/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets2/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets2/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets2/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets2/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets2/js/main.js') }}"></script>
</body>

</html>
