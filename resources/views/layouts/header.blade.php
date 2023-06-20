<div class="navbar-bg" style="background: linear-gradient(90deg, #8dc8ff, #0084ffda );height: 110px;">
    <nav class="navbar navbar-expand-lg main-navbar pt-3">
        <ul class="navbar-nav mr-3">
            <li>
                <button class="btn" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        <ul class="navbar-nav navbar-right ml-auto">
            {{-- <li><button class="btn">
                <i class="fas fa-bell" style="color:#004A8E"></i>
            </button>
            </li>
            <li>
                <button class="btn">
                    <i class="fas fa-user" style="color: #004A8E"></i>
                </button>
            </li> --}}
            <li class="dropdown show"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user" aria-expanded="true">
              <div class="d-sm-none d-lg-inline-block" style="color: #004A8E">Hi, {{Auth::user()->name}}</div></a>
              <div class="dropdown-menu dropdown-menu-right border-0 shadow-sm">

                <a href="/my-profile" class="dropdown-item has-icon py-2" style="color: #004A8E;font-size: 10pt">
                    <i class="fas fa-user"></i> Profile
                </a>

                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item has-icon py-2 text-danger" style="font-size: 10pt">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>


              </div>
            </li>
          </ul>
    </nav>
   </div>
