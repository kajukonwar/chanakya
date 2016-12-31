<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";
?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        
      </div>

    

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">MENU</li>

         <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Bill</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="http://localhost/chanakya/chanakya/templates/bill/add.php">Create new bill</a></li> <li><a href="http://localhost/chanakya/chanakya/templates/bill/bill.php">View bills</a></li>
          </ul>
        </li>


        <!-- Optionally, you can add icons to the links -->
          <li class="treeview">
          <a href=""><i class="fa fa-link"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="http://localhost/chanakya/chanakya/templates/report/report.php">View reports</a></li>
           
            
          </ul>
        </li>

          <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Inventory</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="http://localhost/chanakya/chanakya/templates/inventory/add/add.php">Add inventory</a></li>
            <li><a href="http://localhost/chanakya/chanakya/templates/inventory/edit/edit.php">Edit inventory</a></li>
            <li><a href="http://localhost/chanakya/chanakya/templates/inventory/view/view.php">View inventory</a></li>
            <li><a href="http://localhost/chanakya/chanakya/templates/inventory/delete/delete.php">Delete inventory</a></li>
            
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Doctors</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="http://localhost/chanakya/chanakya/templates/doctor/add/add.php">Add doctors</a></li>
            <li><a href="http://localhost/chanakya/chanakya/templates/doctor/edit/edit.php">Edit doctors</a></li>
            <li><a href="http://localhost/chanakya/chanakya/templates/doctor/view/view.php">View doctors</a></li>
            <li><a href="http://localhost/chanakya/chanakya/templates/doctor/delete/delete.php">Delete doctors</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Staff</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="http://localhost/chanakya/chanakya/templates/user/add/add.php">Add staff</a></li>
            <li><a href="http://localhost/chanakya/chanakya/templates/user/view/view.php">View staff</a></li>
            <li><a href="http://localhost/chanakya/chanakya/templates/user/edit/edit.php">Edit staff</a></li>
            <li><a href="http://localhost/chanakya/chanakya/templates/user/delete/delete.php">Delete staff</a></li>
          </ul>
        </li>

       
        <!---
         <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">Edit Account</a></li>     
          </ul>
        </li>
        -->
       
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>