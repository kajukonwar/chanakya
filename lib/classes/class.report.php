
<?php
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

/*
class Staff extends User
{

  private $gender;
  private $role;
  private $login;
  private $password;

  public function __construct($name,$email,$contact,$address,$gender,$role,$login,$password)
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
        $this->errors['address']="Please choose  the role of the user";
      }

       //login validation
      if(empty($this->login))
      {
        $this->errors['login']="Please enter the user name used for login";
      }
       //password validation
      if(empty($this->password))
      {
        $this->errors['password']="Please enter the password";
      }
     
     if(empty($this->errors))

     {
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
       //password validation
      if(empty($this->password))
      {
        $this->errors['password']="Please enter the password";
      }

      if(empty($this->errors))

     {
      $this->sql="UPDATE staff SET full_name=?,email=?,user_name=?,password=?,contact=?,address=?,gender=?,role=? WHERE id=?";
      
      $this->params=array($this->user_name,$this->user_email,$this->login,$this->password,$this->user_contact,$this->user_address,$this->gender,$this->role,$s_id);
     }
     return $this->errors;


  }


}//end class staff

class Doctor extends User
{

  private $designation;
  private $hospital;
  

  public function __construct($name,$email,$contact,$address,$designation,$hospital)
  {

    parent::__construct($name,$email,$contact,$address);
    $this->designation=$designation;
    $this->hospital=$hospital;


  }
  public function validate()
  {

      parent::validate();
      //gender validation
      if(empty($this->designation))
      {
        $this->errors['designation']="Please enter the designation";
      }
      //role validation
      if(empty($this->hospital))
      {
        $this->errors['hospital']="Please enter the name of the practising hospital";
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
      //role validation
      if(empty($this->hospital))
      {
        $this->errors['hospital']="Please enter the name of the practising hospital";
      }

       
     
     if(empty($this->errors))

     {
      $this->sql="UPDATE doctor SET full_name=?,email=?,contact=?,address=?,designation=?,hospital=? WHERE id=?";
      
      $this->params=array($this->user_name,$this->user_email,$this->user_contact,$this->user_address,$this->designation,$this->hospital,$d_id);
     }
     return $this->errors;


  }

}//end class doctor
*/

?>