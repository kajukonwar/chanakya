<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");
require_once("$root/include/dbconfig.php");
require_once("$root/lib/classes/class.helper.php");
require("$root/lib/fpdf181/fpdf.php");
class PDF extends FPDF
{
// Page header
function Header()
{

    // Logo
    
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);

    $image_url=$root."/dist/img/logo.png";
    $this->Image($image_url,80,5,50);
    // Arial bold 15
    $this->SetFont('Arial','B',22);
    $this->setTextColor(128);
    
    $this->Ln(20);

    // Move to the right
    $this->Cell(40);
    // Title
    $this->setTextColor(0,112,192);
    $this->Cell(100,10,'CHANAKYA DIAGNOSTIC LABORATORY',0,0,'C');


    $this->Ln(7);

    // Move to the right
    $this->Cell(40);
    // Title
    $this->SetFont('Arial','B',11);
    $this->Cell(100,10,'BHOJO ROAD, SONARI- 785690, ASSAM, PH. 9954422403/(03772)256576',0,0,'C');


    $this->Line(10, 47, 200, 47);

    $this->Ln(17);
    
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

    //get doctor details
    if($patient_details[0]['referred_by_doctor']!="no")
    {

        if(!empty($patient_details[0]['doctor_id'])&&$patient_details[0]['doctor_id']!=0)
        {

            
                $doctor_details=$report_details->getSingleDoctor($patient_details[0]['doctor_id']);
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
    //show patient details
    $this->SetFont('Arial','B',12);
    $this->Cell(7,6,'ID: ','',0);

    $this->SetFont('Arial','',11);
    $this->Cell(30,6,$report_id,'B',0);

    $this->SetFont('Arial','B',12);
    $this->Cell(38,6,'Name of patient:','0',0,'');

    $this->SetFont('Arial','',11);
    $this->Cell(80,6,$patient_details[0]['patient_name'],'B',0,'');

    $this->SetFont('Arial','B',12);
    $this->Cell(10,6,'Age: ','0',0);

    $this->SetFont('Arial','',11);
    $this->Cell(0,6,$patient_details[0]['patient_age'],'B',1,'');

    $this->Ln(2);
   

    $this->SetFont('Arial','B',12);
    $this->Cell(18,6,'Gender: ','0',0);

    $this->SetFont('Arial','',11);
    $this->Cell(26,6,$patient_details[0]['patient_gender'] ,'B',0);

    $this->SetFont('Arial','B',12);
    $this->Cell(26,6,'Contact No: ','0',0);

    $this->SetFont('Arial','',11);
    $this->Cell(32,6,''.$patient_contact,'B',0);

    $this->SetFont('Arial','B',12);
    $this->Cell(20,6,'Email ID: ','0',0);

    $this->SetFont('Arial','',11);
    $this->Cell(0,6,''.$patient_email,'B',1);

    $this->Ln(2);


    //show doctor details
    $this->SetFont('Arial','B',12);
    $this->Cell(32,6,'Referenced by: ','0',0);

    $this->SetFont('Arial','',11);
    $this->Cell(95,6,$doctor_name ,'B',0);

    $this->SetFont('Arial','B',12);
    $this->Cell(12,6,'Date: ','0',0);

    $this->SetFont('Arial','',11);
    $this->Cell(0,6,$today,'B',0);



    

    //$this->Line(10, 53, 200, 53);

    $this->Ln(37);
    
   

    $this->SetFont('Arial','',11);
    
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

            $report_contents_department_wise=array();
            
             foreach($report_contents as $single_report_content)
            {

                $stmt1 = $conn->prepare("SELECT department_id FROM subtest WHERE id=?");
                $stmt1->bindParam(1,$single_report_content['subtest_id']);
                $stmt1->execute();

                $department_id=$stmt1->fetchAll();

                $report_contents_department_wise[$department_id[0]['department_id']][]=$single_report_content;
            }
            

             $i=1;
           
           foreach($report_contents_department_wise as $single_department_key=>$single_department_value)
           {


                

                $stmt2 = $conn->prepare("SELECT name FROM department WHERE id=?");
                $stmt2->bindParam(1,$single_department_key);
                $stmt2->execute();

                $department_name=$stmt2->fetchAll();

                 $this->SetFont('Arial','B',12);
                $this->Cell(190,6,strtoupper($department_name[0]['name']),1,1,'C');
                // Data
                $this->SetFont('Arial','B',12);
                $this->Cell(10,6,"#",1,0,'C');
                $this->Cell(105,6,"Investigation",1,0,'C');
              
                $this->Cell(35,6,"Result",1,0,'C');
                $this->Cell(40,6,"Bio. Ref. Interval",1,0,'C');
                
                $this->Ln();

                $this->SetFont('Arial','',9);

                    //group the bill contents by test ID
                $new_report_contents = array();

                foreach($single_department_value as $key => $item)
                {
                   $new_report_contents[$item['test_id']][$key] = $item;
                }

                //ksort($new_report_contents, SORT_NUMERIC);


                

                foreach($new_report_contents as $single_report_content_key=>$single_report_content_value)

                {

                    if($single_report_content_key==89||$single_report_content_key==90||$single_report_content_key==91)
                    {
                        $print_notes="yes";
                    }
                    $test_cell_height=count($single_report_content_value)*6;


                    $index_height=$test_cell_height;
                    foreach($single_report_content_value as $sublevel_report_content)
                                {
                                    if($sublevel_report_content['subtest_id']==97||$sublevel_report_content['subtest_id']==102)
                                    {
                                        $cell_bigger="yes";
                                    }
                                    else
                                    {
                                        $cell_bigger="no";
                                    }
                                    
                                }
                    if(isset($cell_bigger)&&$cell_bigger=="yes")
                    {
                        $index_height=$index_height+24;
                    }
                    $this->Cell(10,$index_height,$i,1,0,'C');



                    $inventory=new Helper();

                    $test_name=$inventory->getSingleTest($single_report_content_key);
                    $test_name[0]['name']=trim($test_name[0]['name']);
                    $test_name[0]['name']=strtoupper($test_name[0]['name']);

                    if (stripos($test_name[0]['name'], "(group)") !== false) {
                                   $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP)");
                     }

                    if(count($single_report_content_value)>1)
                    {

                         if($test_name[0]['name']=="NA"||$test_name[0]['name']=="na")

                        {

                                  $j=1;

                                foreach($single_report_content_value as $sublevel_report_content)
                                {

                                $subtest_name=$inventory->getSingleSubTest($sublevel_report_content['subtest_id']);

                                if($j!=1)
                                {
                                    $this->Cell(10);
                                    
                                }
                                


                                    $subtest_name[0]['name']=trim($subtest_name[0]['name']);
                                    $subtest_name[0]['name']=strtoupper($subtest_name[0]['name']);

                                    if (stripos($subtest_name[0]['name'], "(group)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP)");
                                     }
                              
                                    $this->Cell(105,6,strtoupper($subtest_name[0]['name']),1,0,'C');

                                     $this->Cell(35,6,$sublevel_report_content['result'],1,0,'C');
                                    $this->Cell(40,6,$subtest_name[0]['default_value'],1,1,'C');
                                
                               
                                
                                 

                                $j++;
                                }
                        }
                        else
                        {
                           
                            switch ($single_report_content_key) {
                                case 91:

                            foreach($single_report_content_value as $sublevel_report_content)
                                {
                                    if($sublevel_report_content['subtest_id']==102)
                                    {
                                        $cell_group3_bigger="yes";
                                    }
                                    
                                }
                            if(isset($cell_group3_bigger)&&$cell_group3_bigger=="yes")
                            {
                                $test_cell_height=$test_cell_height+24;
                            }

                            if (stripos($test_name[0]['name'], "(group)") !== false) 
                            {
                                                   $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP)");
                            }

                             if (stripos($test_name[0]['name'], "(group1)") !== false)
                            {
                                                   $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP1)");
                            }
                                     
                            if (stripos($test_name[0]['name'], "(group2)") !== false) 
                            {
                                                   $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP2)");
                            }
                            
                            $this->Cell(53,$test_cell_height,strtoupper($test_name[0]['name']),1,0,'C');

                             

                            $j=1;

                                foreach($single_report_content_value as $sublevel_report_content)
                                {

                                $subtest_name=$inventory->getSingleSubTest($sublevel_report_content['subtest_id']);

                                $subtest_name[0]['name']=trim($subtest_name[0]['name']);
                                    $subtest_name[0]['name']=strtoupper($subtest_name[0]['name']);

                                    if (stripos($subtest_name[0]['name'], "(group)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP)");
                                     }

                                     if (stripos($subtest_name[0]['name'], "(group1)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP1)");
                                     }
                                     if (stripos($subtest_name[0]['name'], "(group2)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP2)");
                                     }

                                if($j!=1)
                                {
                                    $this->Cell(63);
                                    
                                }

                                
                                    if($sublevel_report_content['subtest_id']==102)
                                    {
                                        

                                             $this->Cell(52,30,strtoupper($subtest_name[0]['name']),1,0,'C');
                                             

                                             $this->Cell(35,30,$sublevel_report_content['result'],1,0,'C');
                                             
                                            $this->Cell(40,6,'Euthyroid:0.39-6.16','L,R',1,'C');
                                            $this->Cell(150);
                                            $this->SetFont('Arial','',8);
                                            $this->Cell(40,6,'Suggestive of Hyperthyroidism:','L,R',1,'C');
                                            $this->Cell(150);
                                            $this->Cell(40,6,'<0.15','L,R',1,'C');
                                            $this->Cell(150);
                                            $this->Cell(40,6,'Suggestive of Hyperthyroid:','L,R',1,'C');
                                            $this->Cell(150);
                                            $this->Cell(40,6,'>7.0','L,R,B',1,'C');
                                            $this->SetFont('Arial','',9);
                                    }
                                    else
                                    {

                                             $this->Cell(52,6,strtoupper($subtest_name[0]['name']),1,0,'C');

                                             $this->Cell(35,6,$sublevel_report_content['result'],1,0,'C');
                                             $this->Cell(40,6,$subtest_name[0]['default_value'],1,1,'C');

                                    }

                                     

                                   

                                $j++;
                                }

                                break;

                                 case 20:
                                   if (stripos($test_name[0]['name'], "(group)") !== false) 
                                                {
                                                                       $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP)");
                                                }

                                                 if (stripos($test_name[0]['name'], "(group1)") !== false)
                                                {
                                                                       $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP1)");
                                                }
                                                         
                                                if (stripos($test_name[0]['name'], "(group2)") !== false) 
                                                {
                                                                       $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP2)");
                                                }

