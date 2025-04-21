<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="index.html" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
      <span class="d-none d-lg-block">Point of Sales</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>

  <nav class="header-nav ms-auto">
    <div class="nav-link nav-profile d-flex align-items-center pe-3">
      {{-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> --}}
      <span class=" d-block">
        @if(auth()->check())
        Hi, {{ auth()->user()->name }}
        <a href="/logout" class="ms-2" >
          Keluar
        </a>
        @else
        Guest
        @endif
      </span>
    </div>
  </nav>
 

</header><!-- End Header -->