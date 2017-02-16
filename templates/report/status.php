<?php

$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");
if($permission=="admin"||$permission=="laboratory")
{

}
else
{
  die("Unauthorized access");
}

if(!isset($_GET["status"])&&!isset($_GET["r_id"]))
{
die("Error: Wrong query URL");
}
else
{
  $status=$_GET['status'];
  $report_id=$_GET['r_id'];
}
?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
 

    <!-- Main content -->
    <section class="content">

    <!--show save result-->
    <?php require_once("$root/lib/include/user/add.php");?>

   
    <!--include helper class-->

    <?php require_once("$root/lib/classes/class.helper.php");?>
    
    <!--Show save status-->
    <div class="row">
        <div class="col-sm-12">

                  <div class="text-center">


                      <?php

                        switch($status)
                        {

                          case "success":

                          ?>
                                <!-- Content Header (Page header) -->
                              <section class="content-header">
                                <div class="panel panel-primary">
                                  <div class="panel-heading">
                                      <h3 class="text-center">
                                      
                                        The report has been saved successfully 
                                      </h3>
                                  </div>
                                </div>
                                
                              </section>
                              
                              <?php

                              $report_details = new Helper();
                            
                              $patient_details=$report_details->getSingleBill($report_id);

                              //get doctor details
                              if($patient_details[0]['referred_by_doctor']!="no")
                              {

                                  if(!empty($patient_details[0]['doctor_id'])&&$patient_details[0]['doctor_id']!=0)
                                  {

                                      
                                          $doctor_details=$report_details->getSingleDoctor($patient_details[0]['doctor_id']);
                                          if(empty($doctor_details))
                                          {
                                              $doctor_email="";
                                          }
                                         
                                          elseif(empty($doctor_details[0]['email']))
                                          {
                                              $doctor_email="";
                                          }
                                          else
                                          {
                                            $doctor_email=$doctor_details[0]['email'];
                                          }
                                  }
                                  else
                                  {
                                      $doctor_email="";
                                  }
                              }
                              else
                              {
                                $doctor_email="";
                              }
                              ?>
                           
                              <form name="report_save_status_form" id="report_save_status_form">
                                  <input type="hidden" name="report_id" id="report_id" value="<?php echo $report_id;?>">
                              </form>

                              <button type="button" class="btn btn-primary btn-lg" id="report_print" name="report_print">Print Report</button> 

                              <?php
                                     if(!empty($patient_details[0]['patient_email']))
                                    {
                                        ?>

                                      <button type="button" class="btn btn-primary btn-lg" id="report_send_email" name="report_send_email">Send Email to patient</button>

                              <?php
                                     }

                                ?>

                                <?php
                                    if(!empty($patient_details[0]['patient_contact']))
                                    {

                                      ?>


                                      <button type="button" class="btn btn-primary btn-lg" id="report_send_sms" name="report_send_sms">Send SMS</button>
                                <?php
                                     }
                                  ?>

                                <?php
                                    if(!empty($doctor_email))
                                    {
                                      ?>


                                      <button type="button" class="btn btn-primary btn-lg" id="report_send_email_doctor" name="report_send_email_doctor">Send Email to doctor</button>
                                  <?php
                                    }

                                  ?>

                                      <button type="button" class="btn btn-primary btn-lg" id="report_go_back" name="report_go_back">Go Back</button>

                          <?php
                          break;

                          case "error1":
                          ?>


                               <!-- Content Header (Page header) -->
                            <section class="content-header">
                              <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="text-center">
                                    

                                      Error:  Sorry, The report could not be saved
                                      
                                    </h3>
                                </div>
                              </div>
                              
                            </section>

                          <?php
                          break;

                          case "partial":
                          ?>

                              <!-- Content Header (Page header) -->
                            <section class="content-header">
                              <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="text-center">
                                    

                                      Error: The report was partially saved. Some data were not saved.
                                      
                                    </h3>
                                </div>
                              </div>
                              
                            </section>
                          <?php
                          break;

                          default:
                          ?>
                              <!-- Content Header (Page header) -->
                            <section class="content-header">
                              <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="text-center">
                                    

                                      Error: An unexpected error occured
                                      
                                    </h3>
                                </div>
                              </div>
                              
                            </section>

                          <?php
                        }//end switch

                        ?>


       
                   </div> 
             
        </div>
    </div>
    <!--END save status-->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>