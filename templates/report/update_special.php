<?php

$root= realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';

require_once("$root/include/session_check.php");
if($permission=="admin"||$permission=="laboratory")
{

}
else
{
  die("Unauthorized access");
}


if(isset($_GET['id']))
{

 $bill_id=$_GET["id"];
}
elseif(isset($_POST["current_bill_id"]))
{
 $bill_id=$_POST["current_bill_id"];
}
else
{
  die("Error");
}

require_once("$root/lib/classes/class.special.php");

if($_SERVER['REQUEST_METHOD']=="POST"&&isset($_POST["special_report_update_button"]))
{

  $update_report=new Special();

  $validate_report=$update_report->validate_report($_POST['special_report_content']);

  if(empty($validate_report))
  {
    $update_report->update_report($_POST['current_bill_id'],$_POST['special_report_content']);
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
      <div class="panel panel-primary">
      <div class="panel-heading">
            <h3 class="text-center">
              UPDATE REPORT
              
            </h3>
        </div>
        </div>
      
    </section>

    <!-- Main content -->
    <section class="content">

   
   
   
    <div class="row">
        <div class="col-sm-12">
          <?php


                               $dbconfig=new Dbconfig();


                              try {
                                  $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
                                  // set the PDO error mode to exception
                                  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                  // prepare          
                                  $stmt = $conn->prepare("SELECT * FROM report WHERE bill_id=?");
                                  $stmt->bindParam(1,$bill_id);
                              
                                  $stmt->execute();

                                  $report_contents = $stmt->fetchAll();
                                  

                                  $stmt=null;
                                  $conn=null;

                                                                                             
                                  }
                              catch(PDOException $e)
                                  {
                                  echo "DB Connection failed: " . $e->getMessage();
                                  } 
               
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ;?>" method="POST" id="special_report_update_form">

        <input type="hidden" name="current_bill_id" value="<?php echo $bill_id;?>">

               <!-- The report content to update-->
                <textarea id="special_report_content" name="special_report_content">

                    <?php if(isset($report_contents[0]['result'])) echo $report_contents[0]['result'];?>

                </textarea>

                <p  style="height:20px;color:red;"><?php if(isset($validate_report)) echo $validate_report;?></p>

          
              <div class="text-center">
              <button type="submit" class="btn btn-primary btn-lg"  name="special_report_update_button">Update</button> 
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