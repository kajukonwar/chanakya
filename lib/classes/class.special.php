<?php
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

		//patient name
		if(empty($special_form_data['patient_name']))
		{
			$special_form_error['patient_name_err']="Please enter patient name";
		}
		else
		{
			$patient_name=trim($special_form_data['patient_name']);

			if (!preg_match("/^[a-zA-Z ]*$/",$patient_name)) 
			{
		  		$special_form_error['patient_name_err']="Please enter a valid patient name";
			}
			
		}

		//patient contact

		if(empty($special_form_data['patient_contact']))
		{
			$patient_contact="";
		}
		else
		{
			$patient_contact=trim($special_form_data['patient_contact']);

			if (!preg_match("/^[0-9]{10}$/",$patient_contact)) 
			{
		  		$special_form_error['patient_contact_err']="Please enter a 10 digit number";
			}
			
		}

		//patient age

		if(empty($special_form_data['patient_age']))
		{
			$special_form_error['patient_age_err']="Please enter patient age";
		}
		else
		{
			$patient_age=trim($special_form_data['patient_age']);

			
			
		}

		//patient gender
		if(!isset($special_form_data['patient_gender']))
		{
			$special_form_error['patient_gender_err']="Please enter patient gender";
		}
		else
		{
			

			$patient_gender=test_input($special_form_data['patient_gender']);

			
		}

		//patient email
		if(empty($special_form_data['patient_email']))
		{
			

			$patient_email="";
		}
		else
		{
			$patient_email=trim($special_form_data['patient_email']);

			if (!filter_var($patient_email, FILTER_VALIDATE_EMAIL)) 
			{
		       $special_form_error['patient_email_err']="Please enter a valid email";
		    }
			
		}

		//patient address
		if(empty($special_form_data['patient_address']))
		{
			$patient_address="";
		}
		else
		{
			$patient_address=$special_form_data['patient_address'];
			
		}

		//doctor refer
		if(!isset($special_form_data['doctor_refer']))
		{
			
		       $special_form_error['doctor_refer_err']="Please choose this option";
		}
		else
		{
			$doctor_refer=$special_form_data['doctor_refer'];

			
		}

		//doctor name
		

		return $special_form_error;

	}
	/**
	 * Save
	 */
	public function save()
	{

	}


}//end class


?>