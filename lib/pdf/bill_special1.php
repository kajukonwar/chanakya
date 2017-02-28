<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['V']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}



class PDF extends FPDF
{
    protected $B;
    protected $I;
    protected $U;
    protected $HREF;
    protected $fontList;
    protected $issetfont;
    protected $issetcolor;

    function __construct($orientation='P', $unit='mm', $format='A4')
    {
        //Call parent constructor
        parent::__construct($orientation,$unit,$format);
        //Initialization
        $this->B=0;
        $this->I=0;
        $this->U=0;
        $this->HREF='';
        $this->fontlist=array('arial', 'times', 'courier', 'helvetica', 'symbol');
        $this->issetfont=false;
        $this->issetcolor=false;
    }

    function WriteHTML($html)
        {
            //HTML parser
            $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote>"); 

            $html=str_replace("\n",' ',$html); 

            $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); 

            foreach($a as $i=>$e)
            {
                if($i%2==0)
                {
                    //Text
                    if($this->HREF)
                        $this->PutLink($this->HREF,$e);
                    else
                        $this->Write(5,stripslashes(txtentities($e)));
                }
                else
                {
                    //Tag
                    if($e[0]=='/')
                        $this->CloseTag(strtoupper(substr($e,1)));
                    else
                    {
                        //Extract attributes
                        $a2=explode(' ',$e);
                        $tag=strtoupper(array_shift($a2));
                        $attr=array();
                        foreach($a2 as $v)
                        {
                            if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                                $attr[strtoupper($a3[1])]=$a3[2];
                        }
                        $this->OpenTag($tag,$attr);
                    }
                }
            }

            return;
        }

        function OpenTag($tag, $attr)
        {
            //Opening tag
            switch($tag){
                case 'STRONG':
                    $this->SetStyle('B',true);
                    break;
                case 'EM':
                    $this->SetStyle('I',true);
                    break;
                case 'B':
                case 'I':
                case 'U':
                    $this->SetStyle($tag,true);
                    break;
                case 'A':
                    $this->HREF=$attr['HREF'];
                    break;
                case 'IMG':
                    if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                        if(!isset($attr['WIDTH']))
                            $attr['WIDTH'] = 0;
                        if(!isset($attr['HEIGHT']))
                            $attr['HEIGHT'] = 0;
                        $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
                    }
                    break;
                case 'TR':
                case 'BLOCKQUOTE':
                case 'BR':
                    $this->Ln(5);
                    break;
                case 'P':
                    $this->Ln(10);
                    break;
                case 'FONT':
                    if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                        $coul=hex2dec($attr['COLOR']);
                        $this->SetTextColor($coul['R'],$coul['V'],$coul['B']);
                        $this->issetcolor=true;
                    }
                    if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                        $this->SetFont(strtolower($attr['FACE']));
                        $this->issetfont=true;
                    }
                    break;
            }
        }



        function CloseTag($tag)
        {
            //Closing tag
            if($tag=='STRONG')
                $tag='B';
            if($tag=='EM')
                $tag='I';
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,false);
            if($tag=='A')
                $this->HREF='';
            if($tag=='FONT'){
                if ($this->issetcolor==true) {
                    $this->SetTextColor(0);
                }
                if ($this->issetfont) {
                    $this->SetFont('arial');
                    $this->issetfont=false;
                }
            }
        }

        function SetStyle($tag, $enable)
        {
            //Modify style and select corresponding font
            $this->$tag+=($enable ? 1 : -1);
            $style='';
            foreach(array('B','I','U') as $s)
            {
                if($this->$s>0)
                    $style.=$s;
            }
            $this->SetFont('',$style);
        }

        function PutLink($URL, $txt)
        {
            //Put a hyperlink
            $this->SetTextColor(0,0,255);
            $this->SetStyle('U',true);
            $this->Write(5,$txt,$URL);
            $this->SetStyle('U',false);
            $this->SetTextColor(0);
        }



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

            $this->SetFont('Arial','B',12);

            
            //print the bill contents html

            $this->WriteHTML($bill_contents[0]["special_bill_content"]);


            $stmt=null;
            $conn=null;

            }

          
         
            
            
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
   
   

    $this->SetFont('Arial','B',11);
    $this->Ln(55);
    $this->Cell(160,6,'Total:'.$bill_contents[0]["cost"],0,0,'R');
    $this->SetFont('Arial','',11);
    //$this->Cell(30,6,$total,0,0,'C');


    $this->Ln(15);
    $this->Cell(134);
    $this->SetFont('Arial','B',11);
    $this->Cell(58,6,'Generated By',0,0,'C');
}



}//END class

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