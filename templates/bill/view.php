<?php
session_start();

$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";

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
    <h2>Search report by option</h2>
    <div class="form-group pull-left">
        <label>Search by patient name</label> 
        <input type="text" class="search form-control" id="searchInput" placeholder="By Patient Name">
       
    </div>
    <div class="form-group pull-left">
        <label>Search by Bill number</label>
        <input type="text" class="search form-control" id="searchInput" placeholder="By Bill number">
       
    </div>
    <div class="form-group pull-left">
       <!-- Date range -->
              <div class="form-group">
                <label>Date range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="bill_date_select">
                </div>
                <!-- /.input group -->
              </div>
    </div>
   
  </div>
  </div>

  
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
                                  <td><a href="http://localhost/chanakya/chanakya/templates/bill/viewdetails.php?id=<?php echo $single_available_bill['id'];?>" class="btn btn-primary" role="button">View Details</a>
                                  </td>

                                  <td><a href="http://localhost/chanakya/chanakya/templates/pdf.php?b_id=<?php echo $single_available_bill['id'];?>" class="btn btn-primary" role="button">Print</a>
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