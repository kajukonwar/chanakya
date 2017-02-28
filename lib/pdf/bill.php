<?php

if(!isset($_GET['b_id']))
{
    die("Error");
}
else
{
    $id=$_GET['b_id'];
}
$root = realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';

require_once("$root/include/dbconfig.php");

require_once("$root/lib/classes/class.helper.php");
require("$root/lib/fpdf181/fpdf.php");
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    
    $root = realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';

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



    //show patient details
    $this->SetFont('Arial','B',12);
    $this->Cell(7,6,'ID: ','',0);

    $this->SetFont('Arial','',11);
    $this->Cell(30,6,$bill_id,'B',0);

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

            $bill_contents_department_wise=array();

            foreach($bill_contents as $single_bill_content)
            {

                $stmt1 = $conn->prepare("SELECT department_id FROM subtest WHERE id=?");
                $stmt1->bindParam(1,$single_bill_content['subtest_id']);
                $stmt1->execute();

                $department_id=$stmt1->fetchAll();

                $bill_contents_department_wise[$department_id[0]['department_id']][]=$single_bill_content;
            }



            $i=1;
            $total=0;
           foreach($bill_contents_department_wise as $single_department_key=>$single_department_value)
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
                $this->Cell(150,6,"Investigation",1,0,'C');
              
                $this->Cell(30,6,"Cost",1,0,'C');
                
                $this->Ln();

                $this->SetFont('Arial','',11);

                    //group the bill contents by test ID
                $new_bill_contents = array();

               


                foreach($single_department_value as $key => $item)
                {
                   $new_bill_contents[$item['test_id']][$key] = $item;
                }

                 //print_r($new_bill_contents);

                //ksort($new_bill_contents, SORT_NUMERIC);


                $mid_test=count($new_bill_contents)/2;

                $mid_test=ceil($mid_test);


                

                foreach($new_bill_contents as $single_bill_content_key=>$single_bill_content_value)

                {
                    $test_cell_height=count($single_bill_content_value)*6;
                    $this->Cell(10,$test_cell_height,$i,1,0,'C');
                    $inventory=new Helper();

                    $test_name=$inventory->getSingleTest($single_bill_content_key);
                    $test_name[0]['name']=trim($test_name[0]['name']);
                    $test_name[0]['name']=strtoupper($test_name[0]['name']);
                     $test_name[0]['name']=htmlspecialchars_decode($test_name[0]['name']);

                    if (stripos($test_name[0]['name'], "(group)") !== false) {
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

                    if(count($single_bill_content_value)>1)
                    {

                         if($test_name[0]['name']=="NA"||$test_name[0]['name']=="na")

                        {

                                  $j=1;

                                foreach($single_bill_content_value as $sublevel_bill_content)
                                {

                                $subtest_name=$inventory->getSingleSubTest($sublevel_bill_content['subtest_id']);

                                if($j!=1)
                                {
                                    $this->Cell(10);
                                    
                                }
                                


                                    $subtest_name[0]['name']=trim($subtest_name[0]['name']);
                                    $subtest_name[0]['name']=strtoupper($subtest_name[0]['name']);

                                    if (stripos($subtest_name[0]['name'], "(group)") !== false) {
                                                   $subtest_name[0]['name']= chop($subtest_name[0]['name'],"(GROUP)");
                                     }
                                  $subtest_name[0]['name']=htmlspecialchars_decode($subtest_name[0]['name']);

                                    $this->Cell(150,6,strtoupper($subtest_name[0]['name']),1,0,'C');

                                     $this->Cell(30,6,$sublevel_bill_content['cost'],1,1,'C');
                                
                               
                                
                                 $total=$sublevel_bill_content['cost']+$total;

                                $j++;
                                }
                        }
                        else
                        {
                           

                           

                            if($single_bill_content_key==96)
                            {
                            	$this->Cell(150,$test_cell_height,strtoupper($test_name[0]['name']),'L,B',0,'C');

                            }
                            elseif($single_bill_content_key==20)
                            {

                            }
                            else
                            {
                            	 $this->Cell(70,$test_cell_height,strtoupper($test_name[0]['name']),1,0,'C');
                            }

                            $total_sub_tests=count($single_bill_content_value)/2;

                            $total_sub_tests=ceil($total_sub_tests);

                            $j=1;

                                foreach($single_bill_content_value as $sublevel_bill_content)
                                {

                                $subtest_name=$inventory->getSingleSubTest($sublevel_bill_content['subtest_id']);


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
                                	 if($single_bill_content_key==96)
		                            {
		                            	$this->Cell(160);

		                            }
		                            elseif($single_bill_content_key==20)
		                            {
		                            	$this->Cell(10);
		                            }
		                            else
		                            {
		                            	$this->Cell(80);
		                            }
                                    
                                    
                                }



                               


                                    switch($single_bill_content_key)
                                {

                                	 case 20:
                                       $this->Cell(150,6,strtoupper($subtest_name[0]['name']),1,0,'C');
                                       $sublevel_bill_content['cost']=50;

                                         if($j==$total_sub_tests)
                                        {
                                            
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                           
                                            
                                        }
                                        elseif($j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }

                                       
                                                                                                     
                                       break;


                                    case 83:
                                       $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');
                                       $sublevel_bill_content['cost']=150;

                                         if($j==$total_sub_tests)
                                        {
                                            
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                           
                                            
                                        }
                                        elseif($j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }

                                       
                                                                                                     
                                       break;

                                      case 84:
                                       $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');
                                       $sublevel_bill_content['cost']=500;

                                         if($j==$total_sub_tests)
                                        {
                                            
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                           
                                            
                                        }
                                        elseif($j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }

                                       
                                                                                                     
                                       break;

                                       case 86:
                                       $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');
                                       $sublevel_bill_content['cost']=500;

                                         if($j==$total_sub_tests)
                                        {
                                            
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                           
                                            
                                        }
                                        elseif($j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }

                                       
                                                                                                     
                                       break;

                                        case 87:
                                       $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');
                                       $sublevel_bill_content['cost']=640;

                                         if($j==$total_sub_tests)
                                        {
                                            
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                           
                                            
                                        }
                                        elseif($j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }

                                       
                                                                                                     
                                       break;

                                       case 88:
                                       $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');
                                       $sublevel_bill_content['cost']=100;

                                         if($j==$total_sub_tests)
                                        {
                                            
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                           
                                            
                                        }
                                        elseif($j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }

                                       
                                                                                                     
                                       break;

                                         case 90:
                                       $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');
                                       $sublevel_bill_content['cost']=600;

                                         if($j==$total_sub_tests)
                                        {
                                            
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                           
                                            
                                        }
                                        elseif($j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }

                                       
                                                                                                     
                                       break;

                                          case 91:
                                       $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');
                                       $sublevel_bill_content['cost']=700;

                                         if($j==$total_sub_tests)
                                        {
                                            
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                           
                                            
                                        }
                                        elseif($j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }

                                       
                                                                                                     
                                       break;

                                         case 92:
                                       $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');
                                       $sublevel_bill_content['cost']=950;

                                         if($j==$total_sub_tests)
                                        {
                                            
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                           
                                            
                                        }
                                        elseif($j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }

                                       
                                                                                                     
                                       break;

                                       case 96:
                                       //$this->Cell(80,6,strtoupper("a"),'R',0,'C');

                                       

                                       $sublevel_bill_content['cost']=350;

                                         if($j==$total_sub_tests)
                                        {
                                            
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                           
                                            
                                        }
                                        elseif($j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }

                                       
                                                                                                     
                                       break;


                                       case 41:

                                       break;

                                       case 24:

                                       break;

                                       case 37:

                                       break;

                                    default:
                                     $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');

                                     $this->Cell(30,6,$sublevel_bill_content['cost'],1,1,'C');
                                     $total=$sublevel_bill_content['cost']+$total;
                                }
                               
                                
                               

                                    if($single_bill_content_key==41||$single_bill_content_key==24||$single_bill_content_key==37)
                                {
                                   $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');
                                       $sublevel_bill_content['cost']=50;

                                       $new_total_sub_tests=$total_sub_tests+1;
                                       
                                        if($i==$mid_test&&$j==$new_total_sub_tests)
                                        {

                                         
                                           $this->Cell(30,6,$sublevel_bill_content['cost'],'L,R',1,'C');
                                           $total=$sublevel_bill_content['cost']+$total;
                                         }
                                          elseif($i==count($new_bill_contents)&&$j==count($single_bill_content_value))
                                        {
                                                 $this->Cell(30,6,'','L,R,B',1,'C');
                                        }
                                         else
                                        {
                                                $this->Cell(30,6,'','L,R',1,'C');
                                        }
                                           
                                            
                                       

                                }
                                
                                //$this->Ln();

                                $j++;
                                }


                               
                        }
                        
                      

                    }
                    else
                    {

                            

                            $j=1;

                            foreach($single_bill_content_value as $sublevel_bill_content)
                            {

                                 $subtest_name=$inventory->getSingleSubTest($sublevel_bill_content['subtest_id']);

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

                                  if($subtest_name[0]['name']=="NA"||$subtest_name[0]['name']=="na")
                                  {
                                    $this->Cell(150,$test_cell_height,strtoupper($test_name[0]['name']),1,0,'C');

                                    

                                    $this->Cell(30,6,$sublevel_bill_content['cost'],1,1,'C');
                                    $total=$sublevel_bill_content['cost']+$total;
                                  }
                                  else
                                  {
                                    $this->Cell(70,$test_cell_height,strtoupper($test_name[0]['name']),1,0,'C');
                                    $this->Cell(80,6,strtoupper($subtest_name[0]['name']),1,0,'C');

                                     

                                    $this->Cell(30,6,$sublevel_bill_content['cost'],1,1,'C');
                                    $total=$sublevel_bill_content['cost']+$total;
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
   
   /*
            // Data
                foreach($data as $row)
                {
                    foreach($row as $col)
                        $this->Cell(48,6,$col,1,0,'C');
                    $this->Ln();
                }
        */

    $this->SetFont('Arial','B',11);
    $this->Ln(5);
    $this->Cell(160,6,'Total:'.$total,0,0,'R');
    $this->SetFont('Arial','',11);
    //$this->Cell(30,6,$total,0,0,'C');


    $this->Ln(15);
    $this->Cell(144);
    $this->SetFont('Arial','B',11);
    $this->Cell(48,6,'Generated By',0,0,'C');
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