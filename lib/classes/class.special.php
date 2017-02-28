<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$root= realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';

require_once("$root/include/session_check.php");

require_once("$root/include/dbconfig.php");
date_default_timezone_set('Asia/Kolkata');

class Special
{



	/**
	 * Validation
	 */

	public function validate($special_form_data)
	{

		$special_validation_data=array();

		//bill contents
		if(empty($special_form_data['special_bill_editor']))
		{
			$special_validation_data['special_bill_editor_err']="Please enter bill contents";
		}
		else
		{
			$bill_contents=$special_form_data['special_bill_editor'];

			$special_validation_data['special_bill_editor']=$bill_contents;
			
		}

		//bill total cost
			if(empty($special_form_data['bill_cost']))
		{
			$special_validation_data['bill_cost_err']="Please enter bill cost";
		}
		else
		{
			$bill_cost=trim($special_form_data['bill_cost']);

			if (!preg_match("/^[1-9][0-9]*$/",$bill_cost)) 
			{
		  		$special_validation_data['bill_cost_err']="Please enter a valid bill cost";
			}

			$special_validation_data['bill_cost']=$bill_cost;
			
		}


		//patient name
		if(empty($special_form_data['patient_name']))
		{
			$special_validation_data['patient_name_err']="Please enter patient name";
		}
		else
		{
			$patient_name=trim($special_form_data['patient_name']);

			$special_validation_data['patient_name']=$patient_name;

			if (!preg_match("/^[a-zA-Z ]*$/",$patient_name)) 
			{
		  		$special_validation_data['patient_name_err']="Please enter a valid patient name";
			}
			
		}

		//patient contact

		if(empty($special_form_data['patient_contact']))
		{
			$patient_contact=NULL;
		}
		else
		{
			$patient_contact=trim($special_form_data['patient_contact']);

			$special_validation_data['patient_contact']=$patient_contact;


			if (!preg_match("/^[0-9]{10}$/",$patient_contact)) 
			{
		  		$special_validation_data['patient_contact_err']="Please enter a 10 digit number";
			}
			
		}

		//patient age

		if(empty($special_form_data['patient_age']))
		{
			$special_validation_data['patient_age_err']="Please enter patient age";
		}
		else
		{
			$patient_age=trim($special_form_data['patient_age']);

			
			$special_validation_data['patient_age']=$patient_age;
			
		}

		//patient gender
		if(!isset($special_form_data['patient_gender']))
		{
			$special_validation_data['patient_gender_err']="Please enter patient gender";
		}
		else
		{
			

			$patient_gender=trim($special_form_data['patient_gender']);

			$special_validation_data['patient_gender']=$patient_gender;
			

			
		}

		//patient email
		if(empty($special_form_data['patient_email']))
		{
			

			$patient_email=NULL;
		}
		else
		{
			$patient_email=trim($special_form_data['patient_email']);

			if (!filter_var($patient_email, FILTER_VALIDATE_EMAIL)) 
			{
		       $special_validation_data['patient_email_err']="Please enter a valid email";
		    }

			$special_validation_data['patient_email']=$patient_email;
			
		}

		//patient address
		if(empty($special_form_data['patient_address']))
		{
			$patient_address=NULL;
		}
		else
		{
			$patient_address=$special_form_data['patient_address'];
			

			$special_validation_data['patient_address']=$patient_address;
		}

		//doctor refer
		if(!isset($special_form_data['doctor_refer']))
		{
			
		       $special_validation_data['doctor_refer_err']="Please choose this option";
		}
		else
		{
			$doctor_refer=$special_form_data['doctor_refer'];


			$special_validation_data['doctor_refer']=$doctor_refer;
			
		}

		//doctor name
		
		if(isset($special_form_data['doctor_refer']))
		{
			//check only if doctor refer is selected as yes
			if($special_form_data['doctor_refer']=="yes")
			{
				if($special_form_data['bill_doctor_name']==0)
				{
					$special_validation_data['bill_doctor_name_err']="Please choose a Doctor name";
				}
				else
				{

					$doctor_id=$special_form_data['bill_doctor_name'];


					$special_validation_data['bill_doctor_name']=$doctor_id;
			
				}
			}
			else
			{
				$doctor_id=NULL;
			}
			

		}

		//check for errors and save to DB

		if(!isset($special_validation_data['special_bill_editor_err'])&&!isset($special_validation_data['patient_name_err'])&&!isset($special_validation_data['patient_contact_err'])&&!isset($special_validation_data['patient_age_err'])&&!isset($special_validation_data['patient_gender_err'])&&!isset($special_validation_data['patient_email_err'])&&!isset($special_validation_data['doctor_refer_err'])&&!isset($special_validation_data['bill_doctor_name_err'])&&!isset($special_validation_data['bill_cost_err']))
		{

			//no error-- save to DB
			$this->save($bill_contents,$bill_cost,$patient_name,$patient_contact,$patient_age,$patient_gender,$patient_email,$patient_address,$doctor_refer,$doctor_id);


		}
		else
		{
			//error- handle errors

			
			

			return $special_validation_data;
		}

		

	}//End validation
	/**
	 * Save bill
	 */
	public function save($bill_contents,$bill_cost,$patient_name,$patient_contact,$patient_age,$patient_gender,$patient_email,$patient_address,$doctor_refer,$doctor_id)
	{
		$dbconfig=new Dbconfig();
		$bill_status="pending";
		try {
            
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("INSERT INTO bill(patient_name,patient_address,patient_contact,patient_email,patient_gender,patient_age,referred_by_doctor,doctor_id,staff_id,status,is_special) values(?,?,?,?,?,?,?,?,?,?,?)");

            if(isset($_SESSION['user_id']))
                {
                    $staff_id=$_SESSION['user_id'];
                }
                else
                {
                    $staff_id=0;
                }

            $is_special="yes";
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

            $stmt->bindParam(11,$is_special);

            $stmt->execute();

            $bill_lastInsertId = $conn->lastInsertId();

            if($bill_lastInsertId)
            {

             

	          
	            	// prepare          
	            $stmt1 = $conn->prepare("INSERT INTO bill_contents(bill_id,test_id,subtest_id,cost,special_bill_content) values(?,?,?,?,?)");

	            $test_id=0;
	            $subtest_id=0;
	            $stmt1->bindParam(1,$bill_lastInsertId);
	            $stmt1->bindParam(2,$test_id);
	            $stmt1->bindParam(3,$subtest_id);

	            $stmt1->bindParam(4,$bill_cost);
	            $stmt1->bindParam(5,$bill_contents);

	            $stmt1->execute();

                $bill_contents_lastInsertId = $conn->lastInsertId();

	            $stmt=null;
                $stmt1=null;
                $conn=null;

                 //insert successfull--show print options
                 if($bill_contents_lastInsertId)
                {


				//redirect now
				header("Location:http://localhost/chanakya/lib/pdf/bill_special.php?b_id=".$bill_lastInsertId);
                        
                }



           
                    
            }

           
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
	}//end save

	/**
	 * Validate report data
	 *@param report contents
	 */

	public function validate_report($contents)
	{

		if(empty($contents))
		{
			return "Please enter report content";
		}
		else
		{
			return "";
		}

	}//end validate report

	/**
	 * Save pending report
	 * @param report contents
	 */

	 public function save_report($bill_id,$bill_contents_id,$test_id,$subtest_id,$report_contents)
	 {

	 	$dbconfig=new Dbconfig();
	
		try {
            
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("INSERT INTO report(bill_id,bill_contents_id,test_id,subtest_id,result,notes,staff_id) values(?,?,?,?,?,?,?)");

            if(isset($_SESSION['user_id']))
                {
                    $staff_id=$_SESSION['user_id'];
                }
                else
                {
                    $staff_id=0;
                }

            $notes="";
            $stmt->bindParam(1,$bill_id);
            $stmt->bindParam(2,$bill_contents_id);
            $stmt->bindParam(3,$test_id);

            $stmt->bindParam(4,$subtest_id);
            $stmt->bindParam(5,$report_contents);

            $stmt->bindParam(6,$notes);
            $stmt->bindParam(7,$staff_id);

            $stmt->execute();

            $report_lastInsertId = $conn->lastInsertId();

            if($report_lastInsertId)
            {
            

            	//set the status as complete

                 $bill_status="complete";

                 $stmt1 = $conn->prepare("UPDATE  bill set status=? WHERE id=?");

                  $stmt1->bindParam(1,$bill_status);
                  $stmt1->bindParam(2,$bill_id);  

                  $stmt1->execute();

                  $stmt=null;
       
                  $stmt1=null;
               
                  $conn=null;
				//redirect now
				header("Location:http://localhost/chanakya/templates/report/status_special.php?r_id=".$report_lastInsertId);
        
            }
       
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 

	 }//end save report


	 /**
	 * Update saved  report
	 * @param report ID, report contents
	 */

	 public function update_report($bill_id,$report_contents)
	 {

	 	$dbconfig=new Dbconfig();
	
		try {
            
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("UPDATE report SET result=? WHERE bill_id=?");

            $stmt->bindParam(1,$report_contents);
            $stmt->bindParam(2,$bill_id);
            $stmt->execute();

			//redirect now
			header("Location:http://localhost/chanakya/templates/report/update_special.php?id=".$bill_id);
        
       
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 

	 }//end update report


}//end class


?>