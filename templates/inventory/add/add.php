<?php
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
            <h3 class="text-center">
              ADD NEW INVENTORY
              
            </h3>
        </div>
      </div>

    <!--show save result-->
    <?php require_once("$root/lib/include/inventory/add.php");?>

      <div class="callout callout-success">
             
          <p>
          <?php 

          if(isset($save_department)&&$save_department=="success") echo "Department was saved successfully";

          if(isset($save_department)&&$save_department=="error") echo "There was error. Department could not be saved";

          if(isset($save_test)&&$save_test=="success") echo "Test was saved successfully";

          if(isset($save_test)&&$save_test=="error") echo "There was error. Test could not be saved";


          if(isset($save_subtest)&&$save_subtest=="success") echo "Subtest was saved successfully";

          if(isset($save_subtest)&&$save_subtest=="error") echo "There was error. Subtest could not be saved";



          ?>
          </p>   

     </div>
      
    </section>

    
    <!-- Main content -->
    <section class="content">


    <div class="row">
    <div class="col-sm-6">
        <div class="panel panel-primary ">
                <div class="panel-heading text-center">Add new Department</div>
                <div class="panel-body">
                   <form class="form-horizontal" name="add_department_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                       <div class="form-group">
                    <label class="control-label" for="department_name"><p >Please enter the Department name<span style="color:red">*</span></p></label>
                   
                       <div class="input-group">
                         <span class="input-group-addon"><i class="fa fa-hospital-o" aria-hidden="true"></i>
