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

if(isset($_GET["status"]))
{
$bill_search_status=$_GET["status"];
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
              VIEW <?php if($bill_search_status=="pending") echo "PENDING";
              if($bill_search_status=="complete") echo "COMPLETED";
              if($bill_search_status=="all") echo "ALL";

              ?>

               BILLS
              
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
    
    <form  id="bill_search_form" class="form-inline">

    <input type="hidden" name="bill_search_status" value="<?php echo $bill_search_status;?>">

    <div class="form-group">
        <label>Patient name</label> 
        <input type="text" class="search form-control" id="bill_search_name" name="bill_search_name"  placeholder="By Patient Name">
       
    </div>
    <div class="form-group" style="margin-left:20px;">
        <label>Bill number</label>
        <input type="text" class="search form-control" id="bill_search_id" name="bill_search_id"  placeholder="By Bill number">
       
    </div>
    <div class="form-group" style="margin-left:20px;">
              <div class="form-group">
                <label>Date range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="bill_search_date" id="bill_search_date">
                </div>
               
              </div>
    </div>


    <div class="form-group" style="margin-left:400px;margin-top:30px;">
            <label class="control-label"></label>
           <div class="input-group">
            <button type="button" name="bill_search_button" id="bill_search_button" class="btn btn-primary btn-lg">Search</button>
            </div>

    </div>
    </form>
   
  </div>
  <div class="col-sm12">
  <h4 id="bill_search_error" class="text-center" style="color:red;display:none;">All search options can't be empty</h4>
  </div>
  </div>

 <hr>
  
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
                      <th></th>
                    </tr>

                    <?php
                       
                       $bills=new Helper();
                       $available_bills=$bills->getBills($bill_search_status);
                       if(empty($available_bills))
                       {
                        ?>
                          

                          <tr>
                          <td>No  Bills found</td>
                          </tr>

                        <?php
                       }

                       else
                       {

                            foreach($available_bills as $single_available_bill)
                            {
                            ?>
                                  <tr>
                                  <td><?php echo $single_available_bill['id'];?></td>
                                  <td><?php echo $single_available_bill['patient_name'];?></td>
                                  <td><?php echo $single_available_bill['created_on'];?></td>
                                  
                                  <td>
                                  <?php echo $single_available_bill['status'];?>
                                  </td>
                                  <td><a href="http://chanakya.lab/templates/bill/viewdetails.php?id=<?php echo $single_available_bill['id'];?>" class="btn btn-primary" role="button">View Details</a>
                                  </td>

                                  <td><?php
                                      if($single_available_bill['is_special'])
                                       {
                                          ?>
                                          <a href="http://chanakya.lab/lib/pdf/bill_special.php?b_id=<?php echo $single_available_bill['id'];?>"  target="_blank" class="btn btn-primary" role="button">Print</a>
                                        <?php
                                        }
                                        else
                                        {
                                          ?>
                                          <a href="http://chanakya.lab/lib/pdf/bill.php?b_id=<?php echo $single_available_bill['id'];?>"  target="_blank" class="btn btn-primary" role="button">Print</a>

                                         <?php
                                        }
                                      ?>
                                  </td>
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