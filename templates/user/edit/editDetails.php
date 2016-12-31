<?php
if(isset($_GET['s_id']))
{
  $s_id=$_GET['s_id'];
}
elseif(!empty($_POST['s_id']))
{
  $s_id=$_POST['s_id'];
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
              EDIT  STAFF DETAILS
              
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

          if(isset($update_staff)&&$update_staff=="success") echo "Staff details were updated successfully";

          if(isset($update_staff)&&$update_staff=="error") echo "There was error. Staff details could not be updated";




          ?>
          </p>   

     </div>



    <?php 
      require_once("$root/lib/classes/class.helper.php");
      $list_staff=new Helper();
      $single_staff=$list_staff->getSingleStaff($s_id);
   ?>

    <div class="row">
    <!--add test form-->
      <div class="col-sm-12">

        <div class="panel panel-primary ">
          
          <div class="panel-heading text-center">Edit this staff</div>
            
            <div class="panel-body">

        <form class="form-horizontal" name="edit_user_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


        <input type="hidden" name="s_id" value="<?php echo $s_id;?>">

           <div class="form-group">
              <label class="control-label" for="user_name">Please enter user's full name</label>
            
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="user_name" id="user_name" aria-describedby="user_name" value="<?php echo $single_staff[0]['full_name'];?>">

                 </div>

           <p style="color:red;"><?php if(isset($checkErr['name'])) echo $checkErr['name'];?></p>
           </div>

           <div class="form-group">
              <label class="control-label" for="user_email">Please enter the user's email ID</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="email" class="form-control" name="user_email" id="user_email" aria-describedby="user_email" value="<?php echo $single_staff[0]['email'];?>">

                 </div>    
              
           <p style="color:red;"><?php if(isset($checkErr['email'])) echo $checkErr['email'];?></p>
           </div>


           <!--contact number-->
           <div class="form-group">
              <label class="control-label" for="user_contact">Pleae enter the user's Contact number</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                   <input type="text" class="form-control" name="user_contact" id="user_contact" aria-describedby="user_contact" value="<?php echo $single_staff[0]['contact'];?>">

                 </div>    
              
           <p style="color:red;"><?php if(isset($checkErr['contact'])) echo $checkErr['contact'];?></p>
           </div>


           <!--gender-->

           <div class="form-group">
              <label class="control-label" for="user_gender">Please choose the gender</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
             
          <label class="radio-inline">
                <input type="radio" name="user_gender"  value="male" <?php if($single_staff[0]['gender']=="male") echo "checked";?>> Male
          </label>
          <label class="radio-inline">
              <input type="radio" name="user_gender"  value="female"  <?php if($single_staff[0]['gender']=="female") echo "checked";?>> female
          </label>
         </div>


           <p style="color:red;"><?php if(isset($checkErr['gender'])) echo $checkErr['gender'];?></p>
      
           </div>


           <!--address-->
           <div class="form-group">
           <label class="control-label" for="user_address">Please enter the address</label>
             
                 <div class="input-group">
                   
                <textarea name="user_address" cols="140"><?php echo $single_staff[0]['address'];?></textarea>
               </div>


           <p style="color:red;"><?php if(isset($checkErr['address'])) echo $checkErr['address'];?></p>
      
           </div>


           <!--role-->
           <div class="form-group">
            <label class="control-label" for="user_role">Please choose the user role</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                    <select class="form-control" class="form-control"  name="user_role">
                <option value="admin" <?php if($single_staff[0]['role']=="admin") echo "selected";?>>admin</option>
                <option value="staff" <?php if($single_staff[0]['role']=="staff") echo "selected";?>>staff</option>
          
              </select>
           </div>


           <p style="color:red;"><?php if(isset($checkErr['role'])) echo $checkErr['role'];?></p>
      
           </div>


           <!--login user name-->
           <div class="form-group">
           <label class="control-label" for="user_login">Please choose a  login user name</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                <input type="text" name="user_login" class="form-control" class="form-control" value="<?php echo $single_staff[0]['user_name'];?>">
               </div>


           <p style="color:red;"><?php if(isset($checkErr['login'])) echo $checkErr['login'];?></p>
      
           </div>


           <!--login password-->
            <div class="form-group">
             <label class="control-label" for="user_password">Please choose a  login password</label>
             
                 <div class="input-group">
                   <span class="input-group-addon">@</span>
                <input type="password" name="user_password" class="form-control"  value="<?php echo $single_staff[0]['password'];?>">
               </div>


           <p style="color:red;"><?php if(isset($checkErr['password'])) echo $checkErr['password'];?></p>
      
           </div>



            <button type="submit" name="update_staff" class="btn btn-primary">Save</button>
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