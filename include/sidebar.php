<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';
?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      

    

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        
      <?php
       if($permission=="reception"||$permission=="admin")
       {

        ?>
         <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Bill</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="http://localhost/chanakya/templates/bill/add.php">Create new bill</a></li> <li><a href="http://localhost/chanakya/templates/bill/bill.php">View bills</a></li>

            <li><a href="http://localhost/chanakya/templates/bill/special.php">Create Special bill</a></li>
          </ul>
        </li>
      <?php
        }

      ?>

      <?php
       if($permission=="laboratory"||$permission=="admin")
       {

        ?>
          <li class="treeview">
          <a href=""><i class="fa fa-link"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="http://localhost/chanakya/templates/report/report.php">View reports</a></li>
           
            
          </ul>
        </li>
        <?php
        }

      ?>

          <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Inventory</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="http://localhost/chanakya/templates/inventory/add/add.php">Add inventory</a></li>
            <li><a href="http://localhost/chanakya/templates/inventory/edit/edit.php">Edit inventory</a></li>
            <li><a href="http://localhost/chanakya/templates/inventory/view/view.php">View inventory</a></li>
            <li><a href="http://localhost/chanakya/templates/inventory/delete/delete.php">Delete inventory</a></li>
            
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Doctors</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="http://localhost/chanakya/templates/doctor/add/add.php">Add doctors</a></li>
            <li><a href="http://localhost/chanakya/templates/doctor/edit/edit.php">Edit doctors</a></li>
            <li><a href="http://localhost/chanakya/templates/doctor/view/view.php">View doctors</a></li>
            <li><a href="http://localhost/chanakya/templates/doctor/delete/delete.php">Delete doctors</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Staff</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="http://localhost/chanakya/templates/user/add/add.php">Add staff</a></li>
            <li><a href="http://localhost/chanakya/templates/user/view/view.php">View staff</a></li>
            <li><a href="http://localhost/chanakya/templates/user/edit/edit.php">Edit staff</a></li>
            <li><a href="http://localhost/chanakya/templates/user/delete/delete.php">Delete staff</a></li>
          </ul>
        </li>

       
        <?php
          if($permission=="reception"||$permission=="admin")
         {
          ?>
           <li class="treeview">
          <a href="http://localhost/chanakya/templates/user/admin/sms.php"><i class="fa fa-link"></i> <span>Send SMS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
         
        </li>
        <?php

         }

        ?>


       
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>