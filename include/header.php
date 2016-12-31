<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Chanakya Diagnostics</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/chanakya/chanakya/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/chanakya/chanakya/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/chanakya/chanakya/plugins/ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/chanakya/chanakya/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="/chanakya/chanakya/dist/css/skins/skin-blue.min.css">

  <!-- daterange picker -->
  <link rel="stylesheet" href="/chanakya/chanakya/plugins/daterangepicker/daterangepicker.css">


  <link href="/chanakya/chanakya/plugins/vex-master/dist/css/vex.css" rel="stylesheet" />
  <link href="/chanakya/chanakya/plugins/vex-master/dist/css/vex-theme-os.css" rel="stylesheet" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->

  <!--custom css-->
  <link rel="stylesheet" href="/chanakya/chanakya/dist/css/custom.css">

  

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><i>Chanakya</i></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          

          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">

            <!--include helper class-->
            <?php require_once("$root/lib/classes/class.helper.php");?>
            <?php

              $notifications=new Helper();
              $pending_task=$notifications->getBills("pending");

              $today=date("Y-m-d");
              $task_today=$notifications->getBillsDay("pending",$today);
            ?>

            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
                <i class="fa fa-bullhorn"></i> Notifications
            
              <?php
              if(!empty($pending_task))
                {
                  ?>
                  <span class="label label-warning"><?php echo count($pending_task);?></span>
                  <?php
                }
              ?>
              
            </a>
            <ul class="dropdown-menu">
              <li class="header">

              <?php 
                if(empty($pending_task))
                {
                  echo "Good Job! You dont have any pending reports to fill";
                }
                else
                {
                  echo "You have ".count($pending_task)." pending reports in total";
                }
                ?>
              </li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  <li><!-- start notification -->
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i>
                      <?php 
                          if(empty($task_today))
                          {
                            echo "No pending report generated today";
                          }
                          else
                          {
                            echo count($task_today)." pending report generated today";
                          }
                      ?>

                      </a>
                  </li>
                  <!-- end notification -->
                </ul>
              </li>

              <?php
              if(!empty($pending_task))
                {
                ?>
              <li class="footer"><a href="http://localhost/chanakya/chanakya/templates/report/view.php?status=pending">View all</a></li>
              <?php
                }
                ?>
            </ul>
          </li>
          
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <i class="fa fa-user"></i>
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">Hi</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                

                <p>
                  Alexander Pierce - Web Developer
                  
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="http://localhost/chanakya/chanakya/templates/user/account/account.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>