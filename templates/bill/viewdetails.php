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

if(isset($_GET["id"]))
{
	$bill_id=$_GET["id"];
}
else
{
	die("Invalid URL");
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
              VIEW BILL DETAILS
              
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
    <!--add test form-->
      <div class="col-sm-12">

         <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">General Details</div>
        <div class="panel-body">
          <p></p>
        </div>


        <?php
        	$bill=new Helper();
        	$single_bill=$bill->getSinglebill($bill_id);

        ?>
      <!-- Table -->
       <div class="box">
      
       
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped">

                    <tr>
                      
                      <th>Bill No.</th>
                      <td><?php echo $single_bill[0]['id'];?></td>
                    </tr>
                    <tr>
                      
                      <th>Bill creation date</th>
                      <td><?php echo $single_bill[0]['created_on'];?></td>
                    </tr>
                    <tr>
                      
                      <th>Created by</th>
                      <?php 

                        $bill_staff=$bill->getSingleStaff($single_bill[0]['staff_id']);

                      ?>
                      <td><?php echo $bill_staff[0]['full_name'];?></td>
                    </tr>

                    <tr>
                      
                      <th>Bill status</th>
                      <td><?php echo $single_bill[0]['status'];?></td>
                    </tr>
                    
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
         
          </div>

         </div>
        </div>
     <!--End general details-->



      <div class="row">
    <!--add test form-->
      <div class="col-sm-12">

         <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">Patient Details</div>
        <div class="panel-body">
          <p></p>
        </div>

      <!-- Table -->
       <div class="box">
      
       
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped">

                    <tr>
                      
                      <th>Patient name</th>
                      <td><?php echo $single_bill[0]['patient_name'];?></td>
                    </tr>
                    <tr>
                      
                      <th>Patient address</th>
                      <td><?php echo $single_bill[0]['patient_address'];?></td>
                    </tr>
                    <tr>
                      
                      <th>Contact number</th>
                      <td><?php echo $single_bill[0]['patient_contact'];?></td>
                    </tr>
                    <tr>
                      
                      <th>Age</th>
                      <td><?php echo $single_bill[0]['patient_age'];?></td>
                    </tr>
                    <tr>
                      
                      <th>Gender</th>
                      <td><?php echo $single_bill[0]['patient_gender'];?></td>
                    </tr>
                    <tr>
                      
                      <th>Email ID</th>
                      <td><?php echo $single_bill[0]['patient_email'];?></td>
                    </tr>
                   
                    <tr>
                      
                      <th>Referer Doctor </th>
                      <?php
                      if($single_bill[0]['referred_by_doctor']!="yes")
                      {
                      	echo "<td>No Refer</td>";
                      }
                      else
                      {
                      	$bill_refer_doctor=$bill->getSingleDoctor($single_bill[0]['doctor_id']);

                      	echo "<td>".$bill_refer_doctor[0]['full_name']."</td>";
                      }

                      ?>
                      
                    </tr>
                   
                    
                  
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
         
          </div>

         </div>
        </div>
     <!--End patient details-->


     <!--Bill content details-->
     <div class="row">
    <!--add test form-->
      <div class="col-sm-12">

         <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">Bill Contents</div>
        <div class="panel-body">
          <p></p>
        </div>

      <!-- Table -->
       <div class="box">    
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped">

                    <tr>
                      
                      <th>#</th>
                      <th>Test Name</th>
                      <th>Subtest Name</th>
                      <th>Cost</th>
                    </tr>

                    <?php
                    $bill_contents=$bill->getBillContents($bill_id);

                       if(empty($bill_contents))
                       {
                        ?>
                          <tr>
                          <td>There is no contents for this bill</td>
                          </tr>
                        <?php
                       }
                       elseif($single_bill[0]['is_special']=="no")
                       {

                       	  $i=1;

                       		foreach($bill_contents as $single_bill_content)
                          {

                            $single_test=$bill->getSingleTest($single_bill_content['test_id']);


                            $single_subtest=$bill->getSingleSubTest($single_bill_content['subtest_id']);

                            if(empty($single_test)||empty($single_subtest))
                              {
                                ?>
                                  <tr>
                                  <td>There is error getting this value</td>
                                  </tr>

                                <?php
                              }
                              else
                              {
                            ?>
                              <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $single_test[0]['name'];?></td>
                                <td><?php echo $single_subtest[0]['name'];?></td>
                                <td><?php echo $single_bill_content['cost'];?></td>
                              </tr>

                            <?php
                              }

                              $i++;
                          }
                       }
                       else
                       {
                        ?>
                        <textarea id="bill_view_special_content">
                          
                          <?php echo $bill_contents[0]['special_bill_content'];?>
                        </textarea>

                        <?php
                       }
                     ?>

                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
         
          </div>

         </div>
        </div>


        <!--End bill content details-->
         </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>