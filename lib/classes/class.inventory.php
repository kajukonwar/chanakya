
<?php
require_once("$root/include/dbconfig.php");
abstract class Inventory{

abstract protected function validate();
abstract protected function save();
//abstract protected function update($id);
//abstract protected function delete($id);


}

class Department extends Inventory{

        private $department_name;



  public function __construct($department_name=NULL)

  {
        
            $this->department_name=$department_name;
        
  }//end constructor

    public function validate()
    {
      $validation_status=array();

      if(empty($this->department_name))
      {
        $validation_status[0]="error";
        $validation_status[1]="Error: Please enter the department name";
        
      }
      else
      {

        $this->department_name=$this->test_input($this->department_name);
        $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare("SELECT * FROM department WHERE name=?");
            $stmt->bindParam(1,$this->department_name);
            
            $stmt->execute();

            $dept_exists=$stmt->fetchAll();

            if(!empty($dept_exists))
            {

            $validation_status[0]="error";
            $validation_status[1]="Error: This department already exists. Enter a different name";
            }
            else
            {
              $validation_status[0]="success";
            }
            
            $stmt=null;
            $conn=null; 
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }


      }
        
      return $validation_status;

    }//end validation

    public function save()
    {

          $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare("INSERT INTO department (name) VALUES (?)");
            $stmt->bindParam(1,$this->department_name);
            
            $stmt->execute();

            $lastInsertId =$conn->lastInsertId();
            
            if($lastInsertId)
            {

              $stmt=null;
              $conn=null;
              return "success";
            }
            else
            {
              
              return "error";
            }
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }
        

    }//end save

    protected function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

}//end department class



class Test extends Inventory{

        private $test_name;
        //private $test_has_subtest;
        //private $test_department_name;


  /*
	public function __construct($test_name=NULL,$test_has_subtest=NULL,$test_department_name=NULL)

	{
		    
            $this->test_name=$test_name;
            $this->test_has_subtest=$test_has_subtest;
            $this->test_department_name=$test_department_name;
    		
	}//end constructor
  */

    public function __construct($test_name=NULL)

  {
        
            $this->test_name=$test_name;
        
  }//end constructor

    public function validate()
    {
      $validation_status=array();

      if(empty($this->test_name))
      {
        $validation_status[0]="error";
        $validation_status[1]="Error: Please enter the test name";
        
      }
      else
      {
        $this->test_name=$this->test_input($this->test_name);
        $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare("SELECT * FROM test WHERE name=?");
            $stmt->bindParam(1,$this->test_name);
            
            $stmt->execute();

            $test_exists=$stmt->fetchAll();

            if(!empty($test_exists))
            {

            $validation_status[0]="error";
            $validation_status[1]="Error: This test already exists. Enter a different name";
            }
            else
            {
              $validation_status[0]="success";
            }
            
            $stmt=null;
            $conn=null; 
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }
      }

      /*
      if(empty($this->test_has_subtest))
      {
        $validation_status[0]="error";
        $validation_status[2]="Please select this option";
        
      }
      else
      {

        if($this->test_has_subtest=="yes")

        {
          if($this->test_department_name==0)
          {

            $validation_status[0]="error";

            $validation_status[2]="";
            $validation_status[3]="Please select a department";
          }
          else
          {

            $validation_status[0]="success";

            $validation_status[2]="";
            $validation_status[3]="";
          }
        }
        else
        {   
            $validation_status[0]="success";

            $validation_status[2]="";
            $validation_status[3]="";
        }

      }
      */
        
      return $validation_status;

    }//end validation


    protected function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    public function save()
    {

          $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare("INSERT INTO test (name) VALUES (?)");
            $stmt->bindParam(1,$this->test_name);
            
           $stmt->execute();

            $lastInsertId =$conn->lastInsertId();
            
            if($lastInsertId)
            {

              $stmt=null;
              $conn=null;
              return "success";
            }
            else
            {
              
              return "error";
            }
            
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }
        

    }//end save


    public function update($test_id)
    {

          $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare("UPDATE  test SET name=? WHERE id=?");
            $stmt->bindParam(1,$this->test_name);
            $stmt->bindParam(2,$test_id);
            $stmt->execute();
            $count = $stmt->rowCount();

            if($count>0)
            {
              $stmt=null;
              $conn=null;
              return "success";
            }
            else
            {
              $stmt=null;
              $conn=null;
              return "error";
            }
            
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }
        

    }//end update
    public function delete($test_id)
    {

          $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            
            $stmt = $conn->prepare("DELETE  FROM test WHERE id=?");

            
            $stmt->bindParam(1,$test_id);

            $stmt->execute();
            $count = $stmt->rowCount();

            if($count>0)
            {
              $stmt=null;
              $conn=null;
              return "success";
            }
            else
            {
              $stmt=null;
              $conn=null;
              return "error";
            }
            
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }
        

    }//end update


}//end class Test


