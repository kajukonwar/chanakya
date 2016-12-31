<?php

if(!isset($_GET['b_id']))
{
    die("Error");
}
else
{
    $id=$_GET['b_id'];
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
function BasicTable($header, $bill_id)
{

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
    $this->Cell(100,6,"Investigation",1,0,'C');
    $this->Cell(50,6,"Department",1,0,'C');
    $this->Cell(30,6,"Cost",1,0,'C');
    
    $this->Ln();


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
            
            $i=1;
            $total=0;

            foreach($bill_contents as $single_bill_content)
            {
                
                $stmt1 = $conn->prepare("SELECT department_id FROM subtest WHERE id=?");
                $stmt1->bindParam(1,$single_bill_content['subtest_id']);
                $stmt1->execute();

                $department_id=$stmt1->fetchAll();

                $stmt2 = $conn->prepare("SELECT name FROM department WHERE id=?");
                $stmt2->bindParam(1,$department_id[0]['department_id']);
                $stmt2->execute();

                $department_name=$stmt2->fetchAll();
                

                $inventory=new Helper();

                $subtest_name=$inventory->getSingleSubTest($single_bill_content['subtest_id']);


                $test_name=$inventory->getSingleTest($single_bill_content['test_id']);

                $this->Cell(10,6,$i,1,0,'C');

                 if($subtest_name[0]['name']=="NA"||$subtest_name[0]['name']=="na")

                {


                
                $this->Cell(100,6,$test_name[0]['name'],1,0,'C');

                }

                elseif($test_name[0]['name']=="NA"||$test_name[0]['name']=="na")

                {


                
                $this->Cell(100,6,$subtest_name[0]['name'],1,0,'C');

                }

                else
                {

                $this->Cell(50,6,$test_name[0]['name'],1,0,'C');

                $this->Cell(50,6,$subtest_name[0]['name'],1,0,'C');

                }
                  
                $this->Cell(50,6,$department_name[0]['name'],1,0,'C');

                

                $this->Cell(30,6,$single_bill_content['cost'],1,0,'C');
                $this->Ln();

                $i++;

                $total=$total+$single_bill_content['cost'];
            }
                
                

            
            

            $stmt=null;
            $conn=null;

            }

          
         
            
            
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
   
   /*
            // Data
                foreach($data as $row)
                {
                    foreach($row as $col)
                        $this->Cell(48,6,$col,1,0,'C');
                    $this->Ln();
                }
        */

    $this->Ln(5);
    $this->Cell(144,6,'Total:',0,0,'R');
    $this->Cell(48,6,$total,0,0,'C');


    $this->Ln(15);
    $this->Cell(144);
    $this->Cell(48,6,'Generated BY',0,0,'C');
}



}

// Instanciation of inherited class
$pdf = new PDF();
// Column headings
$header = array('Sl No.', 'Investigation', 'Department', 'Cost in Rs.');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BasicTable($header,$id);
$pdf->Output();
?>
?> 