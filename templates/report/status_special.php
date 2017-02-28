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

if(!isset($_GET["r_id"]))
{
die("Error: Wrong query URL");
}
else
{
 
  $report_id=$_GET['r_id'];
}
?>
<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
 

    <!-- Main content -->
    <section class="content">

   
    <!--include helper class-->

    <?php require_once("$root/lib/classes/class.helper.php");?>
    
    <!--Show save status-->
    <div class="row">
        <div class="col-sm-12">

                  <div class="text-center">

                              <section class="content-header">
                                <div class="panel panel-primary">
                                  <div class="panel-heading">
                                      <h3 class="text-center">
                                      
                                        The report has been saved successfully 
                                      </h3>
                                  </div>
                                </div>
                                
                              </section>
                              
                            
                            <section>

                            <?php

                               $dbconfig=new Dbconfig();


                              try {
                                  $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
                                  // set the PDO error mode to exception
                                  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                  // prepare          
                                  $stmt = $conn->prepare("SELECT * FROM report WHERE id=?");
                                  $stmt->bindParam(1,$report_id);
                              
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

                              <!-- The report content to print-->
                              <textarea id="specil_report_print">

                              <?php if(isset($report_contents[0]['result'])) echo $report_contents[0]['result'];?>

                              </textarea>


                              <!-- END report content to print-->

                              <button type="button" class="btn btn-primary btn-lg" id="special_report_print_button">Print Report</button> 

                              <a href="http://localhost/chanakya/templates/report/view.php?status=pending" class="btn btn-primary btn-lg" role="button">Go Back</a>

        <!-- ************************************************
             OTHER THINGS LIKE SEND SMS IS NOT INCLUDED DUE TO LACK OF TIME AND COMPLEXITY
            IDEALLY IT SHOULD BE INCLUDED***********
            ********************************************
            -->
                              </section>

       
                   </div> 
             
        </div>
    </div>
    <!--END save status-->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>