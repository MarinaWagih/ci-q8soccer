<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Dashboard with Off-canvas Sidebar</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="/q8soccer/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="/q8soccer/css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <span class="glyphicon glyphicon-globe"></span>
                Kuwait Soccer
            </a>

        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">

                <li><a href="/q8soccer/user">users</a></li>
                <li><a href="/q8soccer/team">teams</a></li>
                <li><a href="/q8soccer/match">matches</a></li>
                <li><a href="/q8soccer/prediction">predictions</a></li>
                <li><a href="#">Logout</a></li>


            </ul>

        </div>
    </div>
</nav>

<div class="container-fluid">

    <div class="row row-offcanvas row-offcanvas-left">

        <div class="col-sm-3 col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">

            <ul class="nav nav-sidebar">
                <li class="active">
                    <a href="#">
                        <span class="glyphicon glyphicon-dashboard"></span>
                        Options
                    </a>
                </li>
                <li>
                    <a href="/q8soccer/user">
                        <span class="glyphicon glyphicon-user"></span>
                        Users
                    </a>
                </li>
                <li>
                    <a href="/q8soccer/team">
                        <span class="glyphicon glyphicon-flag"></span>
                        Teams
                    </a>
                </li>
                <li>
                    <a href="/q8soccer/match">
                        <span class="glyphicon glyphicon-fire"></span>
                        Matches
                    </a>
                </li>
                <li>
                    <a href="/q8soccer/prediction">
                        <span class="glyphicon glyphicon-flash"></span>
                        Predictions
                    </a>
                </li>

            </ul>

        </div>
        <!--/span-->
        <div class="col-sm-9 col-md-10 main">
            <?php
            if (isset($data))
            {
                $this->load->view($content, $data);
            } else
            {
                $this->load->view($content);
            }

            ?>
        </div><!--/row-->
    </div>
</div><!--/.container-->

<footer>
    <p class="pull-right">©2015 ExpertsKey</p>
</footer>

<!-- script references -->
<script src="/q8soccer/js/jquery-2.1.3.js"></script>
<script src="/q8soccer/js/bootstrap.min.js"></script>
<script src="/q8soccer/js/scripts.js"></script>
<?php if (isset($data['script'])) {
    ?>
    <script src="/q8soccer/js/<?php echo $data['script']?>"></script>
<?php
}
?>

</body>
</html>
