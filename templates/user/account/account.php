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