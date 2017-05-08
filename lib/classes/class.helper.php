<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]);

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



  /**
   * transaction for given day
   * @param date
   * @return total transaction value
   */
  public function get_transaction_day($date)
  {


   date_default_timezone_set('Asia/Kolkata');

   //$today=date("Y-m-d");

   $today=$date;

   //get total bill details


    $total_bills=$this->getBillsDay("all",$today);

    if(empty($total_bills))
    {
        $bill_value=0;
    }
    else
    {
        $count=0;

        foreach($total_bills as $single_bill)
        {
           //get the total cost for each bill

            //indicates whether the cost of special group tests were counted for once
            $test_83_counted="no";
            $test_84_counted="no";
            $test_86_counted="no";
            $test_87_counted="no";
            $test_88_counted="no";
            $test_90_counted="no";
            $test_91_counted="no";
            $test_92_counted="no";

            //these are urology tests
            $test_41_counted="no";
            $test_24_counted="no";
            $test_37_counted="no";
            
            $urology_counted="no";

            

            $single_bill_details=$this->getBillContents($single_bill['id']);

             if(!empty($single_bill_details))
                    {
                        foreach($single_bill_details as $single_bill_content)
                        {

                            switch($single_bill_content['test_id'])
                            {

                                case 83:

                                //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_83_counted=="no")
                                {
                                    $count=$count+150;
                                    $test_83_counted="yes";
                                }

                                break;

                                case 84:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_84_counted=="no")
                                {
                                    $count=$count+500;
                                    $test_84_counted="yes";
                                }

                                break;

                                case 86:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_86_counted=="no")
                                {
                                    $count=$count+500;
                                    $test_86_counted="yes";
                                }

                                break;

                                case 87:

                                
                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_87_counted=="no")
                                {
                                    $count=$count+640;
                                    $test_87_counted="yes";
                                }

                                break;

                                case 88:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_88_counted=="no")
                                {
                                    $count=$count+100;
                                    $test_88_counted="yes";
                                }

                                break;

                                 case 90:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_90_counted=="no")
                                {
                                    $count=$count+600;
                                    $test_90_counted="yes";
                                }

                                break;

                                case 91:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_91_counted=="no")
                                {
                                    $count=$count+700;
                                    $test_91_counted="yes";
                                }

                                break;

                                case 92:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_92_counted=="no")
                                {
                                    $count=$count+900;
                                    $test_92_counted="yes";
                                }

                                break;

                                 case 41:

                                // for urology we check both the subtest and test count-cost is increased only for the first time
                                 if($test_41_counted=="no"&&$urology_counted=="no")
                                {
                                    $count=$count+50;
                                    $test_41_counted="yes";
                                    $urology_counted="yes";
                                }

                                break;

                                case 24:

                                 if($test_24_counted=="no"&&$urology_counted=="no")
                                {
                                    $count=$count+50;
                                    $test_24_counted="yes";
                                    $urology_counted="yes";
                                }

                                break;

                                case 37:

                                 if($test_37_counted=="no"&&$urology_counted=="no")
                                {
                                    $count=$count+50;
                                    $test_37_counted="yes";
                                    $urology_counted="yes";
                                }

                                break;

                                default:

                                 $count=$single_bill_content['cost']+$count;

                            }//end switch
                           
                        }//end foreach

                }//end if

           
        }//end foreach
  
        $bill_value=$count;
    }//end else


    return $bill_value;


  }//end get_transaction for day



  /**
   * Overall transaction till date
   * @return overall transaction
   */

  public function get_all_transaction()
  {

 
   //get total bill details


    $total_bills=$this->getBills("all");

    if(empty($total_bills))
    {
        $bill_value=0;
    }
    else
    {
        $count=0;

        foreach($total_bills as $single_bill)
        {
           //get the total cost for each bill

            //indicates whether the cost of special group tests were counted for once
            $test_83_counted="no";
            $test_84_counted="no";
            $test_86_counted="no";
            $test_87_counted="no";
            $test_88_counted="no";
            $test_90_counted="no";
            $test_91_counted="no";
            $test_92_counted="no";

            //these are urology tests
            $test_41_counted="no";
            $test_24_counted="no";
            $test_37_counted="no";
            
            $urology_counted="no";

            

            $single_bill_details=$this->getBillContents($single_bill['id']);

             if(!empty($single_bill_details))
                    {
                        foreach($single_bill_details as $single_bill_content)
                        {

                            switch($single_bill_content['test_id'])
                            {

                                case 83:

                                //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_83_counted=="no")
                                {
                                    $count=$count+150;
                                    $test_83_counted="yes";
                                }

                                break;

                                case 84:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_84_counted=="no")
                                {
                                    $count=$count+500;
                                    $test_84_counted="yes";
                                }

                                break;

                                case 86:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_86_counted=="no")
                                {
                                    $count=$count+500;
                                    $test_86_counted="yes";
                                }

                                break;

                                case 87:

                                
                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_87_counted=="no")
                                {
                                    $count=$count+640;
                                    $test_87_counted="yes";
                                }

                                break;

                                case 88:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_88_counted=="no")
                                {
                                    $count=$count+100;
                                    $test_88_counted="yes";
                                }

                                break;

                                 case 90:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_90_counted=="no")
                                {
                                    $count=$count+600;
                                    $test_90_counted="yes";
                                }

                                break;

                                case 91:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_91_counted=="no")
                                {
                                    $count=$count+700;
                                    $test_91_counted="yes";
                                }

                                break;

                                case 92:

                                 //for special group tests, the count is increased only for the first iteration(subtest as cost is constant)
                                if($test_92_counted=="no")
                                {
                                    $count=$count+900;
                                    $test_92_counted="yes";
                                }

                                break;

                                 case 41:

                                // for urology we check both the subtest and test count-cost is increased only for the first time
                                 if($test_41_counted=="no"&&$urology_counted=="no")
                                {
                                    $count=$count+50;
                                    $test_41_counted="yes";
                                    $urology_counted="yes";
                                }

                                break;

                                case 24:

                                 if($test_24_counted=="no"&&$urology_counted=="no")
                                {
                                    $count=$count+50;
                                    $test_24_counted="yes";
                                    $urology_counted="yes";
                                }

                                break;

                                case 37:

                                 if($test_37_counted=="no"&&$urology_counted=="no")
                                {
                                    $count=$count+50;
                                    $test_37_counted="yes";
                                    $urology_counted="yes";
                                }

                                break;

                                default:

                                 $count=$single_bill_content['cost']+$count;

                            }//end switch
                           
                        }//end foreach

                }//end if

           
        }//end foreach
  
        $bill_value=$count;
    }//end else


    return $bill_value;




  }//end overall transaction till date



}//end class helper
?>
