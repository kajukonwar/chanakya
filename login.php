<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]).'/chanakya';
require_once("$root/include/dbconfig.php");

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Chanakya Diagnostic| Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->


  <link rel="shortcut icon" href="dist/img/favicon (2).ico" type="image/x-icon">
  <link rel="icon" href="dist/img/favicon (2).ico" type="image/x-icon">
  
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="plugins/ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
   <b>Chanakya Diagnostics</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

<?php

$user_nameErr=$user_passwordErr=$user_name=$user_password=$login_status="";
//user login
if($_SERVER["REQUEST_METHOD"]=="POST")
{
  if(isset($_POST["user_login_button"]))

  {

       function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    //user name validation
      if(empty($_POST["user_name"]))
      {
        $user_nameErr="Please enter the user name ";
      }

       else
      {
            $user_name=test_input($_POST["user_name"]); 

            if (!preg_match("/^[a-zA-Z0-9]{5,10}$/",$user_name)) 
            {
              $user_nameErr="Please enter a valid login name (Only letters, digits are allowed, between 5-10 characters, no space";
            }

      }
       //password validation
      if(empty($_POST["user_password"]))
      {
        $user_passwordErr="Please enter the password";
      }
     
       else
      {
            $user_password=test_input($_POST["user_password"]); 

            if (!preg_match("/^[a-zA-Z0-9]{5,15}$/",$user_password)) 
            {
              $user_passwordErr="Please enter a valid password (Only letters, digits are allowed, between 5-15 characters, no space";
            }

      }


      if(empty($user_nameErr)&&empty($user_passwordErr))
      {

        $dbconfig=new Dbconfig();
         


        try {
            $conn = new PDO("mysql:host=$dbconfig->hostname;dbname=$dbconfig->dbname", $dbconfig->username, $dbconfig->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // prepare and bind
            
            $stmt = $conn->prepare("SELECT * FROM staff WHERE user_name=?");
            $stmt->bindParam(1,$user_name);
            
            $stmt->execute();

            $result=$stmt->fetchAll();

            if(empty($result))
            {

              $login_status="Invalid user name";
            }
            else
            {
              if(crypt($user_password, $result[0]['password']) != $result[0]['password'])
               {
                    $login_status="Wrong password";
               }
                
              
              else
              {

                  if($result[0]['role']=="admin")
                  {
                    $_SESSION['login_status']="logedin";
                    $_SESSION['user_id']=$result[0]['id'];
                    $_SESSION['user_role']=$result[0]['role'];

                      header("Location:index.php");
                  }
                  if($result[0]['role']=="reception")
                  {
                    $_SESSION['login_status']="logedin";
                    $_SESSION['user_id']=$result[0]['id'];
                    $_SESSION['user_role']=$result[0]['role'];
                      header("Location:templates/bill/add.php");
                  }

                   if($result[0]['role']=="laboratory")
                  {               
                      $_SESSION['login_status']="logedin";
                      $_SESSION['user_id']=$result[0]['id'];
                      $_SESSION['user_role']=$result[0]['role'];     
                      header("Location:templates/report/report.php");
                  }

               

              }
            }
            

            $stmt=null;
            $conn=null;
            
         
            
            }
        catch(PDOException $e)
            {
            echo "DB Connection failed: " . $e->getMessage();
            } 
      }
    


    
  }

}



?>
  <p style="color:red;"><?php echo $login_status;?></p>

    <form name="user_login_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="user_name" placeholder="User name" value="<?php echo $user_name;?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <p style="color:red;"><?php echo $user_nameErr;?></p>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="user_password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
         <p style="color:red;"><?php echo $user_passwordErr;?></p>
      </div>
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" name="user_login_button" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
