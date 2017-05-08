<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");
require_once("$root/include/dbconfig.php");
require_once("$root/lib/classes/class.helper.php");


function send_sms($number,$whom,$total_transaction)
{


if($whom=="owner")
{
$message="Hi, Total transaction done for today is Rs. ".$total_transaction;



}

if($whom=="patient")
{
$message="Hello, your medical report is ready to be collected from Chanakya Diagnostics Laboratory";

}

// Textlocal account details

$username = urlencode('chanakyalab');

$password = urlencode('anupmohan');

// Message details

$number = urlencode($number);

$sender = urlencode('CDLREP');

$message = urlencode($message);

// Prepare data for POST request


$data = 'username='.$username.'&password='.$password.'&sendername='.$sender.'&mobileno='.$number.'&message='.$message;

// Send the GET request with cURL


$ch = curl_init('http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp?'.$data);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

// Process your response here

return $response;

//return $total_transaction;

}



//send SMS to patient
if(isset($_POST['send_report_sms']))
{
parse_str($_POST['send_report_sms'], $report_id);

   //get patient details

    $report_details = new Helper();
  
    $patient_details=$report_details->getSingleBill($report_id['report_id']);

    //$patient_details[0]['patient_contact']="7760495700";

    if(!empty($patient_details[0]['patient_contact']))
    {

        //its is dummy value just to pass the parameter
        $total_transaction=0;
        $send_status=send_sms($patient_details[0]['patient_contact'],"patient",$total_transaction);
    }
    else
    {

        $send_status="Error: No mobile number provided";
    }

    echo $send_status;

}

//send SMS to owner
if(isset($_POST['send_sms_owner']))
{

   date_default_timezone_set('Asia/Kolkata');

   $today=date("Y-m-d");

   $number="9435158914";

   

   //get total bill details

    $bill_total_details = new Helper();

    $total_bills= $bill_total_details->getBillsDay("all",$today);

    if(empty($total_bills))
    {
        $bill_value=0;
    }
    else
    {
        $count=0;

        foreach($total_bills as $single_bill)
        {
           //get the total cost for each bill

            //indicates whether the cost of special group tests were counted for once
            $test_83_counted="no";
            $test_84_counted="no";
            $test_86_counted="no";
            $test_87_counted="no";
            $test_88_counted="no";
            $test_90_counted="no";
            $test_91_counted="no";
            $test_92_counted="no";

            //these are urology tests
            $test_41_counted="no";
            $test_24_counted="no";
            $test_37_counted="no";
            
            $urology_counted="no";

            

                 $single_bill_details=$bill_total_details->getBillContents($single_bill['id']);



                    if(!empty($single_bill_details))
                    {
                        foreach($single_bill_details as $single_bill_content)
                        {

                            switch($single_bill_content['test_id'])
                            {

                                case 83:

                                //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_83_counted=="no")
                                {
                                    $count=$count+150;
                                    $test_83_counted="yes";
                                }

                                break;

                                case 84:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_84_counted=="no")
                                {
                                    $count=$count+500;
                                    $test_84_counted="yes";
                                }

                                break;

                                case 86:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_86_counted=="no")
                                {
                                    $count=$count+500;
                                    $test_86_counted="yes";
                                }

                                break;

                                case 87:

                                
                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_87_counted=="no")
                                {
                                    $count=$count+640;
                                    $test_87_counted="yes";
                                }

                                break;

                                case 88:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_88_counted=="no")
                                {
                                    $count=$count+100;
                                    $test_88_counted="yes";
                                }

                                break;

                                 case 90:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_90_counted=="no")
                                {
                                    $count=$count+600;
                                    $test_90_counted="yes";
                                }

                                break;

                                case 91:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_91_counted=="no")
                                {
                                    $count=$count+700;
                                    $test_91_counted="yes";
                                }

                                break;

                                case 92:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_92_counted=="no")
                                {
                                    $count=$count+900;
                                    $test_92_counted="yes";
                                }

                                break;

                                 case 41:

                                // for urology we check both the subtest and test count-cost is increased only for the first time
                                 if($test_41_counted=="no"&&$urology_counted=="no")
                                {
                                    $count=$count+50;
                                    $test_41_counted="yes";
                                    $urology_counted="yes";
                                }

                                break;

                                case 24:

                                 if($test_24_counted=="no"&&$urology_counted=="no")
                                {
                                    $count=$count+50;
                                    $test_24_counted="yes";
                                    $urology_counted="yes";
                                }

                                break;

                                case 37:

                                 if($test_37_counted=="no"&&$urology_counted=="no")
                                {
                                    $count=$count+50;
                                    $test_37_counted="yes";
                                    $urology_counted="yes";
                                }

                                break;

                                default:

                                 $count=$single_bill_content['cost']+$count;

                            }
                           
                        }
                    }

           

           
        }

        $bill_value=$count;
    }



   $send_status=send_sms($number,"owner",$bill_value);


    echo $send_status;
  

}

?>

