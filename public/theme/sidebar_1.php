<html>
    <head>
        <title>Bootstrap 101 Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/css/simple-sidebar.css" rel="stylesheet" media="screen">
    </head>
    <body>

        <div id="wrapper">

            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li class="sidebar-brand"><a href="#">Start Bootstrap</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Shortcuts</a></li>
                    <li><a href="#">Overview</a></li>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <!-- Page content -->
            <div id="page-content-wrapper">
                <div class="content-header">
                    <h1>
                        <button id="menu-toggle" class="btn"> Toggle</button>
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
                    </div>
                </div>
            </div>

        </div>

        <!-- Bootstrap core JavaScript -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <!-- Put this into a custom JavaScript file to make things more organized -->
        <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("active");
                $("#wrapper").toggleClass("active-ls");
                $("#sidebar-wrapper").toggleClass("inactive-ls");
            });
        </script>
    </body>
</html>