<?php

$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");

if(isset($_GET['test_id']))
{
  $test_id=$_GET['test_id'];
}
elseif(!empty($_POST['test_id']))
{
  $test_id=$_POST['test_id'];
}
else
{

  die("Unauthorized access");
}

$root=realpath($_SERVER["DOCUMENT_ROOT"]);

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
              EDIT TEST
              
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


          if(isset($update_test)&&$update_test=="success") echo "Test was updated successfully";

          if(isset($update_test)&&$update_test=="error") echo "There was error. Test could not be updated";




          ?>
          </p>   

     </div>
    
<?php 
     require_once("$root/lib/classes/class.helper.php");
      $list_test=new Helper();
      $single_test=$list_test->getSingleTest($test_id);
?>
    <div class="row">
    <!--edit test form-->
      <div class="col-sm-12">

              <div class="panel panel-primary ">
                <div class="panel-heading text-center">Edit this Test</div>
                <div class="panel-body">
                  <form class="form-horizontal" name="edit_test_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                   <input type="hidden" name="test_id" value="<?php echo $test_id;?>">

                   <div class="form-group">
                        <label class="control-label" for="test_name">Enter the new test name</label>
                       
                          <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-medkit" aria-hidden="true"></i></span>
                          <input type="text" class="form-control" name="test_name" id="test_name" aria-describedby="test_name" value="<?php 
                          if(isset($single_test[0]['name']))
                          {
                            echo $single_test[0]['name'];
                          }  
                          else
                          {
                            echo "";
                          } 
                          ?>"
                          >

                          </div>
                          <p style="color:red;"><?php if(isset($test_name_err)) echo $test_name_err;?></p>
                
                  </div>
                    <button type="submit" name="update_test" class="btn btn-primary">Save</button>
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