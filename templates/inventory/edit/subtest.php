<?php
if(isset($_GET['subtest_id']))
{
  $subtest_id=$_GET['subtest_id'];
}
elseif(!empty($_POST['subtest_id']))
{
  $subtest_id=$_POST['subtest_id'];
}
else
{

  die("Unauthorized access");
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
            <h3 class="text-center">
              EDIT SUBTEST
              
            </h3>
        </div>
      </div>
      
    </section>

    <!-- Main content -->
    <section class="content">

    <!--show save result-->
    <?php require_once("$root/lib/include/inventory/edit.php");?>

      <div class="callout callout-success">
             
          <p>
          <?php 


          if(isset($update_subtest)&&$update_subtest=="success") echo "Subtest was updated successfully";

          if(isset($update_subtest)&&$update_subtest=="error") echo "There was error. Subtest could not be updated";




          ?>
          </p>   

     </div>


    <?php 
     require_once("$root/lib/classes/class.helper.php");
      $list_subtest=new Helper();
      $single_subtest=$list_subtest->getSingleSubTest($subtest_id);
    ?>
    <div class="row">
    <!--edit subtest form-->
      <div class="col-sm-12">

        <div class="panel panel-primary">
        <div class="panel-heading text-center">Edit this Subtest</div>
          <div class="panel-body">
            
               
        <form class="form-horizontal" name="edit_subtest_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
           <div class="col-sm-12">
           <input type="hidden" name="subtest_id" value="<?php echo $subtest_id;?>">
           <div class="form-group">
              <label class="control-label" for="subtest_name">Enter the subtest name</label>
            
                 <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
                   <input type="text" class="form-control" name="subtest_name" id="subtest_name" aria-describedby="subtest_name" value="<?php echo $single_subtest[0]['name'];?>">

                 </div>
                <p style="color:red;"><?php if(!empty($checkSubTestErr[1])) echo $checkSubTestErr[1];?></p>
           </div>
           

           <div class="form-group">
              <label class="control-label" for="test_id">Select the related test</label>

              <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-medkit" aria-hidden="true"></i></span>
              <select class="form-control" name="test_id">
              <!--get the test list-->
              <?php
             require_once("$root/lib/classes/class.helper.php");
             $list_test=new Helper();
             $list_of_test=$list_test->getTest();

             if(empty($list_of_test))
              {
                  ?>

                    <option value='0'>Error:No Test found</option>
              <?php
              }
              else
              {
                 foreach($list_of_test as $single_test)
                 {
                 ?>

                     <option value='<?php echo $single_test['id'];?>' <?php if($single_subtest[0]['test_id']==$single_test['id']) echo "selected";?>><?php echo $single_test['name'];?></option>
                  <?php
                  }
              }

              ?>
              </select>
              </div>
              
           <p style="color:red;"><?php if(!empty($checkSubTestErr[2])) $checkSubTestErr[2];?></p>
           </div>

              <div class="form-group">
              <label class="control-label" for="department_id">Please select the related department<span style="color:red">*</span></label>


              <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
              <select class="form-control" name="department_id">


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

                            <option value="<?php echo $single_department['id'];?>" <?php if($single_subtest[0]['department_id']==$single_department['id']) echo "selected";?>><?php echo $single_department['name'];?></option>

                              <?php
                             }
                            }
                         ?>
             
              </select>
              </div>
              <p style="color:red;"><?php if(isset($checkSubTestErr[6])) echo $checkSubTestErr[6];?></p>
           </div>


           <div class="form-group">
             <label class="control-label" for="unit_name">Enter the unit</label> 
             <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-cog" aria-hidden="true"></i></span>
                   <input type="text" class="form-control" name="unit_name" id="unit_name" aria-describedby="unit_name" value="<?php echo $single_subtest[0]['unit'];?>">

               </div>

           <p style="color:red;"><?php if(!empty($checkSubTestErr[3])) echo $checkSubTestErr[3];?></p>
           </div>

             <div class="form-group">
             <label class="control-label" for="default_value">Enter the default value</label> 
             <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-align-justify" aria-hidden="true"></i></span>
                   <input type="text" class="form-control" name="default_value" id="default_value" aria-describedby="default_value" value="<?php echo $single_subtest[0]['default_value'];?>">

               </div>

           <p style="color:red;"><?php if(!empty($checkSubTestErr[4])) echo $checkSubTestErr[4];?></p>
           </div>


           <div class="form-group">
             <label class="control-label" for="price">Enter the standard price</label> 
             <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-inr" aria-hidden="true"></i></span>
                   <input type="text" class="form-control" name="price" id="price" aria-describedby="price" value="<?php echo $single_subtest[0]['standard_price'];?>">

               </div>

           <p style="color:red;"><?php if(!empty($checkSubTestErr[5])) echo $checkSubTestErr[5];?></p>
           </div>


            <div class="text-center">
                <button type="submit" name="update_subtest" class="btn btn-primary">Save</button>
                <button class="btn btn-danger" type="reset">Reset</button>
             </div>

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