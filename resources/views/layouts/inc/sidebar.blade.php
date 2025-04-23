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
      <a class="nav-link {{ Request::is('role*', 'user*', 'instruktur*', 'major*','siswa*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Management</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
        @anyrole(['Administrator', 'Admin'])
          <ul id="components-nav" class="nav-content collapse {{ Request::is('role*', 'user*', 'major*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
              <a href="/user" class="nav-link {{ Request::is('user') ? '' : 'collapsed' }}">
                <i class="bi bi-circle"></i><span>User Management</span>
              </a>
            </li>

            @role('Administrator')
              <li>
                <a href="/role" class="nav-link {{ Request::is('role*') ? '' : 'collapsed' }}">
                  <i class="bi bi-circle"></i><span>Role Management</span>
                </a>
              </li>
            @endrole

            <li>
              <a href="/major" class="nav-link {{ Request::is('major') ? '' : 'collapsed' }}">
                <i class="bi bi-circle"></i><span>Jurusan Management</span>
              </a>
            </li>
        @endanyrole
        
        <li>
          <a href="/instructor" class="nav-link {{ Request::is('instruktur') ? '' : 'collapsed' }}">
            <i class="bi bi-circle"></i><span>Instruktur Manajemen</span>
          </a>
        </li>

        <li>
          <a href="{{route('murid.index')}}" class="nav-link {{ Request::is('siswa') ? '' : 'collapsed' }}">
            <i class="bi bi-circle"></i><span>Siswa Management</span>
          </a>
        </li>        
      </ul>
    </li><!-- End Components Nav -->
    @endanyrole

    <li class="nav-item">
      <a class="nav-link {{ Request::is('pos', 'pos-sale') ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Learning Modul</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      
        <ul id="forms-nav" class="nav-content collapse {{ Request::is('pos', 'learning_module') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
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
          @endrole
        </ul>
    
    </li><!-- End Forms Nav -->

  </ul>

</aside><!-- End Sidebar-->
