<?php
$root= realpath($_SERVER["DOCUMENT_ROOT"]);

require_once("$root/include/session_check.php");
require_once("$root/include/dbconfig.php");
class User{

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
      else
      {
          $this->user_name=$this->test_input($this->user_name);

          if (!preg_match("/^[a-zA-Z ]*$/",$this->user_name)) 
          {
              $this->errors['name']="Please enter a valid name";
          }
      }
      //email validation
      /*
      if(empty($this->user_email))
      {
        $this->errors['email']="Please enter the email";
      }
      else
      {
            $this->user_email=$this->test_input($this->user_email); 

            if (!filter_var($this->user_email, FILTER_VALIDATE_EMAIL)) 
            {
               $this->errors['email']="Please enter a valid  email";
            }

      }
      */

      if(!empty($this->user_email))
      {

          $this->user_email=$this->test_input($this->user_email); 

          if (!filter_var($this->user_email, FILTER_VALIDATE_EMAIL)) 
          {
              $this->errors['email']="Please enter a valid  email";
          }

      }
      


      //contact validation
      /*
      if(empty($this->user_contact))
      {
        $this->errors['contact']="Please enter the contact number";
      }

        else
      {
            $this->user_contact=$this->test_input($this->user_contact); 

            if (!preg_match("/^[0-9]{10}$/",$this->user_contact)) 
            {
              $this->errors['contact']="Please enter a valid  contact number";
            }

      }

      */



      if(!empty($this->user_contact))
      {
          $this->user_contact=$this->test_input($this->user_contact); 

            if (!preg_match("/^[0-9]{10}$/",$this->user_contact)) 
            {
              $this->errors['contact']="Please enter a valid  contact number";
            }

      }


      //address validation
      /*
      if(empty($this->user_address))
      {
        $this->errors['address']="Please enter the address";
      }

        else
      {
            $this->user_address=$this->test_input($this->user_address); 

      }
      */

      if(!empty($this->user_address))
      {

         $this->user_address=$this->test_input($this->user_address); 
      }
      

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
            
            $stmt = $conn->prepare($this->sql);
            $stmt->execute($this->params);
            
            
            $count = $stmt->rowCount();

            if($count==1)
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
            

            /*
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
                */
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
    }





}//end class User


class Staff extends User
{

  private $gender;
  private $role;
  private $login;
  private $password;

  public function __construct($name=NULL,$email=NULL,$contact=NULL,$address=NULL,$gender=NULL,$role=NULL,$login=NULL,$password=NULL)
  {

    parent::__construct($name,$email,$contact,$address);
    $this->gender=$gender;
    $this->role=$role;
    $this->login=$login;
    $this->password=$password;

  }
  public function validate()
  {

      parent::validate();
      //gender validation
      if(empty($this->gender))
      {
        $this->errors['gender']="Please choose the gender";
      }


      //role validation
      if(empty($this->role))
      {
        $this->errors['role']="Please choose  the role of the user";
      }

       //login validation
      if(empty($this->login))
      {
        $this->errors['login']="Please enter the user name used for login";
      }

       else
      {
            $this->login=$this->test_input($this->login); 

            if (!preg_match("/^[a-zA-Z0-9]{5,10}$/",$this->login)) 
            {
              $this->errors['login']="Please enter a valid login name (Only letters, digits are allowed, between 5-10 characters, no space";
            }

      }
       //password validation
      if(empty($this->password))
      {
        $this->errors['password']="Please enter the password";
      }
     
       else
      {
            $this->password=$this->test_input($this->password); 

            if (!preg_match("/^[a-zA-Z0-9]{5,15}$/",$this->password)) 
            {
              $this->errors['password']="Please enter a valid password (Only letters, digits are allowed, between 5-15 characters, no space";
            }

      }

     if(empty($this->errors))

     {

      
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        $this->password=crypt($this->password, $salt);
        }

      $this->sql="INSERT INTO staff (full_name,email,user_name,password,contact,address,gender,role) VALUES(?,?,?,?,?,?,?,?)";
      
      $this->params=array($this->user_name,$this->user_email,$this->login,$this->password,$this->user_contact,$this->user_address,$this->gender,$this->role);
     }
     return $this->errors;


  }


 

  public function update($s_id)
  {

      parent::validate();
      //gender validation
      if(empty($this->gender))
      {
        $this->errors['gender']="Please choose the gender";
      }
      //role validation
      if(empty($this->role))
      {
        $this->errors['address']="Please choose  the role of the user";
      }

       //login validation
      if(empty($this->login))
      {
        $this->errors['login']="Please enter the user name used for login";
      }
       else
      {
            $this->login=$this->test_input($this->login); 

            if (!preg_match("/^[a-zA-Z0-9]{5,10}$/",$this->login)) 
            {
              $this->errors['login']="Please enter a valid login name (Only letters, digits are allowed, between 5-10 characters, no space";
            }

      }

       //password validation
      if(empty($this->password))
      {
        $this->errors['password']="Please enter the password";
      }

      else
      {
            $this->password=$this->test_input($this->password); 

            if (!preg_match("/^[a-zA-Z0-9]{5,15}$/",$this->password)) 
            {
              $this->errors['password']="Please enter a valid password (Only letters, digits are allowed, between 5-15 characters, no space";
            }

      }



      if(empty($this->errors))

     {

      if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        $this->password=crypt($this->password, $salt);
        }


      $this->sql="UPDATE staff SET full_name=?,email=?,user_name=?,password=?,contact=?,address=?,gender=?,role=? WHERE id=?";
      
      $this->params=array($this->user_name,$this->user_email,$this->login,$this->password,$this->user_contact,$this->user_address,$this->gender,$this->role,$s_id);
     }
     return $this->errors;


  }

  public function delete($s_id)
  {
      $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            
            $stmt = $conn->prepare("DELETE  FROM staff WHERE id=?");

            
            $stmt->bindParam(1,$s_id);

            $stmt->execute();

            $count = $stmt->rowCount();

            if($count==1)
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
      


  }


}//end class staff