                            //$this->Cell(53,$test_cell_height,strtoupper("a"),1,0,'C');

                            $j=1;

                                foreach($single_report_content_value as $sublevel_report_content)
                                {

                                $subtest_name=$inventory->getSingleSubTest($sublevel_report_content['subtest_id']);

                                $subtest_name[0]['name']=trim($subtest_name[0]['name']);
                                    $subtest_name[0]['name']=strtoupper($subtest_name[0]['name']);

                                     $subtest_name[0]['name']=htmlspecialchars_decode($subtest_name[0]['name']);

                                    if (stripos($subtest_name[0]['name'], "(group)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP)");
                                     }

                                     if (stripos($subtest_name[0]['name'], "(group1)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP1)");
                                     }
                                     if (stripos($subtest_name[0]['name'], "(group2)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP2)");
                                     }

                                if($j!=1)
                                {
                                    $this->Cell(10);
                                    
                                }

                                
                                         $subtest_name[0]['default_value']=htmlspecialchars_decode($subtest_name[0]['default_value']);
                                     
                                     $this->Cell(105,6,strtoupper($subtest_name[0]['name']),1,0,'C');

                                     $this->Cell(35,6,$sublevel_report_content['result']." ".$subtest_name[0]['unit'],1,0,'C');
                                    $this->Cell(40,6,$subtest_name[0]['default_value'],1,1,'C');

                                   

                                $j++;
                                }

