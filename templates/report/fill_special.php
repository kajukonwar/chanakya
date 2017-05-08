<?php

$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");

if($permission=="admin"||$permission=="laboratory")
{

}
else
{
  die("Unauthorized access");
}

//get query string
if(isset($_GET["id"]))
{
  $bill_id=$_GET["id"];
}


//set bill id when we post the form
if($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST["special_report_save"]))
{

  if(isset($_POST['current_bill_id']))
  {
    $bill_id=$_POST['current_bill_id'];
  }
}

if(!isset($bill_id))
{
  die("Error: Wrong query string");
}



//save the report
if($_SERVER['REQUEST_METHOD']=="POST")
{


    if(!isset($_POST['special_report_editor']))
    {
      $_POST['special_report_editor']="";
    }
    require_once("$root/lib/classes/class.special.php");

    $s_report=new Special();

    $s_report_validate=$s_report->validate_report($_POST['special_report_editor']);

    if(empty($s_report_validate))
    {
      $s_report->save_report($_POST['current_bill_id'],$_POST['current_bill_contents_id'],$_POST['test_id'],$_POST['subtest_id'],$_POST['special_report_editor']);
    }
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
      <h1 class="text-center">
        Fill this report as you wish!
        
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

  
    <div class="row">
        <div class="col-sm-12">


         <?php 
          $Contents=new Helper();
          $bill_contents=$Contents->getBillContents($bill_id);


           if(empty($bill_contents))
            {
              ?>
                <h2>There is no content for this report</h2>
              <?php
            }

            //special bill/report will have exactly one entry in DB
            elseif(count($bill_contents)!=1)
            {
              ?>
                 <h2>There is error. Please don't fill this report</h2>
              <?php
            }
            else
            {
               $bill_contents_id=$bill_contents[0]['id'];
               $test_id=$bill_contents[0]['test_id'];
               $subtest_id=$bill_contents[0]['subtest_id'];

            }
          ?>

        <form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

              <input type="hidden" name="current_bill_id" value="<?php echo $bill_id;?>">
              <input type="hidden" name="current_bill_contents_id" value="<?php echo $bill_contents_id;?>">
              <input type="hidden" name="test_id" value="<?php echo $test_id;?>">
              <input type="hidden" name="subtest_id" value="<?php echo $subtest_id;?>">

               <!--report contents-->
              <div class="text-center" style="width:7.65in;margin:auto;">
              <textarea  name="special_report_editor" id="special_report_editor" rows="10" cols="80">
                  
              </textarea>


              <p  style="height:20px;color:red;"><?php if(isset($s_report_validate)) echo $s_report_validate;?></p>
              </div>
              <!--end report content-->


         
              <div class="text-center">
              <button type="submit" class="btn btn-primary btn-lg"  name="special_report_save">Save</button> 

              </div> 
        </form>
        </div>
    </div>




    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>