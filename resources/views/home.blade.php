<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Toko Pewe</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="bizland/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="bizland/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="bizland/vendor/aos/aos.css" rel="stylesheet">
  <link href="bizland/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="bizland/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="bizland/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="bizland/img/logo.png" alt=""> -->
          <h1 class="sitename">Toko Pewe</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            @auth
                <li><a href="{{ route('dashboard') }}" class="active">Dashboard</a></li>
            @else
                <li><a href="{{ route('login') }}" class="active">Login</a></li>
            @endauth
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

      </div>

    </div>

  </header>

  <main class="main">

    <!-- About Section -->
    <section id="about" class="about section light-background">

      <div class="container">

        <div class="row gy-3">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <img src="{{ asset('images/gambar-toko.jpeg') }}" alt="" class="img-fluid">
          </div>

          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="about-content ps-0 ps-lg-3">
              <h3>Toko Pewe (Pring Wulung)</h3>
              <p style="text-align: justify">
                Toko Pewe adalah salah satu pengguna awal aplikasi ini. Berlokasi di daerah padat penduduk, Toko Pewe menjual sembako dan kebutuhan harian. Dengan menggunakan aplikasi ini, Toko Pewe berhasil meningkatkan efisiensi stok, mempercepat proses transaksi, dan memantau pendapatan secara real-time. Testimoni dari pemilik toko menyatakan bahwa aplikasi ini sangat membantu terutama untuk kasir baru yang belum terbiasa dengan sistem manual.
              </p>
            </div>

          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Produk</h2>
        <p><span>Produk di&nbsp;</span><span class="description-title">Toko Pewe</span></p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

            @forelse ($barang as $item)
                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                <img src="{{ asset('storage/files/images/' . $item->image) }}" class="img-fluid" alt="">
                <div class="portfolio-info">
                    <h4>{{ $item->nama }}</h4>
                    <p>Rp {{ number_format($item->harga, 0, ',', ',') }}</p>
                    <a href="{{ asset('storage/files/images/' . $item->image) }}" title="{{ $item->nama }} | Stok {{ $item->stok }} | Harga {{ number_format($item->harga, 0, ',', ',') }}" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
                </div><!-- End Portfolio Item -->
            @empty

          </div><!-- End Portfolio Container -->

            <p class="text-center text-danger">Belum Ada Produk atau Barang</p>
            @endforelse

        </div>

      </div>

    </section><!-- /Portfolio Section -->

  </main>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- Vendor JS Files -->
  <script src="bizland/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="bizland/vendor/php-email-form/validate.js"></script>
  <script src="bizland/vendor/aos/aos.js"></script>
  <script src="bizland/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="bizland/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="bizland/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="bizland/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="bizland/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="bizland/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="bizland/js/main.js"></script>

</body>

</html>
