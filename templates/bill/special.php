<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';

require_once("$root/include/session_check.php");
//empty the session array whenever this page is opened
if(isset($_SESSION['bill_contents']))
{

  $_SESSION['bill_contents']=array();
}

if($permission=="admin"||$permission=="reception")
{

}
else
{
  die("Unauthorized access");
}


/* The form processing part*/
require_once("$root/lib/classes/class.special.php");


if($_SERVER['REQUEST_METHOD']=="POST"&&isset($_POST['special_bill_save']))
{
  
  $special=new Special();

  $validate=$special->validate($_POST);

  //print_r($_POST);
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

            <h4 class="pull-left">
             <?php

                    $bills=new Helper();

                    //get the last bill
                    $last_bills=$bills->getLastBill();
                    //old bill exists, increase bill no counter
                    if(!empty($last_bills))
                    {

                       $new_bill_no=$last_bills[0]['id']+1;
                 
                     ?>

                     <span class="label label-primary">Bill No. 
                    <?php 

                     echo $new_bill_no;
                  
                    ?>
                     </span>   
                    <?php

                    }
                    //empty bill records--show bill no 1
                    else
                    {

                      ?>
                      <span class="label label-primary"></span>
                      <?php
                    }
            ?>        
            </h4>
            <!--END showing bill no-->

            <h3 class="text-center">
              Create new bill
              
            </h3>

        </div>
      </div>
      
    </section>



<?php


?>

    <!-- Main content -->
    <section class="content">
 
       <form class="form-horizontal" name="add_special_bill" id="add_special_bill" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   
          <!--bill contents-->
            <textarea  name="special_bill_editor" id="special_bill_editor" rows="10" cols="80">
                <?php if(isset($validate['special_bill_editor'])) echo $validate['special_bill_editor'];?>
                
            </textarea>
            <p  style="height:20px;color:red;"><?php if(isset($validate['special_bill_editor_err'])) echo $validate['special_bill_editor_err'];?></p>
         <!--end bill content-->
       
         <!--Bill Cost-->
          <div class="row">
            <div class="col-sm-12">

            <div class="panel panel-primary">
              <div class="panel-heading text-center">Total Cost</div>
              <div class="panel-body">
                <p></p>


                 <div class="form-group">
                    <label class="control-label"  for="bill_cost">Please enter total bill cost<span style="color:red;">*</span></label>
                     
                    <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>

                      <input type="text" class="form-control" name="bill_cost" value="<?php if(isset($validate['bill_cost'])) echo $validate['bill_cost'];?>">

                    </div>
                    <p  style="height:20px;color:red;"><?php if(isset($validate['bill_cost_err'])) echo $validate['bill_cost_err'];?></p>
                  </div>


              </div>
            </div>
            </div>
          </div>

         <!-- END bill cost-->

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
                          

                <div class="row" style="margin-left:15px;">

                 <div class="col-sm-4">
                   <div class="form-group">
                    <label class="control-label"  for="patient_name">Patient name<span style="color:red;">*</span></label>
                     
                    <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                      <input type="text" class="form-control" name="patient_name" value="<?php if(isset($validate['patient_name'])) echo $validate['patient_name'];?>">

                    </div>
                    <p  style="height:20px;color:red;"><?php if(isset($validate['patient_name_err'])) echo $validate['patient_name_err'];?></p>
                   </div>
                  </div>

                  <div class="col-sm-1">
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                    <label class="control-label"  for="patient_contact">Contact number</label>
                     
                    <div class="input-group">
                      
                    <span class="input-group-addon"><i class="fa fa-phone-square" aria-hidden="true"></i></span>
                      <input type="text" class="form-control" name="patient_contact" value="<?php if(isset($validate['patient_contact'])) echo $validate['patient_contact'];?>">

                    </div>
                    <p  style="height:20px;color:red;"><?php if(isset($validate['patient_contact_err'])) echo $validate['patient_contact_err'];?></p>
                   </div>
                   </div>

                   <div class="col-sm-1">
                   </div>

                   <div class="col-sm-2" style="margin-left:40px;">
                   <div class="form-group">
                    <label class="control-label"  for="patient_age">Age<span style="color:red;">*</span></label>
                     
                    <div class="input-group">
                      
                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                      <input type="text" class="form-control" name="patient_age" value="<?php if(isset($validate['patient_age'])) echo $validate['patient_age'];?>">

                    </div>
                    <p  style="height:20px;color:red;"><?php if(isset($validate['patient_age_err'])) echo $validate['patient_age_err'];?></p>
                   </div>
                   </div>
                   </div>

                   <div class="row" style="margin-left:15px;">
                   <div class="col-sm-2">
                    <div class="form-group">
                    <label class="control-label "  for="patient_gender">Gender<span style="color:red;">*</span></label>
                     
                    <div class="input-group">
                      
                    <span class="input-group-addon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>
                      <input type="radio" name="patient_gender" value="male" <?php if(isset($validate['patient_gender'])&&$validate['patient_gender']=="male") echo "checked"; ?>>Male
                      <input type="radio" name="patient_gender" value="female" <?php if(isset($validate['patient_gender'])&&$validate['patient_gender']=="female") echo "checked"; ?>>Female

                    </div>
                    <p  style="height:20px;color:red;"><?php if(isset($validate['patient_gender_err'])) echo $validate['patient_gender_err'];?></p>
                   </div>
                   </div>

                   <div class="col-sm-4">

                   <div class="form-group">
                    <label class="control-label"  for="patient_email">Email</label>
                     
                    <div class="input-group">
                      
                    <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                      <input type="email" class="form-control" name="patient_email" value="<?php if(isset($validate['patient_email'])) echo $validate['patient_email'];?>">
                    </div>
                    <p  style="height:20px;color:red;"><?php if(isset($validate['patient_email_err'])) echo $validate['patient_email_err'];?></p>
                   </div>
                   </div>


                   <div class="col-sm-5" style="margin-left:30px;">

                   <div class="form-group">
                    <label class="control-label"  for="patient_address">Patient Addresss</label>
                     
                    <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-location-arrow" aria-hidden="true"></i></span>
                      <textarea  name="patient_address" class="form-control" cols="10"><?php if(isset($validate['patient_address'])) echo $validate['patient_address'];?></textarea>

                    </div>
                    <p  style="height:20px;color:red;"></p>
                   </div>
                   </div>

              
                      </div>
                        <!-- /.box-body -->
                    </div>
                  </div>  <!-- /.box --> 

       </div><!--end pannel-->
      </div><!--end coloumn-->
      </div><!--end row-->
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

       <div class="box">    
        <!-- /.box-header -->
        <div class="box-body no-padding">
        <div class="row" style="margin-left:15px;">
        <div class="col-sm-4">
          <div class="form-group">
            <label class="control-label"  for="doctor_refer">Referenced By Doctor?<span style="color:red;">*</span></label>
             
            <div class="input-group">
              
            <span class="input-group-addon"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
              <input type="radio" name="doctor_refer" value="yes" <?php if(isset($validate['doctor_refer'])&&$validate['doctor_refer']=="yes") echo "checked"; ?>>Yes
              <input type="radio" name="doctor_refer" value="no" <?php if(isset($validate['doctor_refer'])&&$validate['doctor_refer']=="no") echo "checked"; ?>>No

            </div>
            <p  style="height:20px; margin-left:10px;color:red;"><?php if(isset($validate['doctor_refer_err'])) echo $validate['doctor_refer_err'];?></p>
          </div>
          </div>

          <div class="col-sm-8">
           <div class="form-group"  <?php if(!isset($validate['doctor_refer'])||(isset($validate['doctor_refer'])&&$validate['doctor_refer']=="no")) echo 'style="display:none;"'; ?>id="special_bill_doctor_name">
            <label class="control-label"  for="bill_doctor_name">Doctor name</label>
             
            <div class="input-group">
              
            <span class="input-group-addon"><i class="fa fa-user-md" aria-hidden="true"></i></span>
              <select class="form-control" name="bill_doctor_name">
              <option value="0" <?php if(!isset($validate['bill_doctor_name'])) echo "selected";?>>Click to select Doctor</option>
                <?php 
                   $doctors=new Helper();
                   $available_doctors=$doctors->getDoctors();

                   foreach($available_doctors as $single_doctor)
                   {



                ?>

                  <option value="<?php echo $single_doctor['id'];?>" 
                  <?php if(isset($validate['bill_doctor_name'])&&$validate['bill_doctor_name']==$single_doctor['id']) echo "selected";?>

                  >
                  <?php echo $single_doctor['full_name'];?>
                    

                  </option>
                <?php
                  }
                ?>
            
              </select>
            </div>
            <p  style="height:20px; margin-left:50px;color:red;"><?php if(isset($validate['bill_doctor_name_err'])) echo $validate['bill_doctor_name_err'];?></p>
          </div>
          </div>
          </div>
          </div>
          <!-- /.box-body -->
          </div>
        <!-- /.box -->        
       </div><!--End panel-->
      </div><!-- end coloumn-->
     </div><!--end row-->
     <!--end doctor details-->
     <button type="submit" class="btn btn-primary" name="special_bill_save">Save</button>
      </form>
    </section>
    <!-- / main content -->
    
     <hr>
  </div>
  <!-- /.content-wrapper -->
 
  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>