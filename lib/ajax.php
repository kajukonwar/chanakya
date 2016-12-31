<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"])."/chanakya/chanakya";


require_once("$root/include/dbconfig.php");


require_once("$root/lib/classes/class.helper.php");

if(isset($_POST['test_data']))
{
$subtests=new Helper();
$available_subtests=$subtests->getSubTestForTest($_POST['test_data']);


echo json_encode($available_subtests);
}

if(isset($_POST['subtest_data']))
{
$subtests=new Helper();
$cost=$subtests->getSingleSubTest($_POST['subtest_data']);


echo json_encode($cost[0]);
}



if(isset($_POST['get_department_id']))
{
$dbconfig=new Dbconfig();


        try {

            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM subtest WHERE id=?");

            $stmt->bindParam(1,$_POST['get_department_id']);
                   
            $stmt->execute();

            $result = $stmt->fetchAll();

            // prepare          
            $stmt1 = $conn->prepare("SELECT * FROM department WHERE id=?");

            $stmt1->bindParam(1,$result[0]['department_id']);
                   
            $stmt1->execute();

            $result1=$stmt1->fetchAll();

            $stmt=null;
            $stmt1=null;
            $conn=null;
            
            

            echo json_encode($result1[0]['name']);
            
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 

}


if(isset($_POST['bill_content_data']))
{

$data=$_POST['bill_content_data'];


if(!isset($_SESSION['bill_contents']))
{

	$_SESSION['bill_contents']=array();
}



$bill_count=count($_SESSION['bill_contents']);

$_SESSION['bill_contents'][$data['index']]=array('bill_test_id'=>$data['bill_test_id'],'bill_subtest_id'=>$data['bill_subtest_id'],'bill_unit_cost'=>$data['bill_unit_cost']);


print_r($_SESSION['bill_contents']);

}




if(isset($_POST['remove_data']))
{

$data=$_POST['remove_data'];

if(isset($_SESSION['bill_contents'])&&!empty($_SESSION['bill_contents']))
{

unset($_SESSION['bill_contents'][$data]);


print_r($_SESSION['bill_contents']);
	
}


}


//save the bill data
if(isset($_POST['save_bill_data']))
{

parse_str($_POST['save_bill_data'], $data);


$status=array();


//error code 1 means empty value and 2 means validation error and 0 means no error

//check patient name
if(empty($data['patient_name']))
{
	$status['patient_name']=1;
}
else
{
	$patient_name=trim($data['patient_name']);

	if (!preg_match("/^[a-zA-Z ]*$/",$patient_name)) 
	{
  		$status['patient_name']=2;
	}
	else
	{
		$status['patient_name']=0;
	}

	
}

//check contact number
if(empty($data['patient_contact']))
{
	$status['patient_contact']=0;

	$patient_contact=NULL;
}
else
{
	$patient_contact=trim($data['patient_contact']);

	if (!preg_match("/^[0-9]{10}$/",$patient_contact)) 
	{
  		$status['patient_contact']=2;
	}
	else
	{
		$status['patient_contact']=0;
	}

	
}

//check age
if(empty($data['patient_age']))
{
	$status['patient_age']=1;
}
else
{
	$patient_age=trim($data['patient_age']);

	if (!preg_match("/^[1-9][0-9]{0,2}$/",$patient_age)) 
	{
  		$status['patient_age']=2;
	}
	else
	{
		$status['patient_age']=0;
	}
	
}

//check gender

if(!isset($data['patient_gender']))
{
	$status['patient_gender']=1;
}
else
{
	

	$patient_gender=test_input($data['patient_gender']);

	$status['patient_gender']=0;
}

//check email
if(empty($data['patient_email']))
{
	$status['patient_email']=0;

	$patient_email=NULL;
}
else
{
	$patient_email=trim($data['patient_email']);

	if (!filter_var($patient_email, FILTER_VALIDATE_EMAIL)) 
	{
       $status['patient_email']=2;
    }

	else
	{
		$status['patient_email']=0;
	}
	
}

//check address
if(empty($data['patient_address']))
{
	$patient_address=NULL;
}
else
{
	$patient_address=$data['patient_address'];
	
}


//check doctor refer

if(!isset($data['doctor_refer']))
{
	$status['doctor_refer']=1;
}
else
{
	$doctor_refer=$data['doctor_refer'];

	$status['doctor_refer']=0;
}

//check doctor name

if(isset($data['doctor_refer']))
{
	if($data['doctor_refer']=="yes")
	{
		if($data['bill_doctor_name']==0)
		{
			$status['bill_doctor_name']=1;
		}
		else
		{
			$doctor_id=$data['bill_doctor_name'];
			$status['bill_doctor_name']=0;
		}
	}
	else
	{
		$status['bill_doctor_name']=0;
		$doctor_id=NULL;
	}

}




//check bill content
if(!isset($_SESSION['bill_contents'])||empty($_SESSION['bill_contents']))

{

	$status['bill_contents']=1;

}
else
{
	$status['bill_contents']=0;
}



//save to DB
if($status['patient_name']==0&&$status['patient_contact']==0&&$status['patient_age']==0&&$status['patient_gender']==0&&$status['patient_email']==0&&$status['doctor_refer']==0&&$status['bill_contents']==0)
{

    /*
	if(!isset($status['bill_doctor_name']))
	{
		  $dbconfig=new Dbconfig();

		  $bill_status="pending";
        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("INSERT INTO bill(patient_name,patient_address,patient_contact,patient_email,patient_gender,patient_age,referred_by_doctor,doctor_id,staff_id,status) values(?,?,?,?,?,?,?,?,?,?)");

            $staff_id=1;

            $stmt->bindParam(1,$patient_name);
            $stmt->bindParam(2,$patient_address);
            $stmt->bindParam(3,$patient_contact);

            $stmt->bindParam(4,$patient_email);
            $stmt->bindParam(5,$patient_gender);
            $stmt->bindParam(6,$patient_age);

            $stmt->bindParam(7,$doctor_refer);
            $stmt->bindParam(8,$doctor_id);
            $stmt->bindParam(9,$staff_id);
            $stmt->bindParam(10,$bill_status);

            $stmt->execute();

            $lastInsertId = $conn->lastInsertId();

            if($lastInsertId)
            {
                $save_success=0;
	            foreach($_SESSION['bill_contents'] as $single_content)
	            {

	            	// prepare          
	            $stmt1 = $conn->prepare("INSERT INTO bill_contents(bill_id,test_id,subtest_id,cost) values(?,?,?,?)");

	            $stmt1->bindParam(1,$lastInsertId);
	            $stmt1->bindParam(2,$single_content['bill_test_id']);
	            $stmt1->bindParam(3,$single_content['bill_subtest_id']);

	            $stmt1->bindParam(4,$single_content['bill_unit_cost']);

	            $stmt1->execute();

                $lastInsertId1 = $conn->lastInsertId();

                //insert successfull--increase success counter
                 if($lastInsertId1)
                {
                                      
                    $save_success=$save_success+1;
                }



	            }

                //everything file--set  success status
                 if($save_success==count($_SESSION['bill_contents']))
                {
                                      
                    //set the save status--0 means no error, 1  means error

                    $status['save_error']=0;
                }
                //bill not saved--return error message
                else
                {    
                    //set the save status--0 means no error, 1  means error

                    $status['save_error']=1;
                }

                    $stmt=null;
                    $stmt1=null;
                    $conn=null;
            }

          

          	
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
	}

    */

	if(isset($status['bill_doctor_name'])&&$status['bill_doctor_name']==0)
	{
		
		$dbconfig=new Dbconfig();
		$bill_status="pending";

        try {
            
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("INSERT INTO bill(patient_name,patient_address,patient_contact,patient_email,patient_gender,patient_age,referred_by_doctor,doctor_id,staff_id,status) values(?,?,?,?,?,?,?,?,?,?)");

            $staff_id=1;

            $stmt->bindParam(1,$patient_name);
            $stmt->bindParam(2,$patient_address);
            $stmt->bindParam(3,$patient_contact);

            $stmt->bindParam(4,$patient_email);
            $stmt->bindParam(5,$patient_gender);
            $stmt->bindParam(6,$patient_age);

            $stmt->bindParam(7,$doctor_refer);
            $stmt->bindParam(8,$doctor_id);
            $stmt->bindParam(9,$staff_id);

            $stmt->bindParam(10,$bill_status);

            $stmt->execute();

            $lastInsertId = $conn->lastInsertId();

            if($lastInsertId)
            {

                $save_success=0;

	            foreach($_SESSION['bill_contents'] as $single_content)
	            {

	            	// prepare          
	            $stmt1 = $conn->prepare("INSERT INTO bill_contents(bill_id,test_id,subtest_id,cost) values(?,?,?,?)");

	            $stmt1->bindParam(1,$lastInsertId);
	            $stmt1->bindParam(2,$single_content['bill_test_id']);
	            $stmt1->bindParam(3,$single_content['bill_subtest_id']);

	            $stmt1->bindParam(4,$single_content['bill_unit_cost']);

	            $stmt1->execute();

                $lastInsertId1 = $conn->lastInsertId();

	            

                 //insert successfull--increase success counter
                 if($lastInsertId1)
                {
                                      
                    $save_success=$save_success+1;
                }



                }

                //everything file--set  success status
                 if($save_success==count($_SESSION['bill_contents']))
                {
                                      
                    //set the save status--0 means no error, 1  means error
                    unset($_SESSION['bill_contents']);
                    $status['save_error']=0;

                    $status['current_bill_id']=$lastInsertId;
                }
                //bill not saved--return error message
                else
                {    
                    //set the save status--0 means no error, 1  means error

                    $status['save_error']=1;
                }

                    $stmt=null;
                    $stmt1=null;
                    $conn=null;
            }

           
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
	}

    else
    {
        //set the save status--0 means no error, 1  means error

        $status['save_error']=1;
    }
}
else
{
    //set the save status--0 means no error, 1  means error

    $status['save_error']=1;
}


//return the status
echo json_encode($status);



}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//fill pending report
if(isset($_POST['save_report_data']))
{
parse_str($_POST['save_report_data'], $report_data);

//extract and remove the bill id
$current_bill_id=$report_data['current_bill_id'];

unset($report_data['current_bill_id']);

$billContents=new Helper();

$staff_id=1;

$notes="";

$dbconfig=new Dbconfig();


//to check whether all insert to db is successfull
$success_count=0;

//$report_data has contents of report
foreach($report_data as $key=>$value)
{

        //$key is the unique id of bill_contents table
		$single_bill_content=$billContents->getSingleBillContent($key);

		//extra protection--count of rows extracted has to be 1 and only 1

        if(count($single_bill_content)==1)

        {

         try {
            
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("INSERT INTO report(bill_id,bill_contents_id,test_id,subtest_id,result,notes,staff_id) values(?,?,?,?,?,?,?)");

          

            $stmt->bindParam(1,$current_bill_id);
            $stmt->bindParam(2,$key);
            $stmt->bindParam(3,$single_bill_content[0]['test_id']);

            $stmt->bindParam(4,$single_bill_content[0]['subtest_id']);
            $stmt->bindParam(5,$value);
            $stmt->bindParam(6,$notes);

            $stmt->bindParam(7,$staff_id);
            
            $last_insert_count = $conn->rowCount();

                

                 //insert successfull--increase success counter
                 if($last_insert_count==1)
                {
                                      
                    $save_success=$save_success+1;

                    //set the status as complete

                    $bill_status="complete";

                    $stmt1 = $conn->prepare("UPDATE  bill set status=? WHERE id=?");

                    $stmt1->bindParam(1,$bill_status);
                    $stmt1->bindParam(2,$current_bill_id);  

                    $stmt1->execute();

                    $stmt=null;
   
                    $stmt1=null;
           
                    $conn=null;
                }

           

            
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


        }




}

//check success count
if($success_count==count($report_data))
{
    return "success";
}
else
{
    return "error";
}

}


//update completed report

if(isset($_POST['update_report_data']))
{
parse_str($_POST['update_report_data'], $report_data);

$current_bill_id=$report_data['current_bill_id'];

unset($report_data['current_bill_id']);
$dbconfig=new Dbconfig();

foreach($report_data as $key=>$value)
{


		 try {
            
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("UPDATE report SET result=? WHERE id=?");       

            $stmt->bindParam(1,$value);
            $stmt->bindParam(2,$key);
            $stmt->execute();
            $stmt=null;       
            $conn=null;          
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 

}





}

//get the new bill id

if(isset($_POST['get_new_bill_id']))
{

$dbconfig=new Dbconfig();

$bills=new Helper();

$last_bills=$bills->getLastBill();

                    

if(!empty($last_bills))
{

  $new_bill_no=$last_bills[0]['id']+1;
}
else
{
    $new_bill_no=0;
}

echo json_encode($new_bill_no);

}


?>