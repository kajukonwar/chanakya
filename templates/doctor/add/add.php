<?php

$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");


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
              ADD NEW DOCTOR
              
            </h3>
        </div>
      </div>
      
    </section>

    <!-- Main content -->
    <section class="content">

    <!--show save result-->
    <?php require_once("$root/lib/include/user/add.php");?>

    <div class="callout callout-success">
             
          <p>
          <?php 

          if(isset($doctor_save_status)&&$doctor_save_status=="success") echo "Doctor detais were added successfully";

          if(isset($doctor_save_status)&&$doctor_save_status=="error") echo "There was error. Doctor details could not be added";




          ?>
          </p>   

     </div>

    <div class="row">
    <!--add test form-->
      <div class="col-sm-12">

      <div class="panel panel-primary ">
          
          <div class="panel-heading text-center">Add new doctor</div>
            
            <div class="panel-body">

        <form class="form-horizontal" name="add_doctor_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

           <div class="form-group">
              <label class="control-label " for="doctor_name">Enter the doctor's full name</label>
            
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="doctor_name" id="doctor_name" aria-describedby="doctor_name" value="<?php if(isset($doctor_save_status)&&$doctor_save_status=="error") echo $_POST['doctor_name'];?>">

                 </div>


           <p style="color:red;"><?php if(isset($doctorErr['name'])) echo $doctorErr['name'];?></p>

           </div>

           <div class="form-group">
              <label class="control-label " for="doctor_email">Enter the email ID</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="email" class="form-control" name="doctor_email" id="doctor_email" aria-describedby="doctor_email" value="<?php if(isset($doctor_save_status)&&$doctor_save_status=="error") echo $_POST['doctor_email'];?>">

                 </div>   


           <p style="color:red;"><?php if(isset($doctorErr['email'])) echo $doctorErr['email'];?></p> 
          
           </div>

           <!--contact number-->
           <div class="form-group">
              <label class="control-label " for="doctor_contact">Enter the doctor's Contact number</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="doctor_contact" id="doctor_contact" aria-describedby="doctor_contact" value="<?php if(isset($doctor_save_status)&&$doctor_save_status=="error") echo $_POST['doctor_contact'];?>">

                 </div>    


           <p style="color:red;"><?php if(isset($doctorErr['contact'])) echo $doctorErr['contact'];?></p>
            
           </div>

           <!--gender-->

           <div class="form-group">
              <label class="control-label " for="doctor_designation">Please enter the designation</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="doctor_designation" id="doctor_designation" aria-describedby="doctor_designation" value="<?php if(isset($doctor_save_status)&&$doctor_save_status=="error") echo $_POST['doctor_designation'];?>">
				         </div>


           <p style="color:red;"><?php if(isset($doctorErr['designation'])) echo $doctorErr['designation'];?></p>
			
           </div>

           <!--address-->
           <div class="form-group">
           <label class="control-label " for="doctor_address">Please enter the address</label>
             
                 <div class="input-group">
                   
           			<textarea name="doctor_address" cols="140"><?php if(isset($doctor_save_status)&&$doctor_save_status=="error") echo $_POST['doctor_address'];?></textarea>
           		 </div>
			
           </div>


           <!--role-->
           <div class="form-group">
            <label class="control-label " for="doctor_hospital">Please enter  the practising hospital</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="doctor_hospital" id="doctor_hospital" aria-describedby="doctor_hospital" value="<?php if(isset($doctor_save_status)&&$doctor_save_status=="error") echo $_POST['doctor_hospital'];?>">
			           </div>


           <p style="color:red;"><?php if(isset($doctorErr['hospital'])) echo $doctorErr['hospital'];?></p>
			
           </div>

          

            <button type="submit" name="save_doctor" class="btn btn-primary">Save</button>
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