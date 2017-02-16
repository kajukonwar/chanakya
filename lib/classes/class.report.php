<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");
require_once("$root/include/dbconfig.php");
class Report{

        protected $user_name;
        protected $user_email;
        protected $user_contact;
        protected $user_address;
        protected $errors=array();
        protected $params=array();
        protected $sql;

    protected function __construct($name,$email,$contact,$address)
    {
      $this->user_name=$name;
      $this->user_email=$email;
      $this->user_contact=$contact;
      $this->user_address=$address;
    }

    protected function validate()
    {

      
      //name validation
      if(empty($this->user_name))
      {
        $this->errors['name']="Please enter the name";
      }
      //email validation
      if(empty($this->user_email))
      {
        $this->errors['email']="Please enter the email";
      }
      //contact validation
      if(empty($this->user_contact))
      {
        $this->errors['contact']="Please enter the contact number";
      }
      //address validation
      if(empty($this->user_address))
      {
        $this->errors['address']="Please enter the address";
      }
      

    }//end validation

    public function save()
    {


        $dbconfig=new Dbconfig();
         

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare($this->sql);
            $stmt->execute($this->params);
            
            $stmt=null;
            $conn=null;
            return "success";
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
    }





}//end class Report



?>