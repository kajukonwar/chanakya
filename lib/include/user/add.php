<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");

if($_SERVER["REQUEST_METHOD"]=="POST")
{

  //if save user form is submitted
  if(isset($_POST["save_staff"]))

  {

    require_once("$root/lib/classes/class.user.php");
    if(!isset($_POST['user_gender']))
    {
      $_POST['user_gender']="";
    }
    $staff_object=new Staff($_POST['user_name'],$_POST['user_email'],$_POST['user_contact'],$_POST['user_address'],$_POST['user_gender'],$_POST['user_role'],$_POST['user_login'],$_POST['user_password']);
    //check for errors
    $staffErr=$staff_object->validate();

  
    if(empty($staffErr))
    {
    	

    	$staff_save_status=$staff_object->save();
    }
    else
    {
      $staff_save_status="error";
    }
  	
  }

  

  //if save doctor form is submitted
   if(isset($_POST["save_doctor"]))

  {

    require_once("$root/lib/classes/class.user.php");
    $doctor_object=new Doctor($_POST['doctor_name'],$_POST['doctor_email'],$_POST['doctor_contact'],$_POST['doctor_address'],$_POST['doctor_designation'],$_POST['doctor_hospital']);
    //check for errors
    $doctorErr=$doctor_object->validate();
    if(empty($doctorErr))
    {
    	

    	$doctor_save_status=$doctor_object->save();
    }
    else
    {
      $doctor_save_status="error";
    }
  	
  }



}


?>