class Subtest extends Inventory{

        private $subtest_name;
        private $test_id;
        private $department_id;
        private $unit;
        private $default_value;
        private $standard_price;



  public function __construct($subtest_name=NULL,$test_id=NULL,$department_id=NULL,$unit_name=NULL,$default_value=NULL,$standard_price=NULL)

  {
        
            $this->subtest_name=$subtest_name;
            $this->test_id=$test_id;
            $this->department_id=$department_id;
            $this->unit=$unit_name;
            $this->default_value=$default_value;
            $this->standard_price=$standard_price;
            
        
  }//end constructor

    public function validate()
    {
      
      $status=array();
      $status[0]="success";

      if(empty($this->subtest_name))
      {
        $status[0]="error";
        $status[1]="Error: Please enter the subtest name";
        
      }
      else
      {
        $this->subtest_name=$this->test_input($this->subtest_name);
        $status[1]="";
      }

      //for test ID
        if(empty($this->test_id))
      {
        $status[0]="error";
        $status[2]="Error: Please select the related test name";
        
      }
      elseif($this->test_id==0)
      {

        $status[0]="error";
        $status[2]="Error: Please select the related test name";
      
      }
      else
      {
          $status[2]="";
      }


      //for department ID
        if(empty($this->department_id)||$this->department_id==0)
      {
        $status[0]="error";
        $status[6]="Error: Please select the related departname name";
        
      }
     
      else
      {
          $status[6]="";
      }
      //for unit name
     
        if(empty($this->unit))
      {
        $status[0]="error";
        $status[3]="Error: Please enter the unit name";
        
      }
      else
      {
        $this->unit=$this->test_input($this->unit);
        $status[3]="";
      }

        //for default value
     
        if(empty($this->default_value))
      {
        $status[0]="error";
        $status[4]="Error: Please enter the default value";
        
      }
      else
      {
        $this->default_value=$this->test_input($this->default_value);
        $status[4]="";
      }
        
      //for standard price
     
        if(empty($this->standard_price))
      {
        $status[0]="error";
        $status[5]="Error: Please enter the standard price";
        
      }
      else
      {
        $this->standard_price=$this->test_input($this->standard_price);
        $status[5]="";
      }

      
      return $status;

    }//end validation

      protected function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    public function save()
    {

          $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare("INSERT INTO subtest (test_id,department_id,name,unit,default_value,standard_price) VALUES (?,?,?,?,?,?)");

            $stmt->bindParam(1,$this->test_id);
            $stmt->bindParam(2,$this->department_id);
            $stmt->bindParam(3,$this->subtest_name);
            $stmt->bindParam(4,$this->unit);
            $stmt->bindParam(5,$this->default_value);
            $stmt->bindParam(6,$this->standard_price);

            $stmt->execute();


            $lastInsertId =$conn->lastInsertId();
            
            if($lastInsertId)
            {

              $stmt=null;
              $conn=null;
              return "success";
            }
            else
            {
              $stmt=null;
              $conn=null;
            
              return "error";
            }
            
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }
        

    }//end save

 public function update($subtest_id)
    {

          $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            
            $stmt = $conn->prepare("UPDATE  subtest SET test_id=?,department_id=?,name=?,unit=?,default_value=?,standard_price=? WHERE id=?");

            $stmt->bindParam(1,$this->test_id);
            $stmt->bindParam(2,$this->department_id);
            $stmt->bindParam(3,$this->subtest_name);
            $stmt->bindParam(4,$this->unit);
            $stmt->bindParam(5,$this->default_value);
            $stmt->bindParam(6,$this->standard_price);
            $stmt->bindParam(7,$subtest_id);

            $stmt->execute();

            $count = $stmt->rowCount();

            if($count>0)
            {
              $stmt=null;
              $conn=null;
              return "success";
            }
            else
            {
              $stmt=null;
              $conn=null;
              return "error";
            } 
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }
        

    }//end update

 public function delete($subtest_id)
    {

          $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            
            $stmt = $conn->prepare("DELETE  FROM subtest WHERE id=?");

            
            $stmt->bindParam(1,$subtest_id);

            $stmt->execute();
            $stmt=null;
            $conn=null;
            return "success";
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }
        

    }//end update


}//end class Subtest

?>