<?php

$root= realpath($_SERVER["DOCUMENT_ROOT"]);

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
              
                                      <button type="button" class="btn btn-danger btn-lg" id="send_sms_owner" name="report_send_sms">Send SMS to Owner</button>
              
            </h3>
        </div>
      </div>
      
    </section>

    <!-- Main content -->
    <section class="content">

   


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
<?php require_once("$root/include/footer.php");?>