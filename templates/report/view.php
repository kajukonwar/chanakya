<?php
session_start();

$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";

if(isset($_GET["status"]))
{
$report_search_status=$_GET["status"];
}
else
{
  die("Error: Incorrect Query URL");
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
              VIEW 
              <?php if($report_search_status=="pending") echo "PENDING";
              if($report_search_status=="complete") echo "COMPLETED";
              if($report_search_status=="all") echo "ALL";

              ?>

              REPORTS
              
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
        <div class="col-sm-12">
            <!-- Table -->
       <div class="box">
      
       
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped" id="bill_content_table">

                    <tr>
                      
                      <th>ID</th>
                      <th>Patient Name</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th></th>
                    </tr>

                    <?php
                       
                       $reports=new Helper();
                       $available_reports=$reports->getBills($report_search_status);
                       if(empty($available_reports))
                       {
                        ?>
                          

                          <tr>
                          <td>No  Reports found</td>
                          </tr>

                        <?php
                       }

                       else
                       {

                            foreach($available_reports as $single_report)
                            {
                            ?>
                                  <tr>
                                  <td><?php echo $single_report['id'];?></td>
                                  <td><?php echo $single_report['patient_name'];?></td>
                                  <td><?php echo $single_report['created_on'];?></td>
                                  <td><?php echo $single_report['status'];?></td>
                                  <?php
                                    if($single_report['status']=="pending")
                                    {
                                      ?>

                                        <td><a href="http://localhost/chanakya/chanakya/templates/report/fill.php?id=<?php echo $single_report['id'];?>" class="btn btn-primary" role="button">Fill Report</a>
                                        </td>

                                      <?php

                                    }

                                    elseif($single_report['status']=="complete")
                                    {

                                      ?>

                                        <td><a href="http://localhost/chanakya/chanakya/templates/report/update.php?id=<?php echo $single_report['id'];?>" class="btn btn-primary" role="button">Update Report</a>
                                        </td>

                                        <td><a href="http://localhost/chanakya/chanakya/templates/report/viewDetails.php?id=<?php echo $single_report['id'];?>" class="btn btn-primary" role="button">View Details</a>
                                        </td>

                                        <td><a href="http://localhost/chanakya/chanakya/templates/pdf1.php?r_id=<?php echo $single_report['id'];?>" class="btn btn-primary" role="button">Print report</a>
                                        </td>

                                      <?php

                                    }
                                    else
                                    {
                                      ?>

                                      <td>Error! Something went wrong.</a>
                                      </td>

                                      <?php

                                    }

                                  ?>
                                  
                                  
                                  </tr>

                            <?php
                           }
                       }
                       ?>
        
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
        </div>
    </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>