<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Management System</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    :root {
      --primary-color: #2563eb;
      --sidebar-bg: #1e293b;
    }

    body, html {
      height: 100%;
      overflow: hidden;
      font-family: 'Inter', sans-serif;
      background-color: #f8fafc;
    }

    /* The Main Wrapper */
    #wrapper {
      display: flex;
      width: 100vw;
      height: 100vh;
      transition: all 0.3s ease;
    }

    /* Sidebar Styling */
    .sidebar {
      width: 260px;
      min-width: 260px;
      background: var(--sidebar-bg);
      padding-top: 20px;
      transition: all 0.3s;
      z-index: 1030;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
    }

    /* Sidebar state when hidden (Desktop) */
    #wrapper.sidebar-hidden .sidebar {
      margin-left: -260px;
    }

    .sidebar .nav-link {
      color: #cbd5e1;
      padding: 12px 20px;
      margin: 4px 15px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      white-space: nowrap;
      transition: 0.2s;
    }

    .sidebar .nav-link i { width: 25px; }

    .sidebar .nav-link:hover { background: rgba(255,255,255,0.05); color: white; }

    .sidebar .nav-link.active {
      background: var(--primary-color);
      color: white;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* Content Area */
    main {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    .top-navbar {
      height: 70px;
      background: white;
      border-bottom: 1px solid #e2e8f0;
      padding: 0 25px;
      display: flex;
      align-items: center;
      flex-shrink: 0;
    }

    .content-wrapper {
      flex-grow: 1;
      overflow-y: auto;
      padding: 30px;
    }

    /* Search Box Styling */
    .search-box {
      position: relative;
      margin-right: 20px;
    }

    .search-box input {
      border: 1px solid #e2e8f0;
      border-radius: 20px;
      padding: 8px 40px 8px 15px;
      width: 250px;
      font-size: 14px;
      transition: all 0.3s;
    }

    .search-box input:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .search-box button {
      position: absolute;
      right: 5px;
      top: 50%;
      transform: translateY(-50%);
      background: var(--primary-color);
      border: none;
      border-radius: 50%;
      width: 32px;
      height: 32px;
      color: white;
      cursor: pointer;
      transition: all 0.3s;
    }

    .search-box button:hover {
      background: #1d4ed8;
    }

    /* Mobile Logic */
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        left: -260px;
        height: 100%;
      }
      #wrapper.mobile-show .sidebar {
        left: 0;
      }
      #wrapper.sidebar-hidden .sidebar {
        margin-left: 0;
      }
      .search-box input {
        width: 180px;
        font-size: 13px;
      }
    }
  </style>
</head>

<body>

  <div id="wrapper">
    <nav class="sidebar">
      <div class="px-4 mb-4 d-flex justify-content-between align-items-center">
        <h5 class="text-white mb-0 font-weight-bold">EduAdmin</h5>
        <button class="btn d-md-none text-white p-0" id="mobileClose">
          <i class="fas fa-times"></i>
        </button>
      </div>
      
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
          </a>
        </li>
        
        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
          <li class="nav-item">
            <a class="nav-link {{ Request::is('students*') ? 'active' : '' }}" href="{{ url('/students') }}">
              <i class="fas fa-user-graduate"></i> Students
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('teachers*') ? 'active' : '' }}" href="{{ url('/teachers') }}">
              <i class="fas fa-chalkboard-teacher"></i> Teachers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('courses*') ? 'active' : '' }}" href="{{ url('/courses') }}">
              <i class="fas fa-book"></i> Courses
            </a>
          </li>
        @endif
        
        @if(Auth::user()->isAdmin())
          <li class="nav-item">
            <a class="nav-link {{ Request::is('enrollments*') ? 'active' : '' }}" href="{{ url('/enrollments') }}">
              <i class="fas fa-clipboard-list"></i> Enrollments
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('attendance*') ? 'active' : '' }}" href="{{ url('/attendance') }}">
              <i class="fas fa-calendar-check"></i> Attendance
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ url('/users') }}">
              <i class="fas fa-users-cog"></i> Users
            </a>
          </li>
        @endif
      </ul>
    </nav>

    <main>
      <header class="top-navbar">
        <button class="btn btn-light border mr-3" id="sidebarToggle">
          <i class="fas fa-bars"></i>
        </button>
        
        <h5 class="mb-0 font-weight-bold d-none d-sm-block">Management System</h5>

        <div class="ml-auto d-flex align-items-center">

          {{-- ======================================================
               GLOBAL SEARCH BOX
               - Visible on ALL pages for Admin & Teacher
               - Searches Students, Teachers, and Courses at once
          ====================================================== --}}
          @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
            <form action="{{ url('/search') }}" method="GET" class="search-box">
              <input type="text" name="query" placeholder="Search students, teachers, courses..." value="{{ request('query') }}">
              <button type="submit"><i class="fas fa-search"></i></button>
            </form>
          @endif

          <!-- User Dropdown -->
          <div class="dropdown">
            <button class="btn btn-link dropdown-toggle d-flex align-items-center text-dark text-decoration-none" type="button" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="text-right mr-3 d-none d-md-block">
                <div class="font-weight-bold small text-dark">{{ Auth::user()->name }}</div>
                <div class="text-muted" style="font-size: 10px;">
                  @if(Auth::user()->isAdmin())
                    Admin
                  @elseif(Auth::user()->isTeacher())
                    Teacher
                  @else
                    Student
                  @endif
                </div>
              </div>
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="rounded-circle" width="40">
            </button>
            <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2" aria-labelledby="userMenu">
              <div class="dropdown-header">Manage Account</div>
              <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="fas fa-user-circle mr-2"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </div>
        </div>
      </header>

      <div class="content-wrapper">
        @yield('content')
      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function () {
      // Toggle for Desktop and Mobile
      $('#sidebarToggle, #mobileClose').on('click', function () {
        if ($(window).width() <= 768) {
          $('#wrapper').toggleClass('mobile-show');
        } else {
          $('#wrapper').toggleClass('sidebar-hidden');
        }
      });
    });
  </script>
</body>
</html>
