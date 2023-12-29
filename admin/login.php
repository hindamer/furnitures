<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Furniture Admin | Login/Register</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
  <?php
		include("oop.php");
		$db=new DB();
		$db->_get();;

		if(isset($_POST['submit'])){
			$error=[];
			if(isset($_POST['fullname']) && empty($_POST['fullname'])){
				$error['ferror']="enter your fullname";
			}
			else{
				$fullname=$_POST['fullname'];
			}
			if(isset($_POST['username']) && empty($_POST['username'])){
				$error['uerror']="enter your username";
			}
			else{
				$uname=$_POST['username'];
			}
      if(isset($_POST['active'])){
        $active=$_POST['active'];
      }
      else{
        $active=0;
      }
		$email=$_POST['email'];
		$password=$_POST['password'];
		$upp=preg_match('@[A-Z]@',$password);
		$low=preg_match('@[a-z]@',$password);
		$num=preg_match('@[0-9]@',$password);
		$char=preg_match('@[^\w]@',$password);
		if(isset($_POST['email']) && empty($_POST['email'])){
			$error['emailer']='enter your email';
		}
		else{
			if(!filter_var($email,FILTER_VALIDATE_EMAIL))
			{
				$error['email']="enter validate email";
			}
			elseif(isset($_POST['password']) && empty($_POST['password'])){
				$error['passerror']="enter your pass";
			}
			else if (!$upp || !$low || !$num || !$char || strlen($password) < 8){
				$error['pass']="enter valid pass";
			}
			else{
				if(count($error)<=0){
					$db->insert("users","fullname,username,email,password,active","'$fullname','$uname','$email','$password','$active'",);
					session_start();
					$_SESSION['fullname']="$fullname";
					header("location:users.php");
				}
			}
		}
	
		}
    if(isset($_POST['send'])){
			$error=[];
			$uname=$_POST['username'];
			$password=$_POST['password'];
			$data=$db->select("*","users","username='$uname'");
        $row=$data->fetch(PDO::FETCH_ASSOC);
        if($row){
          if($row['password'] == $password){
            session_start();
            $_SESSION['fullname']=$row['fullname'];
            header("location:users.php");
        
          }
          else{
            $error['pass']="password not found";
          }
        }
        else{
          $error['username']="username not found";
        }
      }
			
		?>
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
              <h1>Login Form</h1>
              <div>
                <input type="hidden" name="fullname" value="<?php echo $row['fullname']?>">
                <input type="text" class="form-control" name="username" placeholder="Username" />
                <p style="color: red;"><?php if(isset($error['username'])){echo $error['username'];}?></p>

              </div>
                  <div>
                <input type="password" class="form-control" name="password" placeholder="Password"/>
                <p style="color: red;"><?php if(isset($error['pass'])){echo $error['pass'];}?></p>

              </div>
              <div>
                <input type="submit" name="send" value="login">
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-graduation-cap"></i></i> Furniture Admin</h1>
                  <p>©2016 All Rights Reserved. Furniture Admin is a Bootstrap 4 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" name="fullname" placeholder="Fullname"/>
                <p style="color: red;"><?php if(isset($error['ferror'])){echo $error['ferror'];}?></p>

              </div>
              <div>
                <input type="text" class="form-control" name="username" placeholder="Username"/>
                <p style="color: red;"><?php if(isset($error['uerror'])){echo $error['uerror'];}?></p>
              </div>
              <div>
                <input type="text" class="form-control" name="email" placeholder="Email"  />
                <p style="color: red;"><?php if(isset($error['emailer'])){echo $error['emailer'];}?></p>
                <p style="color: red;"><?php if(isset($error['email'])){echo $error['email'];}?></p>

              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" />
                <p style="color: red;"><?php if(isset($error['passerror'])){echo $error['passerror'];}?></p>
                <p style="color: red;"><?php if(isset($error['pass'])){echo $error['pass'];}?></p>

              </div>
              <div>
              </div>
               <input type="submit" name="submit" value="submit">
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-graduation-cap"></i></i> Furniture Admin</h1>
                  <p>©2016 All Rights Reserved. Furniture Admin is a Bootstrap 4 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
