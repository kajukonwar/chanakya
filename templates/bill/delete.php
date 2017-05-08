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

require_once("$root/include/dbconfig.php");
$delete_status="";
//delete bill
if(isset($_GET['id']))
{

   $delete_bill_id=$_GET['id'];

   $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare("DELETE  FROM bill_contents WHERE bill_id=?");

            
            $stmt->bindParam(1,$delete_bill_id);

            $stmt->execute();

            $count = $stmt->rowCount();

            if($count>0)
            {
              
              $stmt1 = $conn->prepare("DELETE  FROM bill WHERE id=?");

            
              $stmt1->bindParam(1,$delete_bill_id);

              $stmt1->execute();
              $count1 = $stmt1->rowCount();

               if($count1==1)
              {
                
                $delete_status="success";

              }
              else
              {
                $delete_status="error";
              }
              
            }

            else
            {
                $delete_status="error";
            }
                   
        
              $stmt=null;
              $conn=null;
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }
}
?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

  
<!--include helper class-->

<?php require_once("$root/lib/classes/class.helper.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="text-center">
              DELETE

               BILLS
              
            </h3>
        </div>
      </div>

      <hr>

      <?php
       if(empty($delete_status))
       {

       }
       elseif($delete_status=="success")
       {
        ?>

            <div class="panel panel-primary">
              <div class="panel-heading">
               <h3 class="text-center">
                  SUCCESS: The selected bill was deleted successfully
              
                </h3>
              </div>
            </div>
        <?php

       }
       else
       {
        ?>
          <div class="panel panel-primary">
              <div class="panel-heading">
               <h3 class="text-center">
                  ERROR: Please report to admin
              
                </h3>
              </div>
            </div>

        <?php

       }
        ?>
    
      
    </section>

    <!-- Main content -->
    <section class="content">


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

                       $bill_search_status="pending";
                       //get all pending bills
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


                                  <td><a href="http://chanakya.lab/templates/bill/delete.php?id=<?php echo $single_available_bill['id'];?>" class="btn btn-primary" role="button">Delete</a>
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