<?php

$root= realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';

require_once("$root/include/session_check.php");
if($permission!="admin")
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
      
     
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
    

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
<?php $root= realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';require_once("$root/include/footer.php");?>