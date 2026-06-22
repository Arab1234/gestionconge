<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gestion des congés</title>
    <link rel="stylesheet" href="{{ url('/') }}/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="{{ url('/') }}/assets/fonts/fontawesome-all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"
        integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ url('/') }}/assets/js/jquery.min.js"></script>
    <script src="{{ url('/') }}/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/assets/js/chart.min.js"></script>
    <script src="{{ url('/') }}/assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="{{ url('/') }}/assets/js/theme.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"
        integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        td,
        th {
            text-align: center;
        }

    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon"><!-- <img src="{{ url('/') }}/assets/img/logo/logo_ests.png"
                            width="80" height="70" /> --></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    @if ($Service!=null)
                        @if ($Service->id == 2)
                            <li class="nav-item"><a class="nav-link @yield('gpc-active')"
                                    href="{{ route('GP') }}"><i class="fas fa-user"></i><span>Gestion des plannings
                                        de congé</span></a></li>

                            <li class="nav-item"><a class="nav-link @yield('gdc-active')" href="{{route("GDC")}}"><i
                                        class="far fa-user-circle"></i><span>Gestion des demandes de congés</span></a>
                            </li>
                            <li class="nav-item"><a class="nav-link @yield('gcm-active')" href="{{route("GCM")}}"><i
                                        class="fas fa-user-circle"></i><span>Gestion des congés de maladie</span></a>
                            </li>

                        @else
                            <li class="nav-item"><a class="nav-link @yield('gpc-active')"
                                    href="{{ route('GP') }}"><i class="fas fa-user"></i><span>Gestion des plannings
                                        de congé</span></a></li>

                            <li class="nav-item"><a class="nav-link @yield('gdc-active')" href="{{route("GDC")}}"><i
                                        class="far fa-user-circle"></i><span>Gestion des demandes de congés</span></a>
                            </li>
                        @endif
                    @endif
                    <li class="nav-item"><a class="nav-link @yield('ca-active')" href="{{ route('CA') }}"><i
                                class="fas fa-table"></i><span>Mes congés administratifs</span></a></li>

                    <li class="nav-item"><a class="nav-link @yield('per-active')" href="{{ route('CP') }}"><i
                        class="fas fa-table"></i><span>Mes permissions</span></a></li>
                </ul>
                <!-- <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0"
                        id="sidebarToggle" type="button"></button></div> -->
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid">
                        <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop"
                            type="button"><i class="fas fa-bars"></i></button>
                        <h2
                            class="text-center d-xl-flex flex-grow-1 flex-fill justify-content-xl-center align-items-xl-center">
                            Gestion des congés</h2>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link"
                                    data-toggle="dropdown" aria-expanded="false" href="#"></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in"
                                    aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small"
                                                type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0"
                                                    type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                        data-toggle="dropdown" aria-expanded="false" href="#"><span
                                            class="d-none d-lg-inline mr-2 text-gray-600 small">{{ Auth::user()->Nom }}
                                            {{ Auth::user()->Prénom }}</span><span class="badge badge-info">{{ Auth::user()->nbTotal }} </span><pre> </pre> <img
                                            class="border rounded-circle img-profile"
                                            src="{{ url('/') }}/assets/img/avatars/avatar1.png"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in">
                                        <a class="dropdown-item" href="{{ route('logout') }}"><i
                                                class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Déconnexion
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    @yield("content")
                    @if (Session::has('msg'))
                        <script>
                            $(document).ready(() => {
                                bootbox.alert({
                                    message: "{{ Session::get('msg') }}",
                                    className: 'rubberBand animated',
                                    centerVertical: true
                                });
                            })
                        </script>
                    @endif
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Tous droit réservés ©</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>

</body>

</html>
