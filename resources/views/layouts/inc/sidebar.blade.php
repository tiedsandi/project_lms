<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link {{ Request::is('dashboard') ? '' : 'collapsed' }}" href="/dashboard">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ Request::is('role*', 'user*', 'instruktur*', 'major*','siswa*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse {{ Request::is('role*', 'user*', 'product') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="/user" class="nav-link {{ Request::is('user') ? '' : 'collapsed' }}">
            <i class="bi bi-circle"></i><span>User</span>
          </a>
        </li>

        <li>
          <a href="/instruktur" class="nav-link {{ Request::is('instruktur') ? '' : 'collapsed' }}">
            <i class="bi bi-circle"></i><span>Instruktur</span>
          </a>
        </li>

        <li>
          <a href="/major" class="nav-link {{ Request::is('major') ? '' : 'collapsed' }}">
            <i class="bi bi-circle"></i><span>Jurusan</span>
          </a>
        </li>

        <li>
          <a href="/siswa" class="nav-link {{ Request::is('siswa') ? '' : 'collapsed' }}">
            <i class="bi bi-circle"></i><span>Siswa</span>
          </a>
        </li>
        
        <li>
          <a href="/role" class="nav-link {{ Request::is('role*') ? '' : 'collapsed' }}">
        <i class="bi bi-circle"></i><span>Role</span>
          </a>
        </li>
        
      </ul>
    </li><!-- End Components Nav -->

    <li class="nav-item">
      <a class="nav-link {{ Request::is('pos', 'pos-sale') ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Pos Manage</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse {{ Request::is('pos', 'pos-sale') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="/pos-sale" class="nav-link {{ Request::is('pos-sale') ? '' : 'collapsed' }}">
            <i class="bi bi-circle"></i><span>Pos Sale</span>
          </a>
        </li>
        <li>
          <a href="/pos" class="nav-link {{ Request::is('pos') ? '' : 'collapsed' }}">
            <i class="bi bi-circle"></i><span>POS</span>
          </a>
        </li>
      </ul>
    </li><!-- End Forms Nav -->

  </ul>

</aside><!-- End Sidebar-->
