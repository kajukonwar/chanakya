<?php
session_start();
if(isset($_SESSION['bill_contents']))
{

  $_SESSION['bill_contents']=array();
}
$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";


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

            <h4 class="pull-left">
             <?php

                    $bills=new Helper();

                    $last_bills=$bills->getLastBill();

                    

                    if(!empty($last_bills))
                    {

                      $new_bill_no=$last_bills[0]['id']+1;
                 
             ?>

            <span class="label label-primary" id="bill_no">Bill No. 
            <?php 

           echo $new_bill_no;
                
            ?>
              

            </span>   
            <?php

            }
            ?>        
            </h4>

            <h3 class="text-center">
              Create new bill
              
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
    
    
    <hr>
    <div class="row">
    <!--add test form-->
      <div class="col-sm-12">

        <form class="form-inline" name="add_bill_form" id="add_bill_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

       

           <!--role-->
           <div class="form-group" id="bill_test_group">
            <label class="control-label" for="bill_test_name">Test&nbsp;&nbsp;</label>
             
            <div class="input-group" >
              
              <span class="input-group-addon"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
              <select class="form-control" name="bill_test_name" id="bill_test_name">

                  <option value="0">Click to choose a Test</option>

                <?php 
                   $tests=new Helper();
                   $available_tests=$tests->getTest();

                   foreach($available_tests as $single_test)
                   {



                ?>

                  <option value="<?php echo $single_test['id'];?>"><?php echo $single_test['name'];?></option>
                <?php
                  }
                ?>
                </select>
            </div>
            <p id="bill_test_name_err" style="color:red;"></p>
      
           </div>


           <div class="form-group" id="bill_subtest_group" >
            <label class="control-label"  for="bill_subtest_name">Subtest&nbsp;&nbsp;</label>
             
            <div class="input-group">

            <span class="input-group-addon"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
            
              <select class="form-control" name="bill_subtest_name" id="bill_subtest_name" disabled>

                  
                <!--
                <?php 
                   $subtests=new Helper();
                   $available_subtests=$subtests->getSubTest();

                   foreach($available_subtests as $single_subtest)
                   {



                ?>

                  <option value="<?php echo $single_subtest['id'];?>"><?php echo $single_subtest['name'];?></option>
                <?php
                  }
                ?>
                -->
                </select>
              
            </div>
            <p id="bill_subtest_name_err" style="color:red;"></p>
           </div>


            <div class="form-group">

              <label class="control-label" for="bill_cost">Cost&nbsp;</label>

            <div class="input-group">

            <span class="input-group-addon"><i class="fa fa-inr" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="bill_cost" id="bill_cost" disabled> 

             </div>

             <p id="bill_cost_err" style="color:red;"></p>

            </div>

            <div class="form-group">

              <label class="control-label" for="bill_cost">&nbsp;&nbsp;</label>

            <div class="input-group">
            <button type="button" name="add_bill_item" id="add_bill_item" class="btn btn-primary">Add to bill</button>
            </div>

             <p></p>

            </div>
            <!--
            <button class="btn btn-danger" type="reset">Reset</button>
            -->
     
            
        </form>


      </div><!--end col-->
      
    
    </div><!--end row-->
    <hr>
    <p id="bill_contents_err"></p>
    <!--bill contents-->
    <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">Bill Contents</div>
        <div class="panel-body">
          <p style="color:red;"></p>
        </div>

      <!-- Table -->
       <div class="box">
      
       <input type="hidden" id="bill_item_count" value="0">

      
       <input type="hidden" id="bill_item_index" value="0">
       
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped" id="bill_content_table">

                    <tr>
                      
                      <th style="width: 10px">#</th>
                      <th>Test</th>
                      <th>SubTest</th>
                      <th>Department</th>
                      <th>Cost</th>
                      <th></th>
                    </tr>
                   
                    
                  
                  </table>
                </div>
                <!-- /.box-body -->
        </div>
        <!-- /.box -->
         
       </div>
     
      </div>
    </div>
    <!--end bill content-->
    <!--patient details-->

    <div class="row">
      <div class="col-sm-12">

      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">Patient details</div>
        <div class="panel-body">
          <p></p>
        </div>

      <!-- Table -->
       <div class="box">
      
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  

        <form class="form-horizontal" name="add_bill_patient" id="add_bill_patient" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <div class="row" style="margin-left:15px;">
         <div class="col-sm-4">
           <div class="form-group">
            <label class="control-label"  for="patient_name">Patient name</label>
             
            <div class="input-group">

            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="patient_name">

            </div>
            <p id="patient_name_err" style="color:red;"></p>
           </div>
          </div>

          <div class="col-sm-4">

            <div class="form-group">

            <label class="control-label"  for="patient_contact">Contact number</label>
             
            <div class="input-group">
              
            <span class="input-group-addon"><i class="fa fa-phone-square" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="patient_contact">

            </div>
            <p id="patient_contact_err" style="color:red;"></p>
           </div>
           </div>

           <div class="col-sm-2">
           <div class="form-group">
            <label class="control-label"  for="patient_age">Age</label>
             
            <div class="input-group">
              
            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
              <input type="text" class="form-control" name="patient_age">

            </div>
            <p id="patient_age_err" style="color:red;"></p>
           </div>
           </div>
           </div>

           <div class="row" style="margin-left:15px;">
           <div class="col-sm-4">
            <div class="form-group">
            <label class="control-label "  for="patient_gender">Gender</label>
             
            <div class="input-group">
              
            <span class="input-group-addon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>
              <input type="radio" name="patient_gender" value="male">Male
              <input type="radio" name="patient_gender" value="female">Female

            </div>
            <p id="patient_gender_err" style="color:red;"></p>
           </div>
           </div>

           <div class="col-sm-4">

           <div class="form-group">
            <label class="control-label"  for="patient_email">Email</label>
             
            <div class="input-group">
              
            <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
              <input type="email" class="form-control" name="patient_email">
            </div>
            <p id="patient_email_err" style="color:red;"></p>
           </div>
           </div>


           <div class="col-sm-4">

           <div class="form-group">
            <label class="control-label"  for="patient_address">Patient Addresss</label>
             
            <div class="input-group">

            <span class="input-group-addon"><i class="fa fa-location-arrow" aria-hidden="true"></i></span>
              <textarea  name="patient_address" class="form-control"></textarea>

            </div>
            <p id="patient_address_err" style="color:red;"></p>
           </div>
           </div>

           

            

           



        </form>
              </div>
                <!-- /.box-body -->
            </div>
              <!-- /.box -->        
       </div>
      </div>
      </div>
    <!--end patient details-->

    <!--doctor details-->
    <div class="row">
      <div class="col-sm-12">

      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading text-center">Doctor details</div>
        <div class="panel-body">
          <p></p>
        </div>

      <!-- Table -->
       <div class="box">
      
              <!-- /.box-header -->
            <div class="box-body no-padding">
                  

        <form class="form-inline" name="add_bill_doctor" id="add_bill_doctor" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <div class="row" style="margin-left:15px;">
        <div class="col-sm-4">
          <div class="form-group">
            <label class="control-label"  for="doctor_refer">Referenced By Doctor?</label>
             
            <div class="input-group">
              
            <span class="input-group-addon"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
              <input type="radio" name="doctor_refer" value="yes">Yes
              <input type="radio" name="doctor_refer" value="no">No

            </div>
            <p id="doctor_refer_err" style="color:red;"></p>
          </div>
          </div>

          <div class="col-sm-8">
           <div class="form-group" id="bill_doctor_name" style="display:none;">
            <label class="control-label"  for="bill_doctor_name">Doctor name</label>
             
            <div class="input-group">
              
            <span class="input-group-addon"><i class="fa fa-user-md" aria-hidden="true"></i></span>
              <select class="form-control" name="bill_doctor_name">
              <option value="0" selected>Click to select Doctor</option>
                <?php 
                   $doctors=new Helper();
                   $available_doctors=$doctors->getDoctors();

                   foreach($available_doctors as $single_doctor)
                   {



                ?>

                  <option value="<?php echo $single_doctor['id'];?>"><?php echo $single_doctor['full_name'];?></option>
                <?php
                  }
                ?>
            
              </select>
            </div>
            <p id="bill_doctor_name_err" style="color:red;"></p>
          </div>
          </div>
          </div>

        </form>
              </div>
                <!-- /.box-body -->
            </div>
              <!-- /.box -->        
       </div>
      </div>
     <!--end doctor details-->
    </div>





   <hr>

   <!--bloddy hell--just save everything-->
    <div class="panel panel-default">
      <div class="panel-body text-center">
        
          <button type="button" name="save_bill" id="save_bill" class="btn-primary btn-lg">Save</button>
          <!--
          <button type="button"  class="btn-primary btn-lg">Reset</button>

          <button type="button" class="btn-primary btn-lg">Cancel</button>
          -->
      </div>
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>