<nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
        <div class="container-fluid">
            <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
            <ul class="nav navbar-nav flex-nowrap ml-auto">
                <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                    <li class="nav-item dropdown no-arrow">
                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                            <span class="badge badge-danger badge-counter">3+</span>
                            <i class="fas fa-bell fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in" role="menu">
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
                                    <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div><span class="small text-gray-500">December 7, 2019</span>
                                    <p>$290.29 has been deposited into your account!</p>
                                </div>
                            </a>
                            <a class="d-flex align-items-center dropdown-item" href="#">
                                <div class="mr-3">
                                    <div class="bg-warning icon-circle">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <span class="small text-gray-500">December 2, 2019</span>
                                    <p>Spending Alert: We've noticed unusually high spending for your account.</p>
                                </div>
                            </a>
                            <a class="text-center dropdown-item small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>
                    </li>
                    <div class="d-none d-sm-block topbar-divider"></div>
                    <li class="nav-item dropdown no-arrow" role="presentation">
                    <li class="nav-item dropdown no-arrow">
                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                            <span class="d-none d-lg-inline mr-2 text-gray-600 small"> {{ Auth::user()->name }}</span>
                            <img class="border rounded-circle img-profile" src="/img/29468111_10216344975200814_7440674851955671040_n.jpg">
                        </a>
                        <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
                            <a class="dropdown-item" role="presentation" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Cerrar sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    </li>
                </ul>
            </div>
        </nav>