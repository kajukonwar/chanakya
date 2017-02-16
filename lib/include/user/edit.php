<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");
if($_SERVER["REQUEST_METHOD"]=="POST")
{

  //if test form is submitted
  if(isset($_POST["update_doctor"]))

  {

    require_once("$root/lib/classes/class.user.php");
  	//call the class
     $doctor=new Doctor($_POST['doctor_name'],$_POST['doctor_email'],$_POST['doctor_contact'],$_POST['doctor_address'],$_POST['doctor_designation'],$_POST['doctor_hospital']);
    //do validation
     $checkErr=$doctor->update($_POST['d_id']);

     if(empty($checkErr))
     {
     	//save test to db
     	$update_doctor=$doctor->save();
     }
  }



//if test form is submitted
  if(isset($_POST["update_staff"]))

  {

    require_once("$root/lib/classes/class.user.php");
    //call the class
     $staff=new Staff($_POST['user_name'],$_POST['user_email'],$_POST['user_contact'],$_POST['user_address'],$_POST['user_gender'],$_POST['user_role'],$_POST['user_login'],$_POST['user_password']);
    //do validation
     $checkErr=$staff->update($_POST['s_id']);

     if(empty($checkErr))
     {
      //save test to db
      $update_staff=$staff->save();
     }
  }


 

}


?>