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
              ADD NEW USER
              
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

          if(isset($staff_object)&&$staff_object=="success") echo "Staff was added successfully";

          if(isset($staff_object)&&$staff_object=="error") echo "There was error. Staff could not be added";




          ?>
          </p>   

     </div>

    <div class="row">
    <!--add test form-->
      <div class="col-sm-12">


        <div class="panel panel-primary ">
          
          <div class="panel-heading text-center">Add new user</div>
            
            <div class="panel-body">

        <form class="form-horizontal" name="add_user_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

           <div class="form-group">
              <label class="control-label" for="user_name">Please enter the user's full name</label>
            
                 <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                   <input type="text" class="form-control" name="user_name" id="user_name" aria-describedby="user_name" value="<?php if(isset($_POST['user_name'])) echo $_POST['user_name'];?>">

                 </div>


           <p style="color:red;"><?php if(isset($staffErr['name'])) echo $staffErr['name'];?></p>

           </div>


           <div class="form-group">
              <label class="control-label" for="user_email">Please enter the user's email ID</label>
             
                 <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                   <input type="email" class="form-control" name="user_email" id="user_email" aria-describedby="user_email" value="<?php if(isset($_POST['user_email'])) echo $_POST['user_email'];?>">

                 </div>    
              
            <p style="color:red;"><?php if(isset($staffErr['email'])) echo $staffErr['email'];?></p>
           </div>


           <!--contact number-->
           <div class="form-group">
              <label class="control-label" for="user_contact">Please enter the user's Contact number</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="user_contact" id="user_contact" aria-describedby="user_contact" value="<?php if(isset($_POST['user_contact'])) echo $_POST['user_contact'];?>">

                 </div>    
              
            <p style="color:red;"><?php if(isset($staffErr['contact'])) echo $staffErr['contact'];?></p>
           </div>


           <!--gender-->

           <div class="form-group">
              <label class="control-label" for="user_gender">Please choose the gender</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
             
					<label class="radio-inline">
  							<input type="radio" name="user_gender"  value="male" <?php if(isset($_POST['user_gender'])){if($_POST['user_gender']=="male") echo "checked";} ?>> Male
					</label>
					<label class="radio-inline">
  						<input type="radio" name="user_gender"  value="female" <?php if(isset($_POST['user_gender'])){if($_POST['user_gender']=="female") echo "checked";} ?>> female
					</label>
				 </div>
			   
            <p style="color:red;"><?php if(isset($staffErr['gender'])) echo $staffErr['gender'];?></p>
           </div>


           <!--address-->
           <div class="form-group">
           <label class="control-label" for="user_address">Please enter the address</label>
             
                 <div class="input-group">
                   
           			<textarea name="user_address" cols="140"><?php if(isset($_POST['user_address'])) echo $_POST['user_address'];?></textarea>
           		 </div>
			       
           <p style="color:red;"><?php if(isset($staffErr['address'])) echo $staffErr['address'];?></p>
           </div>


           <!--role-->
           <div class="form-group">
            <label class="control-label" for="user_role">Please choose the user role</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                    <select class="form-control" name="user_role">
  				      
                <option value="0" <?php if(isset($_POST['user_role'])){if($_POST['user_role']=="0") echo "selected";} ?>>Click to select the user role</option>
  				      <option value="staff" <?php if(isset($_POST['user_role'])){if($_POST['user_role']=="staff") echo "selected";} ?>>staff</option>
                <option value="admin" <?php if(isset($_POST['user_role'])){if($_POST['user_role']=="admin") echo "selected";} ?>>admin</option>
  				
			        </select>
			     </div>
			       
            <p style="color:red;"><?php if(isset($staffErr['role'])) echo $staffErr['role'];?></p>
           </div>



           <!--login user name-->
           <div class="form-group">
           <label class="control-label" for="user_login">Please choose a  login user name</label>
             
                 <div class="input-group">
                   <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
            		<input type="text" name="user_login" class="form-control" aria-describedby="user_login" value="<?php if(isset($_POST['user_login'])) echo $_POST['user_login'];?>">
            	 </div>
			       
            <p style="color:red;"><?php if(isset($staffErr['login'])) echo $staffErr['login'];?></p>
           </div>

           <!--login password-->
            <div class="form-group">
             <label class="control-label" for="user_password">Please choose a  login password</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
            		<input type="password" name="user_password" class="form-control" value="<?php if(isset($_POST['user_password'])) echo $_POST['user_password'];?>">
            	 </div>
			         
            <p style="color:red;"><?php if(isset($staffErr['password'])) echo $staffErr['password'];?></p>
           </div>

           <div class="text-center">

            <button type="submit" name="save_staff" class="btn btn-primary">Save</button>
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