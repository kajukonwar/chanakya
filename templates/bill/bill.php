<?php

$root= realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';

require_once("$root/include/session_check.php");

if($permission=="admin"||$permission=="reception")
{

}
else
{
  die("Unauthorized access");
}

?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="text-center">
              VIEW BILLS
              
            </h3>
        </div>
      </div>
      
    </section>

    <!-- Main content -->
    <section class="content">

    <!--show save result-->
    <?php require_once("$root/lib/include/user/add.php");?>

   
    <!--include helper class-->

    <?php require_once("$root/lib/classes/class.helper.php");?>
    
    <div class="row">
        <div class="col-sm-4 text-center">
          <a href="http://chanakya.lab/templates/bill/view.php?status=pending" class="btn btn-primary btn-lg active" role="button">Pending bills</a>
        </div>

        <div class="col-sm-4 text-center ">
          <a href="http://chanakya.lab/templates/bill/view.php?status=complete" class="btn btn-primary btn-lg active" role="button">Completed bills</a>
        </div>
        <div class="col-sm-4 text-center">
          <a href="http://chanakya.lab/templates/bill/view.php?status=all" class="btn btn-primary btn-lg active" role="button">All bills</a>

        </div>
    </div>

    <hr>

    


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>