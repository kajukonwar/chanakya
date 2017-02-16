<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';

require_once("$root/include/session_check.php");

require_once("$root/include/dbconfig.php");

date_default_timezone_set('Asia/Kolkata');
class Helper{

	private $result=array();

  public function __construct()
  {


  }

  //get the list of available test
  public function getTest()
  {

  	       $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare 
            
          
            $stmt = $conn->prepare("SELECT * FROM test");
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
     

  }//end get list

    //get the list of available test
  public function getSingleTest($id)
  {

           $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM test WHERE id=?");
            $stmt->bindParam(1,$id);
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
     

  }//end get list


  //get the list of available subtest
  public function getSubTest()
  {

           $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM subtest");
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
     

  }//end get list


    //get the list of available test
  public function getSingleSubTest($id)
  {

           $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM subtest WHERE id=?");
            $stmt->bindParam(1,$id);
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
     

  }//end get list  




    //get the list of available test
  public function getSubTestForTest($id)
  {

           $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM subtest WHERE test_id=?");
            $stmt->bindParam(1,$id);
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
     

  }//end get list
  public function getDoctors()
  {

        $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM doctor");
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            $stmt=null;
            $conn=null;
            return $this->result;

            

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 


  public function getSingleDoctor($id)
  {

        $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM doctor WHERE id=?");
            $stmt->bindParam(1,$id);
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 



  public function getStaff()
  {

        $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM staff");
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 

    public function getSingleStaff($id)
  {

        $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM staff WHERE id=?");
            $stmt->bindParam(1,$id);
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 

  //get reports
   public function getBills($status)
  {

        $dbconfig=new Dbconfig();
        date_default_timezone_set('Asia/Kolkata');

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare  
            if($status=="all")
            {
                $status1="pending";
                $status2="complete";

                $stmt = $conn->prepare("SELECT * FROM bill WHERE status=? OR status=?");
                $stmt->bindParam(1,$status1);
                $stmt->bindParam(2,$status2);
            }   
            else
            {
                $stmt = $conn->prepare("SELECT * FROM bill WHERE status=?");
                $stmt->bindParam(1,$status);
            }     
            
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 


   //get reports for a specific day
   public function getBillsDay($status,$day)
  {

        $dbconfig=new Dbconfig();
        date_default_timezone_set('Asia/Kolkata');

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            

            // prepare    
            if($status=="all")
            {
                $stmt = $conn->prepare("SELECT * FROM bill WHERE  DATE(created_on)=?");
               
                $stmt->bindParam(1,$day);
            } 

             if($status=="pending")
            {
                $stmt = $conn->prepare("SELECT * FROM bill WHERE status=? AND DATE(created_on)=?");

                $stmt->bindParam(1,$status);
                $stmt->bindParam(2,$day);
            }   

             if($status=="complete")
            {
                $stmt = $conn->prepare("SELECT * FROM bill WHERE status=? AND DATE(created_on)=?");

                $stmt->bindParam(1,$status);
                $stmt->bindParam(2,$day);
            }  
             

            
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 

  //get reports
   public function getSingleBill($id)
  {

        $dbconfig=new Dbconfig();

        date_default_timezone_set('Asia/Kolkata');
        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM bill WHERE id=?");
            $stmt->bindParam(1,$id);
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 

    //get the last bill row in the db
   public function getLastBill()
  {

        $dbconfig=new Dbconfig();

        date_default_timezone_set('Asia/Kolkata');
        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT  * FROM   bill ORDER BY  id DESC LIMIT     1;");
            
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  }


  //get reports
   public function getBillContents($id)
  {

        $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM bill_contents WHERE bill_id=?");
            $stmt->bindParam(1,$id);
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 
  

    //get reports
   public function getSingleBillContent($id)
  {

        $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM bill_contents WHERE id=?");
            $stmt->bindParam(1,$id);
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 

  //get single Report
   public function getSingleReport($id)
  {

        $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM report WHERE bill_id=?");
            $stmt->bindParam(1,$id);
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 

  //get single Report's single content
   public function getSingleReportContent($bill_id,$contents_id)
  {

        $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM report WHERE bill_id=? AND bill_contents_id=?");
            $stmt->bindParam(1,$bill_id);
            $stmt->bindParam(2,$contents_id);
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 

   //get available department names
   public function getDepartments()
  {

        $dbconfig=new Dbconfig();


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare          
            $stmt = $conn->prepare("SELECT * FROM department");
            
        
            $stmt->execute();

            $this->result = $stmt->fetchAll();
            return $this->result;

            $stmt=null;
            $conn=null;

          
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 


  } 



}//end class helper
?>
