<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <nav class="pcoded-navbar">
            <div class="pcoded-inner-navbar main-menu">
                <div class="pcoded-navigatio-lavel">Navigation</div>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="pcoded-hasmenu">
                        <a href="javascript:void(0)" class="dashboard">
                            <span class="pcoded-micon"><i class="feather icon-check-circle"></i></span>
                            <span class="pcoded-mtext">Dispatch</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a class="createNav" href="{{route('create')}}">
                                    <span class="pcoded-mtext">Create</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-body">
                            @yield('content')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> 