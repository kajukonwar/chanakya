<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");

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



$_SESSION['bill_contents'][$data['index']]=array('bill_test_id'=>$data['bill_test_id'],'bill_subtest_id'=>$data['bill_subtest_id'],'bill_unit_cost'=>$data['bill_unit_cost']);



$bill_count=count($_SESSION['bill_contents']);


//print_r($_SESSION['bill_contents']);

echo json_encode($bill_count);
}




if(isset($_POST['remove_data']))
{

$data=$_POST['remove_data'];

if(isset($_SESSION['bill_contents'])&&!empty($_SESSION['bill_contents']))
{

unset($_SESSION['bill_contents'][$data]);


$bill_count=count($_SESSION['bill_contents']);
echo json_encode($bill_count);
//print_r($_SESSION['bill_contents']);
	
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

/*
	if (!preg_match("/^[1-9][0-9]{0,2}$/",$patient_age)) 
	{
  		$status['patient_age']=2;
	}
	else
	{
		$status['patient_age']=0;
	}
	
    */

    $status['patient_age']=0;
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

            if(isset($_SESSION['user_id']))
                {
                    $staff_id=$_SESSION['user_id'];
                }
                else
                {
                    $staff_id=0;
                }

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

if(isset($_SESSION['user_id']))
{
    $staff_id=$_SESSION['user_id'];
}
else
{
    $staff_id=0;
}


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

            $stmt=$conn->prepare("SELECT id FROM report WHERE bill_id=? AND bill_contents_id=?");       
            $stmt->bindParam(1,$current_bill_id);
            $stmt->bindParam(2,$key);
            $stmt->execute();
            $existig_report_entry=$stmt->fetchAll();

            if(empty($existig_report_entry))
            {


                    // prepare          
                    $stmt = $conn->prepare("INSERT INTO report(bill_id,bill_contents_id,test_id,subtest_id,result,notes,staff_id) values(?,?,?,?,?,?,?)");

                  

                    $stmt->bindParam(1,$current_bill_id);
                    $stmt->bindParam(2,$key);
                    $stmt->bindParam(3,$single_bill_content[0]['test_id']);

                    $stmt->bindParam(4,$single_bill_content[0]['subtest_id']);
                    $stmt->bindParam(5,$value);
                    $stmt->bindParam(6,$notes);

                    $stmt->bindParam(7,$staff_id);

                    $stmt->execute();
                    
                    $last_insert_count = $stmt->rowCount();

                          //insert successfull--increase success counter
                     if($last_insert_count==1)
                    {
                                          
                        $success_count=$success_count+1;

                        //check success count
                        if($success_count==count($report_data))
                        {

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

    $status[0]="success";
    $status[1]=$current_bill_id;
    echo json_encode($status);
}
elseif($success_count>0&&$success_count<3)
{
    $status[0]="partial";
    $status[1]=$current_bill_id;
    echo json_encode($status);
}
else
{
    $status[0]="error";
    $status[1]=$current_bill_id;
    echo json_encode($status);
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

            if($stmt->execute())
            {
                $status[0]="success";
                $status[1]=$current_bill_id;
                $stmt=null;       
                $conn=null;
                echo json_encode($status);
            }
            else
            {
                $status[0]="error";
                $status[1]=$current_bill_id;
                $stmt=null;       
                $conn=null;
                echo json_encode($status);
            }
                    
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


//begin-- bill search
if(isset($_POST['bill_search']))
{

    parse_str($_POST['bill_search'], $data);


    if(!empty($data['bill_search_date']))
    {
        //extract search date
        $search_date=$data['bill_search_date'];

        //store start date and end date into an array
        $search_date=explode("-",$search_date);

        $start_date=str_replace("/","-",$search_date[0]);
        $end_date=str_replace("/","-",$search_date[1]);
    }

    

    //validation--all empty
    if(empty($data["bill_search_name"])&&empty($data["bill_search_id"])&&empty($data["bill_search_date"]))
    {
        $result="error";

    }
    //End-- all empty

    
    else
    {

        // only search name is present
        if(!empty($data["bill_search_name"])&&empty($data["bill_search_id"])&&empty($data["bill_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE patient_name=?";
            $params[]=$data["bill_search_name"];
        }

        //only search id is present
        if(empty($data["bill_search_name"])&&!empty($data["bill_search_id"])&&empty($data["bill_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE id=?";
            $params[]=$data["bill_search_id"];
        }

        //only search date is present

        if(empty($data["bill_search_name"])&&empty($data["bill_search_id"])&&!empty($data["bill_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE DATE(created_on) BETWEEN CAST(? AS DATE) AND CAST(? AS DATE)" ;
            $params[]=$start_date;
            $params[]=$end_date;
        }

        //search name and search id r present

        if(!empty($data["bill_search_name"])&&!empty($data["bill_search_id"])&&empty($data["bill_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE patient_name=? AND id=?";
            $params[]=$data["bill_search_name"];
            $params[]=$data["bill_search_id"];
        }

        //search name and search date r present

        if(!empty($data["bill_search_name"])&&empty($data["bill_search_id"])&&!empty($data["bill_search_date"]))
    
        {
           $query="SELECT * FROM bill WHERE patient_name=? AND DATE(created_on) BETWEEN CAST(? AS DATE) AND CAST(? AS DATE) ";
            $params[]=$data["bill_search_name"];
            $params[]=$start_date;
            $params[]=$end_date;
        }

        // search id ad search date r present
        if(empty($data["bill_search_name"])&&!empty($data["bill_search_id"])&&!empty($data["bill_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE id=? AND DATE(created_on) BETWEEN CAST(? AS DATE) AND CAST(? AS DATE) ";
            $params[]=$data["bill_search_id"];
            $params[]=$start_date;
            $params[]=$end_date;
        }

        //all the values r present

        if(!empty($data["bill_search_name"])&&!empty($data["bill_search_id"])&&!empty($data["bill_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE patient_name=? AND id=? AND DATE(created_on) BETWEEN CAST(? AS DATE) AND CAST(? AS DATE) ";

            $params[]=$data["bill_search_name"];
            $params[]=$data["bill_search_id"];
            $params[]=$start_date;
            $params[]=$end_date;
        }
        //end making query

        //modify the query based on status and  append the status to the query
        if($data["bill_search_status"]=="pending")
        {
            $query=$query." AND status=?";
            $params[]="pending";
        }
        elseif($data["bill_search_status"]=="complete")
        {
            $query=$query." AND status=?";
            $params[]="complete";
        }
        else
        {
            $query=$query." AND (status=? OR status=?)";
            $params[]="pending";
            $params[]="complete";
        }
        //END---append the status to the query

         $dbconfig=new Dbconfig();
    try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $result=$stmt->fetchAll();
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


    }

    if(empty($result))
    {
        $result="empty";
    }

    echo json_encode($result);
}//end --bill search


//begin-- report search
if(isset($_POST['report_search']))
{

    parse_str($_POST['report_search'], $data);


    if(!empty($data['report_search_date']))
    {
        //extract search date
        $search_date=$data['report_search_date'];

        //store start date and end date into an array
        $search_date=explode("-",$search_date);

        $start_date=str_replace("/","-",$search_date[0]);
        $end_date=str_replace("/","-",$search_date[1]);
    }

    //validation--all empty
    if(empty($data["report_search_name"])&&empty($data["report_search_id"])&&empty($data["report_search_date"]))
    {
        $result="error";

    }
    //End-- all empty
  
    else
    {

        // only search name is present
        if(!empty($data["report_search_name"])&&empty($data["report_search_id"])&&empty($data["report_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE patient_name=?";
            $params[]=$data["report_search_name"];
        }

        //only search id is present
        if(empty($data["report_search_name"])&&!empty($data["report_search_id"])&&empty($data["report_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE id=?";
            $params[]=$data["report_search_id"];
        }

        //only search date is present

        if(empty($data["report_search_name"])&&empty($data["report_search_id"])&&!empty($data["report_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE DATE(created_on) BETWEEN CAST(? AS DATE) AND CAST(? AS DATE)" ;
            $params[]=$start_date;
            $params[]=$end_date;
        }

        //search name and search id r present

        if(!empty($data["report_search_name"])&&!empty($data["report_search_id"])&&empty($data["report_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE patient_name=? AND id=?";
            $params[]=$data["report_search_name"];
            $params[]=$data["report_search_id"];
        }

        //search name and search date r present

        if(!empty($data["report_search_name"])&&empty($data["report_search_id"])&&!empty($data["report_search_date"]))
    
        {
           $query="SELECT * FROM bill WHERE patient_name=? AND DATE(created_on) BETWEEN CAST(? AS DATE) AND CAST(? AS DATE) ";
            $params[]=$data["report_search_name"];
            $params[]=$start_date;
            $params[]=$end_date;
        }

        // search id ad search date r present
        if(empty($data["report_search_name"])&&!empty($data["report_search_id"])&&!empty($data["report_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE id=? AND DATE(created_on) BETWEEN CAST(? AS DATE) AND CAST(? AS DATE) ";
            $params[]=$data["report_search_id"];
            $params[]=$start_date;
            $params[]=$end_date;
        }

        //all the values r present

        if(!empty($data["report_search_name"])&&!empty($data["report_search_id"])&&!empty($data["report_search_date"]))
    
        {
            $query="SELECT * FROM bill WHERE patient_name=? AND id=? AND DATE(created_on) BETWEEN CAST(? AS DATE) AND CAST(? AS DATE) ";

            $params[]=$data["report_search_name"];
            $params[]=$data["report_search_id"];
            $params[]=$start_date;
            $params[]=$end_date;
        }
        //end making query

        //modify the query based on status and  append the status to the query
        if($data["report_search_status"]=="pending")
        {
            $query=$query." AND status=?";
            $params[]="pending";
        }
        elseif($data["report_search_status"]=="complete")
        {
            $query=$query." AND status=?";
            $params[]="complete";
        }
        else
        {
            $query=$query." AND (status=? OR status=?)";
            $params[]="pending";
            $params[]="complete";
        }
        //END---append the status to the query

          $dbconfig=new Dbconfig();
    try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $result=$stmt->fetchAll();
         
            
        }
        catch(PDOException $e)
        {
            echo "DB Connection failed: " . $e->getMessage();
        } 


    }


    if(empty($result))
    {
        $result="empty";
    }

    echo json_encode($result);

}//end --report search

//begin-- transaction search
if(isset($_POST['transaction_search']))
{


    
    
    parse_str($_POST['transaction_search'], $transaction_data);


    if(!empty($transaction_data['transaction_search_date']))
    {
        //extract search date
        $search_date=$transaction_data['transaction_search_date'];

        
        //extract 
        $search_date=explode("/",$search_date);

        $new_search_date=$search_date[2]."-".$search_date[0]."-".$search_date[1];

        

        $transaction=new Helper();
        $transaction_day=$transaction->get_transaction_day($new_search_date);

        $result=$transaction_day;

        
    }

    //validation--all empty
    else
    {
        $result="error";
    }


    echo json_encode($result);
}//end --transaction search


//begin-- total doctor reference search
if(isset($_POST['d_reference_search']))
{

    parse_str($_POST['d_reference_search'], $data);


    if(!empty($data['d_reference_search_date']))
    {
        //extract search date
        $search_date=$data['d_reference_search_date'];

        //store start date and end date into an array
        $search_date=explode("-",$search_date);

        $start_date=str_replace("/","-",$search_date[0]);
        $end_date=str_replace("/","-",$search_date[1]);
    }

    

    //validation--any of one input is empty
    if(empty($data["d_reference_doctor_id"])||empty($data["d_reference_search_date"]))
    {
        $result="error";

    }
    //End-- all empty
    else
    {
         
     
            $query="SELECT * FROM bill WHERE doctor_id=?  AND DATE(created_on) BETWEEN CAST(? AS DATE) AND CAST(? AS DATE)";

            $params[]=$data["d_reference_doctor_id"];
            $params[]=$start_date;
            $params[]=$end_date;
        
        //end making query


         $dbconfig=new Dbconfig();
    try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                
                //get the total cost
                if(!empty($result))
                {
                    
                    $d_reference=new Helper();
                    $d_reference_value=$d_reference->get_transaction_bills($result);

                    $new_result=array();
                    $new_result['bills']=$result;
                    $new_result['total_value']=$d_reference_value;
                    $result=$new_result;

                }
                else
                {
                    $result="empty";
                }

            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
    }//end else
    

    

   

    echo json_encode($result);
}//end --total doctor reference search

?>