</span>
                         <input type="text" class="form-control" name="department_name" id="department_name" aria-describedby="department_name">

                       </div>
                       <p   id="department_name_err" style="color:red;"><?php if(isset($department_name_err)) echo $department_name_err;?></p>
                    
                    <div class="text-center">
                      <button type="submit" name="save_department" class="btn btn-primary">Save</button>
                      <button class="btn btn-danger" type="reset">Reset</button>
                    </div>
                   
                 </div>

                </form>
              </div>
                
            </div> 

    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary ">
                <div class="panel-heading text-center">Add new Test</div>
                <div class="panel-body">
                   <form class="form-horizontal" name="add_test_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                    <div class="form-group">
                    <label class="control-label" for="test_name"><p >Please enter the Test name<span style="color:red">*</span></p></label>
                   
                       <div class="input-group">
                         <span class="input-group-addon"><i class="fa fa-medkit" aria-hidden="true"></i></span>
                         <input type="text" class="form-control" name="test_name" id="test_name" aria-describedby="test_name">

                       </div>
                       <p id="test_name_err" style="color:red;"><?php if(isset($test_name_err)) echo $test_name_err;?></p>
                    </div>

               
                 
                  <!--
                  <div class="form-group">
                    <label class="control-label" for="test_has_subtest">Does this test have subtests?</label>
                   
                      <div class="input-group">
                        <span class="input-group-addon">@</span>
                     
                            <label class="radio-inline">
                              <input type="radio" name="test_has_subtest"  value="yes"> Yes
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="test_has_subtest"  value="no"> No
                            </label>
                      </div>


                       <p id="test_has_subtest_err"><?php if(isset($checkTestErr)) echo $checkTestErr[2];?></p>                  
                 </div>

                  <div class="form-group" id="test_department_name" style="display:none;">
                    <label class="control-label" for="test_department_name">Please select the related department</label>
                   
                      <div class="input-group">
                        <span class="input-group-addon">@</span>
                     
                            <select class="form-control" name="test_department_name">


                            <option value="0">Click to select a department</option>

                            <?php

                             require_once("$root/lib/classes/class.helper.php");

                             $list_departments=new Helper();

                             $departments=$list_departments->getDepartments();



                             foreach($departments as $single_department)
                             {

                              ?>

                            <option value="<?php echo $single_department['id'];?>"><?php echo $single_department['name'];?></option>

                              <?php
                             }
                            ?>
                
                      
                          </select>
                      </div> 


                       <p id="test_department_err"><?php if(isset($checkTestErr)) echo $checkTestErr[3];?></p>                             
                 </div>
                 -->


                 <div class="form-group">
                    <div class="text-center">
                      <button type="submit" name="save_test" class="btn btn-primary">Save</button>
                      <button class="btn btn-danger" type="reset">Reset</button>
                    </div>
                 </div>
                   


                </form>
              </div>
                
            </div>
    </div>
    </div>

    <div class="row">
     
      <div class="col-sm-12">
             
        <div class="panel panel-primary">
        <div class="panel-heading text-center">Add new Subtest</div>
          <div class="panel-body">
            <form class="form-horizontal" name="add_subtest_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
           
           <div class="form-group">
              <label class="control-label" for="subtest_name"><p>Please enter the subtest name <span style="color:red">*</span></p></label>
            
                 <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
                   <input type="text" class="form-control" name="subtest_name" id="subtest_name" aria-describedby="subtest_name">

                 </div>

                 <p style="color:red;"><?php if(isset($checkSubErr)) echo $checkSubErr[1];?></p>
                
           </div>

           <div class="form-group">
              <label class="control-label" for="test_id">Please select the related test<span style="color:red">*</span></label>

              <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-medkit" aria-hidden="true"></i></span>

              <select class="form-control" name="test_id">
              <option value="0">Click to select a test</option>
              <!--get the test list-->
              <?php
             require_once("$root/lib/classes/class.helper.php");
             $list_test=new Helper();
             $list_of_test=$list_test->getTest();
             if(empty($list_of_test))
             {
                ?>

                 <option value='0'>Error:No tests found</option>
                 <?php
             }
             else
             {
             foreach($list_of_test as $single_test)
             {
             ?>

                 <option value='<?php echo $single_test['id'];?>'><?php echo $single_test['name'];?></option>
              <?php
              }
              }
              ?>
              </select>
              </div>
              <p style="color:red;" ><?php if(isset($checkSubErr)) echo $checkSubErr[2];?></p>
           </div>

           <div class="form-group">
              <label class="control-label" for="department_id">Please select the related department<span style="color:red">*</span></label>


              <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
              <select class="form-control" name="department_id">

              <option value="0">Click to select a department</option>

                            <?php

                             require_once("$root/lib/classes/class.helper.php");

                             $list_departments=new Helper();

                             $departments=$list_departments->getDepartments();

                              if(empty($departments))
                             {
                                ?>

                                 <option value='0'>Error:No department found</option>
                                 <?php
                             }
                             else
                             {
                             foreach($departments as $single_department)
                             {

                              ?>

                            <option value="<?php echo $single_department['id'];?>"><?php echo $single_department['name'];?></option>

                              <?php
                             }
                            }
                         ?>
             
              </select>
              </div>
              <p style="color:red;"><?php if(isset($checkSubErr)) echo $checkSubErr[6];?></p>
           </div>

           <div class="form-group">
             <label class="control-label" for="unit_name">Please enter the unit<span style="color:red">*</span></label> 
             <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-cog" aria-hidden="true"></i></span>
                   <input type="text" class="form-control" name="unit_name" id="unit_name" aria-describedby="unit_name">

               </div>
               <p style="color:red;"><?php if(isset($checkSubErr)) echo $checkSubErr[3];?></p>
           </div>

             <div class="form-group">
             <label class="control-label" for="default_value">Please enter the default value<span style="color:red">*</span></label> 
             <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-align-justify" aria-hidden="true"></i></span>
                   <input type="text" class="form-control" name="default_value" id="default_value" aria-describedby="default_value">

               </div>
               <p style="color:red;"><?php if(isset($checkSubErr))  echo $checkSubErr[4];?></p>
           </div>

           <div class="form-group">
             <label class="control-label" for="price">Please enter the standard price<span style="color:red">*</span></label> 
             <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-inr" aria-hidden="true"></i></span>
                   <input type="text" class="form-control" name="price" id="price" aria-describedby="price">

               </div>

               <p style="color:red;"><?php if(isset($checkSubErr)) echo $checkSubErr[5];?></p>

           </div>

              <div class="text-center">
                <button type="submit" name="save_subtest" class="btn btn-primary">Save</button>
                <button class="btn btn-danger" type="reset">Reset</button>
              </div>
           

            </form>
          </div>
         
        </div>
               
      </div><!--end col-->
    
    </div><!--end row-->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
<?php require_once("$root/include/footer.php");?>