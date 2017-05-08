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
    
    <form  id="report_search_form" class="form-inline">

    <input type="hidden" name="report_search_status" value="<?php echo $report_search_status;?>">

    <div class="form-group">
        <label>Patient name</label> 
        <input type="text" class="search form-control" id="report_search_name" name="report_search_name"  placeholder="By Patient Name">
       
    </div>
    <div class="form-group" style="margin-left:20px;">
        <label>Report number</label>
        <input type="text" class="search form-control" id="report_search_id" name="report_search_id"  placeholder="By Bill number">
       
    </div>
    <div class="form-group" style="margin-left:20px;">
              <div class="form-group">
                <label>Date range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="report_search_date" id="report_search_date">
                </div>
               
              </div>
    </div>



    <div class="form-group" style="margin-left:400px;margin-top:30px;">
            <label class="control-label"></label>
           <div class="input-group">
            <button type="button" name="report_search_button" id="report_search_button" class="btn btn-primary btn-lg">Search</button>
            </div>

    </div>

    </form>
   
  </div>
  <div class="col-sm12">
  <h4 id="report_search_error" class="text-center" style="color:red;display:none;">All search options can't be empty</h4>
  </div>
  </div>

 <hr>


    <div class="row">
        <div class="col-sm-12">
            <!-- Table -->
       <div class="box">
      
       
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped" id="report_content_table">

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
                                       switch($single_report['is_special'])
                                      {


                                          case "yes":

                                      ?>
                                              <td><a href="http://chanakya.lab/templates/report/fill_special.php?id=<?php echo $single_report['id'];?>" class="btn btn-primary" role="button">Fill Report</a>
                                              </td>
                                      <?php
                                          break;

                                          case "no":
                                      ?>
                                              <td><a href="http://chanakya.lab/templates/report/fill.php?id=<?php echo $single_report['id'];?>" class="btn btn-primary" role="button">Fill Report</a>
                                              </td>
                                        

                                      <?php
                                          break;

                                          default:

                                      }

                                    }

                                    elseif($single_report['status']=="complete")
                                    {

                                      switch($single_report['is_special'])
                                      {

                                         case "yes":
                                      ?>

                                        <td><a href="http://chanakya.lab/templates/report/update_special.php?id=<?php echo $single_report['id'];?>" class="btn btn-primary" role="button">Update Report</a>
                                        </td>

                                        <td><a href="http://chanakya.lab/templates/report/viewDetails_special.php?id=<?php echo $single_report['id'];?>" class="btn btn-primary" role="button">View Details</a>
                                        </td>

                                        <td>
                                         <a href="http://chanakya.lab/lib/pdf/report_special.php?r_id=<?php echo $single_report['id'];?>"  target="_blank" class="btn btn-primary" role="button">Print report</a>
                                        </td>

                                      <?php
                                       break;

                                       case "no":
                                       ?>

                                        <td><a href="http://chanakya.lab/templates/report/update.php?id=<?php echo $single_report['id'];?>" class="btn btn-primary" role="button">Update Report</a>
                                        </td>

                                        <td><a href="http://chanakya.lab/templates/report/viewDetails.php?id=<?php echo $single_report['id'];?>" class="btn btn-primary" role="button">View Details</a>
                                        </td>

                                        <td><a href="http://chanakya.lab/lib/pdf/report.php?r_id=<?php echo $single_report['id'];?>"  target="_blank" class="btn btn-primary" role="button">Print report</a>
                                        </td>

                                       <?php
                                       break;

                                       default:
                                    }//end switch

                                    }//end elseif
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