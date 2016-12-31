<?php

if(!isset($_GET['r_id']))
{
    die("Error");
}
else
{
    $id=$_GET['r_id'];
}
$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";

require_once("$root/include/dbconfig.php");
require_once("$root/lib/classes/class.helper.php");
require("$root/lib/fpdf181/fpdf.php");
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.png',90,5,30);
    // Arial bold 15
    $this->SetFont('Arial','B',9);
    $this->Ln(10);
    // Move to the right
    $this->Cell(40);
    // Title
    $this->Cell(100,10,'CHANAKYA DIAGNOSTIC LABORATORY',0,0,'C');
    $this->Ln(4);
    // Move to the right
    $this->Cell(40);
    // Title
    $this->Cell(100,10,'BHOJO ROAD, SONARI- 785690, ASSAM, PH. 739919968',0,0,'C');
    $this->Line(10, 35, 200, 35);
    $this->Ln(12);
    
}


// Simple table
function BasicTable($header,$report_id)
{

    //get patient details

    $report_details = new Helper();
  
    $patient_details=$report_details->getSingleBill($report_id);

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
    //show patient details

    
    $this->Cell(40,6,'ID:','B',0,'L');

    $this->Cell(120,6,'Name of patient:'.$patient_details[0]['patient_name'],'B',0,'L');

    $this->Cell(30,6,'Age:'.$patient_details[0]['patient_age'],'B',0,'L');

    $this->Ln();

    $this->Cell(30,6,'Gender:'.$patient_details[0]['patient_gender'] ,'B',0,'L');

    $this->Cell(60,6,'Contact No.:'.$patient_contact,'B',0,'L');

    $this->Cell(100,6,'Email ID:'.$patient_email,'B',0,'L');


    $this->Ln();

    $this->Cell(130,6,'Referenced by:' ,'B',0,'L');

    $this->Cell(0,6,'Date.:','B',0,'L');

    

    //$this->Line(10, 53, 200, 53);

    $this->Ln(20);
    
    // Data
    $this->Cell(10,6,"#",1,0,'C');
    $this->Cell(75,6,"Investigation",1,0,'C');
    $this->Cell(45,6,"Department",1,0,'C');
    $this->Cell(30,6,"Result",1,0,'C');
    $this->Cell(30,6,"Bio. Ref. Interval",1,0,'C');
    $this->Ln();
    
    $dbconfig=new Dbconfig();

        try {

            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // prepare 
            $stmt = $conn->prepare("SELECT * FROM report WHERE bill_id=?");
            $stmt->bindParam(1,$report_id);
            $stmt->execute();
            $report_contents= $stmt->fetchAll();
            
            $i=1;
            

            foreach($report_contents as $single_report_content)
            {
                $stmt1 = $conn->prepare("SELECT * FROM subtest WHERE id=?");
                $stmt1->bindParam(1,$single_report_content['subtest_id']);
                $stmt1->execute();

                $sub_details=$stmt1->fetchAll();

                $stmt2 = $conn->prepare("SELECT name FROM department WHERE id=?");
                $stmt2->bindParam(1,$sub_details[0]['department_id']);
                $stmt2->execute();

                $department_name=$stmt2->fetchAll();

                $inventory=new Helper();

                $subtest_name=$inventory->getSingleSubTest($single_report_content['subtest_id']);


                $test_name=$inventory->getSingleTest($single_report_content['test_id']);

                $this->Cell(10,6,$i,1,0,'C');

                if($subtest_name[0]['name']=="NA"||$subtest_name[0]['name']=="na")

                {


                
                $this->Cell(75,6,$test_name[0]['name'],1,0,'C');

                }

                elseif($test_name[0]['name']=="NA"||$test_name[0]['name']=="na")

                {


                
                $this->Cell(75,6,$subtest_name[0]['name'],1,0,'C');

                }

                else
                {

                $this->Cell(38,6,$test_name[0]['name'],1,0,'C');

                $this->Cell(37,6,$subtest_name[0]['name'],1,0,'C');

                }
                  
                



                $this->Cell(45,6,$department_name[0]['name'],1,0,'C');
                $this->Cell(30,6,$single_report_content['result'],1,0,'C');
                $this->Cell(30,6,$sub_details[0]['default_value'],1,0,'C');
                $this->Ln();

                $i++;

                
            }           

            $stmt=null;
            $conn=null;

            }       
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


    $this->Ln(18);
    $this->Cell(140);
    $this->Cell(50,6,'Signature',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
// Column headings
$header = array('Investigation');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BasicTable($header,$id);
$pdf->Output();
?>
?> 