                                break;

                                default:
                                if (stripos($test_name[0]['name'], "(group)") !== false) 
                                                {
                                                                       $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP)");
                                                }

                                                 if (stripos($test_name[0]['name'], "(group1)") !== false)
                                                {
                                                                       $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP1)");
                                                }
                                                         
                                                if (stripos($test_name[0]['name'], "(group2)") !== false) 
                                                {
                                                                       $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP2)");
                                                }

                            $this->Cell(53,$test_cell_height,strtoupper($test_name[0]['name']),1,0,'C');

                            $j=1;

                                foreach($single_report_content_value as $sublevel_report_content)
                                {

                                $subtest_name=$inventory->getSingleSubTest($sublevel_report_content['subtest_id']);

                                $subtest_name[0]['name']=trim($subtest_name[0]['name']);
                                    $subtest_name[0]['name']=strtoupper($subtest_name[0]['name']);

                                    if (stripos($subtest_name[0]['name'], "(group)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP)");
                                     }

                                     if (stripos($subtest_name[0]['name'], "(group1)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP1)");
                                     }
                                     if (stripos($subtest_name[0]['name'], "(group2)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP2)");
                                     }

                                if($j!=1)
                                {
                                    $this->Cell(63);
                                    
                                }

                                

                                     
                                     $this->Cell(52,6,strtoupper($subtest_name[0]['name']),1,0,'C');

                                     $this->Cell(35,6,$sublevel_report_content['result'],1,0,'C');
                                    $this->Cell(40,6,$subtest_name[0]['default_value'],1,1,'C');

                                   

                                $j++;
                                }

                            }


                               
                        }
                        
                      

                    }
                    else
                    {

                            

                            $j=1;

                             foreach($single_report_content_value as $sublevel_report_content)
                            {

                                 $subtest_name=$inventory->getSingleSubTest($sublevel_report_content['subtest_id']);

                                 $subtest_name[0]['name']=trim($subtest_name[0]['name']);
                                    $subtest_name[0]['name']=strtoupper($subtest_name[0]['name']);

                                    if (stripos($subtest_name[0]['name'], "(group)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP)");
                                     }
                                     if (stripos($subtest_name[0]['name'], "(group1)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP1)");
                                     }
                                     if (stripos($subtest_name[0]['name'], "(group2)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP2)");
                                     }

                                  if($subtest_name[0]['name']=="NA"||$subtest_name[0]['name']=="na")
                                  {
                                    $this->Cell(105,$test_cell_height,strtoupper($test_name[0]['name']),1,0,'C');

                                    

                                    $this->Cell(35,6,$sublevel_report_content['result'],1,0,'C');
                                     $this->Cell(40,6,$subtest_name[0]['default_value'],1,1,'C');
                                   
                                  }
                                  else
                                  {
                                   switch($single_report_content_key)
                                    {

                                        case 89:

                                            $test_cell_height=$test_cell_height+24;

                                             if (stripos($test_name[0]['name'], "(group)") !== false) 
                                            {
                                                                   $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP)");
                                            }

                                             if (stripos($test_name[0]['name'], "(group1)") !== false)
                                            {
                                                                   $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP1)");
                                            }
                                                     
                                            if (stripos($test_name[0]['name'], "(group2)") !== false) 
                                            {
                                                                   $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP2)");
                                            }
                                            $this->Cell(53,$test_cell_height,strtoupper($test_name[0]['name']),1,0,'C');
                                            $this->Cell(52,30,strtoupper($subtest_name[0]['name']),1,0,'C');

                                            $this->Cell(35,30,$sublevel_report_content['result'],1,0,'C');
                                            $this->Cell(40,6,'Euthyroid:0.39-6.16','L,R',1,'C');
                                            $this->Cell(150);
                                            $this->SetFont('Arial','',8);
                                            $this->Cell(40,6,'Suggestive of Hyperthyroidism:','L,R',1,'C');
                                            $this->Cell(150);
                                            $this->Cell(40,6,'<0.15','L,R',1,'C');
                                            $this->Cell(150);
                                            $this->Cell(40,6,'Suggestive of Hyperthyroid:','L,R',1,'C');
                                            $this->Cell(150);
                                            $this->Cell(40,6,'>7.0','L,R,B',1,'C');
                                            $this->SetFont('Arial','',9);
                                             break;

                                    
                                    
                                        default:

                                             if (stripos($test_name[0]['name'], "(group)") !== false) 
                                                {
                                                                       $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP)");
                                                }

                                                 if (stripos($test_name[0]['name'], "(group1)") !== false)
                                                {
                                                                       $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP1)");
                                                }
                                                         
                                                if (stripos($test_name[0]['name'], "(group2)") !== false) 
                                                {
                                                                       $test_name[0]['name']= chop($test_name[0]['name'],"(GROUP2)");
                                                }
                                            $this->Cell(53,$test_cell_height,strtoupper($test_name[0]['name']),1,0,'C');
                                            $this->Cell(52,6,strtoupper($subtest_name[0]['name']),1,0,'C');

                                            $this->Cell(35,6,$sublevel_report_content['result'],1,0,'C');
                                             $this->Cell(40,6,$subtest_name[0]['default_value'],1,1,'C');
                                    }

                                     

                                    
                                  }

                          

                                  $j++;
                                
                            }

                         

                    }

                    

                    $i++;
                }//end test wise
                
                $this->Ln();
                $this->Ln();

           }//end department wise          

            $stmt=null;
            $conn=null;

            }       
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 

    $this->SetFont('Arial','B',11);
    
    
     if(isset($print_notes)&&$print_notes=="yes")
    {
         
   
    $this->Write(6,'Note');
    $this->Ln();
    $this->SetFont('Arial','',9);
    $this->Write(6,'As a guideline 95 % of the values corresponding to adults who are clinically or biologically euthyroid without any associated serious diseases are within the range. Please allow a period of 4-6 weeks for a repeat sample after any DOSE ADJUSTMENTS (or irregularity of dose/skipping of Dose)');
    $this->SetFont('Arial','B',9);
    $this->Ln(10);
    $this->Cell(30);
    $this->Cell(50,6,'Clinical use',0,0,'L');

    $this->SetFont('Arial','',9);
    $this->Ln(5);
    $this->Cell(30);
    $this->Cell(80,6,'* Primary Hypothyroidism',0,0,'L');

    $this->Ln(5);
    $this->Cell(30);
    $this->Cell(80,6,'* Hypothyroidism',0,0,'L');

    $this->Ln(5);
    $this->Cell(30);
    $this->Cell(130,6,'* Hypothalamic-Pituitary hypothyroidism',0,0,'L');

    $this->Ln(5);
    $this->Cell(30);
    $this->Cell(80,6,'* Inappropriate TSH secretion',0,0,'L');

    $this->Ln(5);
    $this->Cell(30);
    $this->Cell(80,6,'* Nonthyroidal illness',0,0,'L');

    $this->Ln(5);
    $this->Cell(30);
    $this->Cell(80,6,'* Autoimmune thyroid disease',0,0,'L');

    $this->Ln(5);
    $this->Cell(30);
    $this->Cell(80,6,'* Pregnancy associated thyroid disorders',0,0,'L');

    $this->Ln(5);
    $this->Cell(30);
    $this->Cell(80,6,'* Thyroid dysfunction in infancy and early childhood',0,0,'L');

    $this->Ln(15);
    $this->Cell(40);
    $this->SetFont('Arial','BU',9);
    $this->Cell(90,6,'( This test is performed by:  Merilyzer/EIAQuant (ELISA METHOD)',0,0,'C');


    }
    $this->Ln(18);
    $this->Cell(140);
    $this->Cell(50,6,'Signature',0,0,'C');

   
   
}
}


