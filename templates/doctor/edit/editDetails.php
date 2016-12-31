<?php
if(isset($_GET['d_id']))
{
  $d_id=$_GET['d_id'];
}
elseif(!empty($_POST['d_id']))
{
  $d_id=$_POST['d_id'];
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
              EDIT DOCTOR DETAILS
              
            </h3>
        </div>
      </div>
      
    </section>

    <!-- Main content -->
    <section class="content">

    <!--show save result-->
    <?php require_once("$root/lib/include/user/edit.php");?>

    <div class="callout callout-success">
             
          <p>
          <?php 

          if(isset($update_doctor)&&$update_doctor=="success") echo "Doctor detais were added successfully";

          if(isset($update_doctor)&&$update_doctor=="error") echo "There was error. Doctor details could not be added";




          ?>
          </p>   

     </div>

    <?php 
      require_once("$root/lib/classes/class.helper.php");
      $list_doctor=new Helper();
      $single_doctor=$list_doctor->getSingleDoctor($d_id);
   ?>

    <div class="row">
    <!--add test form-->
      <div class="col-sm-12">

      <div class="panel panel-primary ">
          
          <div class="panel-heading text-center">Add new doctor</div>
            
            <div class="panel-body">

        <form class="form-horizontal" name="edit_doctor_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <input type="hidden" name="d_id" value="<?php echo $d_id;?>">

           <div class="form-group">
              <label class="control-label" for="doctor_name">Enter the doctor's full name</label>
            
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="doctor_name" id="doctor_name" aria-describedby="doctor_name" value="<?php echo $single_doctor[0]['full_name'];?>">

                 </div>

           <p style="color:red;"><?php if(isset($checkErr['name'])) echo $checkErr['name'];?></p>
           </div>

           <div class="form-group">
              <label class="control-label" for="doctor_email">Enter the email ID</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="email" class="form-control" name="doctor_email" id="doctor_email" aria-describedby="doctor_email" value="<?php echo $single_doctor[0]['email'];?>">

                 </div>    


            <p style="color:red;"><?php if(isset($checkErr['email'])) echo $checkErr['email'];?></p>
          
           </div>

           <!--contact number-->
           <div class="form-group">
              <label class="control-label" for="doctor_contact">Enter the doctor's Contact number</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="doctor_contact" id="doctor_contact" aria-describedby="doctor_contact" value="<?php echo $single_doctor[0]['contact'];?>">

                 </div>    


           <p style="color:red;"><?php if(isset($checkErr['contact'])) echo $checkErr['contact'];?></p>
            
           </div>


           <!--gender-->

           <div class="form-group">
              <label class="control-label" for="doctor_designation">Please enter the designation</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="doctor_designation" id="doctor_designation" aria-describedby="doctor_designation" value="<?php echo $single_doctor[0]['designation'];?>">
				         </div>


           <p style="color:red;"><?php if(isset($checkErr['designation'])) echo $checkErr['designation'];?></p>
			
           </div>


           <!--address-->
           <div class="form-group">
           <label class="control-label" for="doctor_address">Please enter the address</label>
             
                 <div class="input-group">
                   
           			<textarea name="doctor_address" cols="140"><?php echo $single_doctor[0]['address'];?></textarea>
           		 </div>
			
           </div>

           <!--role-->
           <div class="form-group">
            <label class="control-label" for="doctor_hospital">Please enter  the practising hospital</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="doctor_hospital" id="doctor_hospital" aria-describedby="doctor_hospital" value="<?php echo $single_doctor[0]['hospital'];?>">
			           </div>


           <p style="color:red;"><?php if(isset($checkErr['hospital'])) echo $checkErr['hospital'];?></p>
			
           </div>

          

            <button type="submit" name="update_doctor" class="btn btn-primary">Save</button>
            <button class="btn btn-danger" type="reset">Reset</button>
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