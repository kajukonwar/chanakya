<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_GET['b_id']))
{
    die("Error");
}
else
{
    $bill_id=$_GET['b_id'];
}


$root= realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';
require_once("$root/include/session_check.php");
//empty the session array whenever this page is opened
if(isset($_SESSION['bill_contents']))
{

  $_SESSION['bill_contents']=array();
}

if($permission=="admin"||$permission=="reception")
{

}
else
{
  die("Unauthorized access");
}


require_once("$root/include/dbconfig.php");

require_once("$root/lib/classes/class.helper.php");



      $dbconfig=new Dbconfig();

   

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare 
            
          
            $stmt = $conn->prepare("SELECT * FROM bill_contents WHERE bill_id=?");
            $stmt->bindParam(1,$bill_id);
            $stmt->execute();

            $bill_contents= $stmt->fetchAll();

           

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


<!--get the header-->
<?php require_once("$root/include/header.php");?>

 <!--get the sidebar-->
<?php require_once("$root/include/sidebar.php");?>

        <!-- Content Wrapper.-->
        <div class="content-wrapper">

              <section class="content-header">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="text-center">
                                      
                                The bill has been saved successfully 
                             </h3>
                         </div>
                    </div>
                                
              </section>

               <hr>
               <div class="row">
               <div class="col-sm-4 text-center  ">
                <button type="button" class="btn btn-primary btn-lg" id="special_bill_print_button">Print</button>
               </div>

               <div class="col-sm-4 text-center  ">
                <a href="#" class="btn btn-primary btn-lg" role="button">Create  bill</a>
               </div>

               <div class="col-sm-4 text-center  ">
                <a href="#" class="btn btn-primary btn-lg" role="button">Create  special bill</a>
               </div>
               </div>

              <!-- Main content -->
              <section class="content" >

              <!--Make the content to be printed-->
              <div class="text-center" style="width:7.65in;display:none;"">
           		<textarea   id="special_bill_pdf">

            <p style="text-align:center"><img alt="" src="http://localhost/chanakya/dist/img/logo.png" style="height:122px; width:229px" />&nbsp;&nbsp;</p>

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
<?php echo $bill_contents[0]['special_bill_content'];?>

<p>&nbsp;</p>

<p><strong><span style="font-family:Arial,sans-serif"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Total:</strong>
<?php echo $bill_contents[0]['cost'];?> </span></strong></p>

<p><strong>&nbsp;</strong></p>

<p><strong><span style="font-family:Arial,sans-serif"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Generated By</strong></span></strong></p>

           	</textarea>

              </div>

              </section>
              <!-- / main content -->
              
              
        </div>
        <!--content-wrapper -->
       


  <!--get the footer-->
 
<?php require_once("$root/include/footer.php");?>

