<nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
        <div class="container-fluid">
            <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav navbar-nav flex-nowrap ml-auto">
                @hasanyrole('Empleado|Administrador|Inversionista')
                <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                        <span class="badge badge-danger badge-counter">3+</span><i class="fas fa-bell fa-fw"></i></a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
                            role="menu">
                            <h6 class="dropdown-header">alerts center</h6>
                            <a class="d-flex align-items-center dropdown-item" href="#">
                                <div class="mr-3">
                                    <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                </div>
                                <div><span class="small text-gray-500">December 12, 2019</span>
                                    <p>A new monthly report is ready to download!</p>
                                </div>
                            </a>
                            <a class="d-flex align-items-center dropdown-item" href="#">
                                <div class="mr-3">
                                    <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i></div>
                                </div>
                                <div><span class="small text-gray-500">December 7, 2019</span>
                                    <p>$290.29 has been deposited into your account!</p>
                                </div>
                            </a>
                            <a class="d-flex align-items-center dropdown-item" href="#">
                                <div class="mr-3">
                                    <div class="bg-warning icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                                </div>
                                <div><span class="small text-gray-500">December 2, 2019</span>
                                    <p>Spending Alert: We&#39;ve noticed unusually high spending for your account.</p>
                                </div>
                            </a><a class="text-center dropdown-item small text-gray-500" href="#">Show All Alerts</a></div>
                    </div>
                </li>
                <div class="d-none d-sm-block topbar-divider"></div>
                <li class="nav-item dropdown no-arrow" role="presentation">
                    <div class="nav-item dropdown no-arrow">
                            <a class="dropdown-toggle nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                             {{ __('Logout') }}
                         </a>

                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                             @csrf
                         </form>
                    </div>
                </li>
                @endhasanyrole
            </ul>
        </div>
    </nav>
