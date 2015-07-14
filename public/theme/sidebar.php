<html>
    <head>
        <title>Bootstrap 101 Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/css/simple-sidebar.css" rel="stylesheet" media="screen">
        <link href="/css/navbar-fixed-top.css" rel="stylesheet" media="screen">
        <link href="/css/font-awesome.min.css" rel="stylesheet" media="screen">
    </head>
    <body>

        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div id="first-nav" class="container">
                <div class="navbar-header">
                    <button id="btnMenuToggle" type="button" class="btn btn-default btn-sm" style="float: left; margin-right: 2px">
                        <span class="glyphicon glyphicon-align-justify"></span>
                    </button>
                    <a class="navbar-brand" href="#">Project name</a>
                </div>
                <div class="navbar-right navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span>Juán Perez</span>
                                <span class="menuExpand glyphicon glyphicon-chevron-down" style="font-size: 80%"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li role="presentation"><a href="#" class=""><span class="glyphicon glyphicon-cog"></span> Preferencias</a></li>
                                <li role="presentation"><a href="profile.html" class=""><span class="glyphicon glyphicon-user"></span> Perfil</a></li>
                                <li role="presentation"><a href="index.html" class=""><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
            <div id="second-nav" class="container container-breadcrumb">
                <div class="navbar-header">
                    <a href="#"><i class="fa fa-toggle-left fa-lg" id="menu-toggle"></i></a>
                </div>
                <div class="navbar-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Library</a></li>
                        <li class="active">Data</li>
                    </ol>
                </div>
            </div>
        </div>



        <div id="wrapper">

            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li><a href="#"><i class="fa  fa-dashboard fa-lg"></i>Dashboard</a></li>
                    <li><a href="#"><i class="fa  fa-shopping-cart fa-lg"></i>Shortcuts</a></li>
                    <li><a href="#"><i class="fa  fa-android fa-lg"></i>Overview</a></li>
                    <li class="hasSub">
                        <a href="#">
                            <i class="fa  fa-calendar fa-lg" ></i>
                            Events
                            <span class="menuExpand glyphicon glyphicon-chevron-down"></span>
                        </a>
                        <ul class="sub">
                            <li><a href="#"><i class="fa fa-dashboard fa-lg"></i>Dashboard</a></li>
                            <li><a href="#"><i class="fa fa-android fa-lg"></i>Overview</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-info fa-lg"></i>About</a></li>
                    <li><a href="#"><i class="fa fa-search fa-lg"></i>Services</a></li>
                    <li><a href="#"><i class="fa fa-comments-o fa-lg"></i>Contact</a></li>
                </ul>
            </div>

            <!-- Page content -->
            <div id="page-content-wrapper">
                <div class="content-header">
                    <h1>
                        Simple Sidebar
                    </h1>
                </div>
                <!-- Keep all page content within the page-content inset div! -->
                <div class="page-content inset">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="lead">This simple sidebar template has a hint of JavaScript to make the template responsive. It also includes Font Awesome icon fonts.</p>
                        </div>
                        <div class="col-md-6">
                            <p class="well">The template still uses the default Bootstrap rows and columns.</p>
                        </div>
                        <div class="col-md-6">
                            <p class="well">But the full-width layout means that you wont be using containers.</p>
                        </div>
                        <div class="col-md-4">
                            <p class="well">Three Column Example</p>
                        </div>
                        <div class="col-md-4">
                            <p class="well">Three Column Example</p>
                        </div>
                        <div class="col-md-4">
                            <p class="well">You get the idea! Do whatever you want in the page content area!</p>
                        </div>
                        <div class="col-md-12">
                            <p class="lead">This simple sidebar template has a hint of JavaScript to make the template responsive. It also includes Font Awesome icon fonts.</p>
                        </div>
                        <div class="col-md-6">
                            <p class="well">The template still uses the default Bootstrap rows and columns.</p>
                        </div>
                        <div class="col-md-6">
                            <p class="well">But the full-width layout means that you wont be using containers.</p>
                        </div>
                        <div class="col-md-4">
                            <p class="well">Three Column Example</p>
                        </div>
                        <div class="col-md-4">
                            <p class="well">Three Column Example</p>
                        </div>
                        <div class="col-md-4">
                            <p class="well">You get the idea! Do whatever you want in the page content area!</p>
                        </div>
                        <div class="col-md-12">
                            <p class="lead">This simple sidebar template has a hint of JavaScript to make the template responsive. It also includes Font Awesome icon fonts.</p>
                        </div>
                        <div class="col-md-6">
                            <p class="well">The template still uses the default Bootstrap rows and columns.</p>
                        </div>
                        <div class="col-md-6">
                            <p class="well">But the full-width layout means that you wont be using containers.</p>
                        </div>
                        <div class="col-md-4">
                            <p class="well">Three Column Example</p>
                        </div>
                        <div class="col-md-4">
                            <p class="well">Three Column Example</p>
                        </div>
                        <div class="col-md-4">
                            <p class="well">You get the idea! Do whatever you want in the page content area!</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bootstrap core JavaScript -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/cemacc.js"></script>
        <!-- Put this into a custom JavaScript file to make things more organized -->
        <script>

        </script>
    </body>
</html>