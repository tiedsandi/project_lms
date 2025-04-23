<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link {{ Request::is('dashboard') ? '' : 'collapsed' }}" href="/dashboard">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    @anyrole(['Administrator', 'Admin', 'PIC'])
      <li class="nav-item">
        <a class="nav-link {{ Request::is('user*', 'role*', 'major*', 'instructor*', 'murid*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse {{ Request::is('user*', 'role*', 'major*', 'instructor*', 'murid*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="/user" class="nav-link {{ Request::is('user*') ? '' : 'collapsed' }}">
              <i class="bi bi-circle"></i><span>User Manajemen</span>
            </a>
          </li>
          @role('Administrator')
            <li>
              <a href="/role" class="nav-link {{ Request::is('role') ? '' : 'collapsed' }}">
                <i class="bi bi-circle"></i><span>Role Manajemen</span>
              </a>
            </li>
          @endrole
          @anyrole(['Administrator', 'Admin'])
            <li>
              <a href="/major" class="nav-link {{ Request::is('major*') ? '' : 'collapsed' }}">
                <i class="bi bi-circle"></i><span>Jurusan Manajemen</span>
              </a>
          </li>
          @endanyrole
          <li>
            <a href="/instructor" class="nav-link {{ Request::is('instructor*') ? '' : 'collapsed' }}">
              <i class="bi bi-circle"></i><span>Instruktur Manajemen</span>
            </a>
          </li>
          <li>
            <a href="/murid" class="nav-link {{ Request::is('murid*') ? '' : 'collapsed' }}">
              <i class="bi bi-circle"></i><span>Murid Manajemen</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->
    @endanyrole

    <li class="nav-item">
      <a class="nav-link {{ Request::is('learning_module*', 'my-learning*') ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Pembelajaran</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse {{ Request::is('learning_module*', 'my-learning*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        @anyrole(['Administrator', 'Admin', 'PIC'])
          <li>
            <a href="/learning_module" class="nav-link {{ Request::is('learning_module*') ? '' : 'collapsed' }}">
              <i class="bi bi-circle"></i><span>Modul Pembelajaran</span>
            </a>
          </li>
        @endanyrole

        @role('Instruktur')
          <li>
            <a href="{{route('detail_module.index')}}" class="nav-link {{ Request::is('pos-sale') ? '' : 'collapsed' }}">
              <i class="bi bi-circle"></i><span>Modul Pembelajaran</span>
            </a>
          </li>
          <li>
            <a href="{{route('detail_module.index')}}" class="nav-link {{ Request::is('pos-sale') ? '' : 'collapsed' }}">
              <i class="bi bi-circle"></i><span>Upload Modul</span>
            </a>
          </li>
        @endrole
        @role('Murid')
          <li>
            <a href="/my-learning" class="nav-link {{ Request::is('my-learning*') ? '' : 'collapsed' }}">
              <i class="bi bi-circle"></i><span>Modul Pembelajaran Saya</span>
            </a>
          </li>
        @endrole
      </ul>
    </li><!-- End Forms Nav -->

  </ul>

</aside><!-- End Sidebar-->

{{-- 
@anyrole(['Administrator', 'Admin', 'PIC', 'Instruktur'])
@role('Administrator')
  <li>
    <a href="/learning_module" class="nav-link {{ Request::is('learning_module') ? '' : 'collapsed' }}">
      <i class="bi bi-circle"></i><span>Learning Module Management</span>
    </a>
  </li>
@endrole

<li>
  <a href="{{route('detail_module.create')}}"
  class="nav-link {{ Request::is('pos-sale') ? '' : 'collapsed' }}">
    <i class="bi bi-circle"></i><span>Learning Material Upload</span>
  </a>
</li>

  @anyrole(['Administrator', 'Admin', 'PIC'])
  <li>
    <a href="/pos" class="nav-link {{ Request::is('pos') ? '' : 'collapsed' }}">
      <i class="bi bi-circle"></i><span>Learning Material List</span>
    </a>
  </li>
  @endanyrole
@endanyrole

@role('Instruktur')
<li>
  <a href="{{route('detail_module.index')}}" class="nav-link {{ Request::is('pos-sale') ? '' : 'collapsed' }}">
    <i class="bi bi-circle"></i><span>My Upload Materials</span>
  </a>
</li>
@endrole
@role('Murid')
<li>
  <a href="/pos" class="nav-link {{ Request::is('pos') ? '' : 'collapsed' }}">
    <i class="bi bi-circle"></i><span>My Learning Material</span>
  </a>
</li>
@endrole --}}