class Doctor extends User
{

  private $designation;
  private $hospital;
  

  public function __construct($name=NULL,$email=NULL,$contact=NULL,$address=NULL,$designation=NULL,$hospital=NULL)
  {

    parent::__construct($name,$email,$contact,$address);
    $this->designation=$designation;
    $this->hospital=$hospital;


  }
  public function validate()
  {

      parent::validate();
      //gender validation
      /*
      if(empty($this->designation))
      {
        $this->errors['designation']="Please enter the designation";
      }
       else
      {
            $this->designation=$this->test_input($this->designation); 

      }
      */

      if(!empty($this->designation))
      {
        $this->designation=$this->test_input($this->designation); 
      }

      //role validation
      /*
      if(empty($this->hospital))
      {
        $this->errors['hospital']="Please enter the name of the practising hospital";
      }

        else
      {
            $this->hospital=$this->test_input($this->hospital); 

      }
    */

      if(!empty($this->hospital))
      {

          $this->hospital=$this->test_input($this->hospital);
      }

       
     
     if(empty($this->errors))

     {
      $this->sql="INSERT INTO doctor (full_name,email,contact,address,designation,hospital) VALUES(?,?,?,?,?,?)";
      
      $this->params=array($this->user_name,$this->user_email,$this->user_contact,$this->user_address,$this->designation,$this->hospital);
     }
     return $this->errors;


  }

public function update($d_id)
  {

      parent::validate();
      //gender validation
      if(empty($this->designation))
      {
        $this->errors['designation']="Please enter the designation";
      }
       else
      {
            $this->designation=$this->test_input($this->designation); 

      }
      //role validation
      if(empty($this->hospital))
      {
        $this->errors['hospital']="Please enter the name of the practising hospital";
      }

        else
      {
            $this->hospital=$this->test_input($this->hospital); 

      }

       
     
     if(empty($this->errors))

     {
      $this->sql="UPDATE doctor SET full_name=?,email=?,contact=?,address=?,designation=?,hospital=? WHERE id=?";
      
      $this->params=array($this->user_name,$this->user_email,$this->user_contact,$this->user_address,$this->designation,$this->hospital,$d_id);
     }
     return $this->errors;


  }

  public function delete($d_id)
  {
      $dbconfig=new Dbconfig();

        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            
            $stmt = $conn->prepare("DELETE  FROM doctor WHERE id=?");

            
            $stmt->bindParam(1,$d_id);

            $stmt->execute();
            $stmt=null;
            $conn=null;
            return "success";
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            }
      


  }

}//end class doctor


?>