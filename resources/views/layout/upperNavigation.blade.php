<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>@yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="#">

  {{-- Css for this dashboard --}}
    <link rel="icon" href="{{asset('dgme.png')}}" type="image/x-icon"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('_monitoring/css/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('_monitoring/css/icon/feather/css/feather.css')}}"/>
    <link rel="stylesheet" href="{{ asset('_monitoring/css/css/style.css')}}"/>
    <link rel="stylesheet" href="{{ asset('_monitoring/css/css/buttons.dataTables.min.css')}}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('_monitoring/css/css/dataTables.bootstrap4.min.css')}}" />


@yield('styleTags')
<style media="screen">
  .backforbtn{width:5% !important;padding-top:0.3% !important;cursor:pointer;transition:all 600ms ease;    -webkit-transition: all 600ms ease;}
  .backforbtn:hover{transition:all 600ms ease;    -webkit-transition: all 600ms ease;}
</style>
</head>

<body>
    <!-- Pre-loader start -->
        <div class="theme-loader">
            <div class="ball-scale">
                <div class='contain'>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                    <div class="ring">
                        <div class="frame"></div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Pre-loader end -->
        <div id="pcoded" class="pcoded">
            <!-- <div class="pcoded-overlay-box"></div> -->
            <div class="pcoded-container navbar-wrapper">
                <nav class="navbar header-navbar pcoded-header">
                    <div class="navbar-wrapper">
                        <div class="navbar-container container-fluid">
                            <ul class="nav-left">
                              <li onclick="goBack()" class="backforbtn" style=""><img src="{{asset('backbtn.png')}}" width="20px" title="back" alt=""></li>
                              <li onclick="goforward()" class="backforbtn" style="margin: 0% 4%;"><img src="{{asset('backbtn.png')}}" width="19.5px" style="transform: rotate(180deg);" title="forward" alt=""></li>
                                <li class="header-search">
                                    <div class="main-search morphsearch-search">
                                        <div class="input-group">
                                            <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                            <input type="text" class="form-control" id="myInputiQ" style="border:none !important;">
                                            <!-- <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span> -->
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="#!" onclick="javascript:toggleFullScreen()">
                                        <i class="feather icon-maximize full-screen"></i>
                                    </a>
                                </li>
                            </ul>
                            
                    </div></div>
                </nav>
                <!-- Sidebar chat start -->
                <div id="sidebar" class="users p-chat-user showChat">
                    <div class="had-container">
                        <div class="card card_main p-fixed users-main">
                            <div class="user-box">
                                <div class="chat-inner-header">
                                    <div class="back_chatBox">
                                        <div class="right-icon-control">
                                            <input type="text" class="form-control  search-text" placeholder="Search Friend" id="search-friends">
                                            <div class="form-icon">
                                                <i class="icofont icofont-search"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-friend-list">
                                    <div class="media userlist-box" data-id="1" data-status="online" data-username="Duumy Officer" data-toggle="tooltip" data-placement="left" title="Dummy Officer">
                                        <a class="media-left" href="#!">
                                            <img class="media-object img-radius img-radius" src={{asset('_monitoring/css/images/avatar-3.jpg')}} alt="Generic placeholder image ">
                                            <div class="live-status bg-success"></div>
                                        </a>
                                        <div class="media-body">
                                            <div class="f-13 chat-header">Dummy Officer</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- Sidebar inner chat start-->
                <div class="showChat_inner">
                    <div class="media chat-inner-header">
                        <a class="back_chatBox">
                            <i class="feather icon-chevron-left"></i> Dummy Officer
                        </a>
                    </div>
                    <div class="media chat-messages">
                        <a class="media-left photo-table" href="#!">
                            <img class="media-object img-radius img-radius m-t-5" src={{asset('_monitoring/css/images/avatar-3.jpg')}} alt="Generic placeholder image">
                        </a>
                        <div class="media-body chat-menu-content">
                            <div class="">
                                <p class="chat-cont">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda mollitia dolores, quas totam, odit tempore laudantium tenetur debitis nulla, commodi voluptatem distinctio laborum ipsa esse. Ex itaque aspernatur expedita quisquam.</p>
                                <p class="chat-time">8:20 a.m.</p>
                            </div>
                        </div>
                    </div>
                    <div class="media chat-messages">
                        <div class="media-body chat-menu-reply">
                            <div class="">
                                <p class="chat-cont">Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                                <p class="chat-time">8:20 a.m.</p>
                            </div>
                        </div>
                        <div class="media-right photo-table">
                            <a href="#!">
                                <img class="media-object img-radius img-radius m-t-5" src={{asset('_monitoring/css/images/avatar-4.jpg')}} alt="Generic placeholder image">
                            </a>
                        </div>
                    </div>
                    <div class="chat-reply-box p-b-20">
                        <div class="right-icon-control">
                            <input type="text" class="form-control search-text" placeholder="Share Your Thoughts">
                            <div class="form-icon">
                                <i class="feather icon-navigation"></i>
                            </div>
                        </div>
                    </div>
                </div>

                @include('inc.managerSidebar')
                
        </div>
    </div>



</body>
{{-- required --}}
<script src="{{asset('_monitoring/js/jquery/js/jquery.min.js')}}"></script>
<script src="{{asset('_monitoring/js/popper.js/js/popper.min.js')}}"></script>
<script src="{{asset('_monitoring/js/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('_monitoring/css/js/SmoothScroll.js')}}"></script>
<script src="{{asset('_monitoring/css/js/pcoded.min.js')}}"></script>
<script src="{{asset('_monitoring/css/js/vartical-layout.min.js')}}"></script>
<script src="{{asset('_monitoring/css/js/script.min.js')}}"></script>
<script src="{{asset('_monitoring/css/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('_monitoring/css/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('_monitoring/css/pages/data-table/js/data-table-custom.js')}}"></script>

@yield("js_scripts")
<script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
        function goBack() {
            window.history.back();
        }
        function goforward() {
            window.history.forward()
        }
</script>
</html>
