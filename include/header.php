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

  <link rel="shortcut icon" href="/dist/img/favicon (2).ico" type="image/x-icon">
  <link rel="icon" href="/dist/img/favicon (2).ico" type="image/x-icon">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/plugins/ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="/dist/css/skins/skin-blue.min.css">

  <!-- daterange picker -->
  <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">


  <link href="/plugins/vex-master/dist/css/vex.css" rel="stylesheet" />
  <link href="/plugins/vex-master/dist/css/vex-theme-os.css" rel="stylesheet" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->

  <!--custom css-->
  <link rel="stylesheet" href="/dist/css/custom.css">

  

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><i>Chanakya Diagnostics</i></span>
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
          

          <li>
           <div style="padding-bottom: 15px;
    padding-top: 15px;line-height: 20px;position: relative;display: block;background-color: transparent;color: #fff;">
              
          <i class="fa fa-clock-o"></i>
          <?php 
          
          echo date("D, M d,Y");
          ?>
          </div>
          </li>
          <!--include helper class-->
            <?php require_once("$root/lib/classes/class.helper.php");?>
            <?php

              $notifications=new Helper();
              //all pending reports 
              $pending_task=$notifications->getBills("pending");

              $today=date("Y-m-d");
              //pending reports today
              $task_today=$notifications->getBillsDay("pending",$today);

              //all bills created today
              $bills_today=$notifications->getBillsDay("all",$today);

              //all bills from beginning
              $all_bills=$notifications->getBills("all");
            ?>

          <!-- Notifications Menu -->
            <?php
            //for reception
            if($_SESSION['user_role']=="reception"||$_SESSION['user_role']=="admin")
            {

              ?>
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
          
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
                <i class="fa fa-bullhorn"></i> Bil Notifications
                <?php

                  if(!empty($bills_today))
                    {
                      ?>
                      <span class="label label-warning"><?php echo count($bills_today);?></span>
                      <?php
                    }
  
                ?>
              
            </a>
             <ul class="dropdown-menu">
                <li class="header">
                  <i class="fa fa-users text-aqua"></i>
                <?php 
               
                           if(empty($bills_today))
                            {
                              echo "No bills created today";
                            }
                            else
                            {
                              echo count($bills_today)." bills created today";
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
                                     
                            if(empty($all_bills))
                            {
                              echo "Oops! No bills created yet.";
                            }
                            else
                            {
                              echo "You have ".count($all_bills)." bills in total";
                            }
                        ?>

                        </a>
                    </li>
                    <!-- end notification -->
                  </ul>
                </li>

                <?php
                 if(!empty($all_bills))
                  {
                  ?>
                <li class="footer"><a href="http://chanakya.lab/templates/bill/bill.php">View all</a></li>
                <?php
                  }
                ?>
              </ul>
             </li>
              <?php
            }
            //END reception

            ?>


           <?php
            //for laboratory
            if($permission=="laboratory"||$permission=="admin")
            {

              ?>
          <li class="dropdown notifications-menu">

            

            <!-- Menu toggle button -->
          
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
                <i class="fa fa-bullhorn"></i> Report Notifications
                <?php

                  if(!empty($task_today))
                    {
                      ?>
                      <span class="label label-warning"><?php echo count($task_today);?></span>
                      <?php
                    }
  
                ?>
              
            </a>
             <ul class="dropdown-menu">
              <li class="header">
                <i class="fa fa-users text-aqua"></i>
              <?php 
             
                         if(empty($task_today))
                          {
                            echo "No pending report created today";
                          }
                          else
                          {
                            echo count($task_today)." pending report created today";
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
                                   
                          if(empty($pending_task))
                          {
                            echo "No pending reports to fill. Take a break!";
                          }
                          else
                          {
                            echo "You have ".count($pending_task)." pending reports in total";
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
              <li class="footer"><a href="http://chanakya.lab/templates/report/view.php?status=all">View all</a></li>
              <?php
                }
              ?>
              </ul>
          </li>
              <?php
            }
            //END laboratory

            ?>



          
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <i class="fa fa-user"></i>
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <?php
                $user_details=$notifications->getSingleStaff($_SESSION['user_id']);
              ?>
              <span class="hidden-xs">Hi<?php echo " ".$user_details[0]['full_name'];?> </span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                

                <p>
                  Staff- Chanakya Diagnostics
                  
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                <!--
                  <a href="http://localhost/chanakya/chanakya/templates/user/account/account.php" class="btn btn-default btn-flat">Profile</a>
                -->
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="http://chanakya.lab/logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!--
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
          -->
        </ul>
      </div>
    </nav>
  </header>