//send email to patient

if(isset($_POST['send_report_email']))
{
parse_str($_POST['send_report_email'], $report_id);

//$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";
//$filename=$root."/dist/report_id_".$report_id['report_id'].".pdf";
   // Instanciation of inherited class
$pdf = new PDF();
// Column headings
$header = array('Investigation');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BasicTable($header,$report_id['report_id']);
$attachment=$pdf->Output('Report.pdf', 'S');

//get the patient name
$email_to_details= new Helper();
$email_patient=$email_to_details->getSingleBill($report_id['report_id']);

//BEGIN -phpmailer code 
require_once("$root/plugins/PHPMailer-master/PHPMailerAutoload.php");
$mail = new PHPMailer;
$mail->IsSMTP();                                // Set mailer to use SMTP
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->Host = 'smtp.gmail.com';                      // Specify main and backup server
$mail->Port = 587;                              // Set the SMTP port
$mail->SMTPAuth = true;                         // Enable SMTP authentication
$mail->Username = 'chanakyadiagnostics@gmail.com';                   // SMTP username
$mail->Password = 'anupmohan';                   // SMTP password
$mail->SMTPSecure = 'tls';                      // Enable encryption, 'ssl' also accepted
$mail->From = 'chanakyadiagnostics@gmail.com';
$mail->FromName = 'Chanakya Diagnostic Laboratory';
$mail->AddAddress($email_patient[0]['patient_email']);  // Add a recipient
$mail->IsHTML(true);                             // Set email format to HTML

$mail->Subject = 'Medicat test report';
$mail->Body    = 'Dear '.$email_patient[0]['patient_name'].' , <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your medical test report is ready. You are requested to collect it from Chanakya Diagnostics Laboratory.<br><br><br>Regards,<br>Chanakya Diagnostic Laboratory<br>Bhojo Road, Sonari-785690<br>(03772)256567 / 9954422403';

//$mail->AltBody = 'messge body';
//$mail->AddAttachment("c:/temp/test.php", "test.php");  

$mail->AddStringAttachment($attachment, 'Report.pdf');

if(!$mail->Send()) {
   
   //echo 'Mailer Error: ' . $mail->ErrorInfo;
   echo json_encode("error");
}
else
{
    echo json_encode("success");
}


//END-phpmailer code
}


