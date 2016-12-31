<?php

if($_SERVER["REQUEST_METHOD"]=="POST")
{

  //if test form is submitted
  if(isset($_POST["update_test"]))

  {

    require_once("$root/lib/classes/class.inventory.php");
  	//call the class
     $test=new Test($_POST['test_name']);
    //do validation
     $checkTestErr=$test->validate();

     if($checkTestErr[0]!="error")
     {
     	//save test to db
     	$update_test=$test->update($_POST['test_id']);
     }
      else
     {
      $test_name_err=$checkTestErr[1];
     }
  }

  //if subtest form is submitted
  if(isset($_POST["update_subtest"]))

  {

    require_once("$root/lib/classes/class.inventory.php");
    //call the class
     $subtest=new Subtest($_POST['subtest_name'],$_POST['test_id'],$_POST['department_id'],$_POST['unit_name'],$_POST['default_value'],$_POST['price']);
    //do validation
     $checkSubTestErr=$subtest->validate();

     if($checkSubTestErr[0]!="error")
     {
      //save test to db
      $update_subtest=$subtest->update($_POST['subtest_id']);
     }
  }

 

}


?>