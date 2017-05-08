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

if(!isset($_GET["r_id"]))
{
die("Error: Wrong query URL");
}
else
{
 
  $bill_id=$_GET['r_id'];
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

                             
                            <section>

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

                                  

                                  //get patient details

    $bill_details = new Helper();
  
    $patient_details=$bill_details->getSingleBill($bill_id);

    if(!empty($patient_details[0]['patient_contact']))
    {
        $patient_contact=$patient_details[0]['patient_contact'];
    }
    else
    {

        $patient_contact="";
    }


    if(!empty($patient_details[0]['patient_email']))
    {
        $patient_email=$patient_details[0]['patient_email'];
    }
    else
    {

        $patient_email="";
    }

    //get doctor details
    if($patient_details[0]['referred_by_doctor']!="no")
    {

        if(!empty($patient_details[0]['doctor_id'])&&$patient_details[0]['doctor_id']!=0)
        {

            
                $doctor_details=$bill_details->getSingleDoctor($patient_details[0]['doctor_id']);
                if(empty($doctor_details))
                {
                    $doctor_name="";
                }
               
                else
                {
                    $doctor_name=$doctor_details[0]['full_name'];
                }
        }
        else
        {
            $doctor_name="";
        }
    }
    else
    {
        $doctor_name="";
    }

    $today=date("d-m-Y");

                            ?>

                              <!-- The report content to print-->

                             <div class="text-center" style="width:7.65in;display:none;margin:auto;">
                              <textarea id="specil_report_print">
                                  <p style="text-align:center"><img alt="" src="http://chanakya.lab/dist/img/logo.png" style="height:122px; width:229px" />&nbsp;&nbsp;</p>

<h1 style="text-align:center"><span style="font-size:26px"><span style="font-family:Arial,Helvetica,sans-serif"><span style="color:#0066cc"><strong>CHANAKYA DIAGNOSTIC LABORATORY</strong></span> </span> </span></h1>

<p style="text-align:center"><span style="font-size:14px"><span style="color:#0066cc"><span style="font-family:Arial,sans-serif"><strong>BHOJO ROAD, SONARI- 785690, ASSAM, PH. 9954422403/(03772)256576</strong> </span> </span> </span></p>

<hr />
<div style="display:inline-block; padding:0px; width:160px"><span style="font-size:14px"><span style="font-family:Arial,sans-serif"><strong>ID:</strong> <?php echo $bill_id;?><strong> </strong> </span> </span></div>

<div style="display:inline-block; padding:0px; width:410px"><span style="font-size:14px"><span style="font-family:Arial,sans-serif"><strong>Name of patient:</strong> <?php echo $patient_details[0]['patient_name'];?> <strong> </strong> </span> </span></div>

<div style="display:inline-block; padding:0px; width:100px"><span style="font-size:14px"><span style="font-family:Arial,sans-serif"><strong>Age:</strong> <?php echo $patient_details[0]['patient_age'];?> <strong> </strong> </span> </span></div>

<div style="display:inline-block; margin-top:5px; padding:0px; width:130px"><span style="font-size:14px"><span style="font-family:Arial,sans-serif"><strong>Gender:</strong><?php echo $patient_details[0]['patient_gender'];?><strong> </strong> </span> </span></div>

<div style="display:inline-block; margin-top:5px; padding:0px; width:250px"><span style="font-size:14px"><span style="font-family:Arial,sans-serif"><strong>Contact:</strong> <?php echo $patient_contact;?> </span> </span></div>

<div style="display:inline-block; margin-top:5px; padding:0px; width:290px"><span style="font-size:14px"><span style="font-family:Arial,sans-serif"><strong>Email ID:</strong> <?php echo $patient_email;?> </span> </span></div>

<div style="display:inline-block; margin-top:5px; padding:0px; width:430px"><span style="font-size:14px"><span style="font-family:Arial,sans-serif"><strong>Referenced by:</strong> <?php echo $doctor_name;?></span> </span></div>

<div style="display:inline-block; margin-top:5px; padding:0px; width:240px"><span style="font-size:14px"><span style="font-family:Arial,sans-serif"><strong>Date:</strong> <?php echo $today;?></span> </span></div>

<hr />
<p>&nbsp;</p>
                              <?php if(isset($report_contents[0]['result'])) echo $report_contents[0]['result'];?>

                              </textarea>

                              </div>


                              <!-- END report content to print-->

                              <button type="button" class="btn btn-primary btn-lg" id="special_report_print_button">Print Report</button> 

                              <a href="http://chanakya.lab/templates/report/view.php?status=pending" class="btn btn-primary btn-lg" role="button">Go Back</a>

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