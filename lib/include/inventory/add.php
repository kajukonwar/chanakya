<?php

if($_SERVER["REQUEST_METHOD"]=="POST")
{

    //if department form is submitted
  if(isset($_POST["save_department"]))

  {

    require_once("$root/lib/classes/class.inventory.php");
    //call the class
     $department=new Department($_POST['department_name']);
    //do validation
     $checkDepartmentErr=$department->validate();

     if($checkDepartmentErr[0]!="error")
     {
      //save test to db
      $save_department=$department->save();

      
     }
     else
     {
      $department_name_err=$checkDepartmentErr[1];
     }
  }


  //if test form is submitted
  if(isset($_POST["save_test"]))

  {

    require_once("$root/lib/classes/class.inventory.php");

    /*
    if(!isset($_POST['test_has_subtest']))
    {
      $_POST['test_has_subtest']=NULL;
    }
  	//call the class
     $test=new Test($_POST['test_name'],$_POST['test_has_subtest'],$_POST['test_department_name']);
     */


    //call the class
     $test=new Test($_POST['test_name']);
    //do validation
     $checkTestErr=$test->validate();

     if($checkTestErr[0]!="error")
     {
     	//save test to db
     	$save_test=$test->save();

      
     }
     else
     {
      $test_name_err=$checkTestErr[1];
     }
    
  }

  //if subtest form is submitted
   if(isset($_POST["save_subtest"]))

  {

    require_once("$root/lib/classes/class.inventory.php");

    //call the class
     $subtest=new Subtest($_POST['subtest_name'],$_POST['test_id'],$_POST['department_id'],$_POST['unit_name'],$_POST['default_value'],$_POST['price']);

    //do validation
     $checkSubErr=$subtest->validate();

     if($checkSubErr[0]!="error")
     {
      //save test to db
      $save_subtest=$subtest->save();
     }
    
  }

}


?>