//send email to doctor

if(isset($_POST['send_report_email_doctor']))
{
parse_str($_POST['send_report_email_doctor'], $report_id);

//$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";
//$filename=$root."/dist/report_id_".$report_id['report_id'].".pdf";
   // Instanciation of inherited class
$pdf = new PDF();
// Column headings
$header = array('Investigation');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->BasicTable($header,$report_id['report_id']);
$attachment=$pdf->Output('Report.pdf', 'S');

//get the patient name
$email_to_details= new Helper();

$email_details=$email_to_details->getSingleBill($report_id['report_id']);

$doctor_details=$email_to_details->getSingleDoctor($email_details[0]['doctor_id']);

//BEGIN -phpmailer code 
require_once("$root/plugins/PHPMailer-master/PHPMailerAutoload.php");
$mail = new PHPMailer;
$mail->IsSMTP();                                // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                      // Specify main and backup server
$mail->Port = 587;                              // Set the SMTP port
$mail->SMTPAuth = true;                         // Enable SMTP authentication
$mail->Username = 'chanakyadiagnostics@gmail.com';                   // SMTP username
$mail->Password = 'anupmohan';                   // SMTP password
$mail->SMTPSecure = 'tls';                      // Enable encryption, 'ssl' also accepted
$mail->From = 'chanakyadiagnostics@gmail.com';
$mail->FromName = 'Chanakya Diagnostic Laboratory';
$mail->AddAddress($doctor_details[0]['email']);  // Add a recipient
$mail->IsHTML(true);                             // Set email format to HTML

$mail->Subject = 'Medicat test report';
$mail->Body    = 'Dear Dr. '.$doctor_details[0]['full_name'].' , <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The medical test report for the patient named '.$email_details[0]['patient_name'].' is complete. The same has been attached for your reference.<br><br>Thanks!<br><br><br>Regards,<br>Chanakya Diagnostic Laboratory<br>Bhojo Road, Sonari-785690<br>(03772)256567 / 9954422403';

//$mail->AltBody = 'messge body';
//$mail->AddAttachment("c:/temp/test.php", "test.php");  

$mail->AddStringAttachment($attachment, 'Report.pdf');

if(!$mail->Send()) {
   
   //echo 'Mailer Error: ' . $mail->ErrorInfo;
   echo json_encode("error");
}
else
{
    echo json_encode("success");
}


//END-phpmailer code
}


?> 