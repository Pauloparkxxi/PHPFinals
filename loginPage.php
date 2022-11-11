<?php
include("conDB.php");
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: myPage.php");
    exit;
}
$error = "";
if(isset($_POST['btnlog']))
{
	if(!empty($_POST['username']) AND !empty($_POST['pass']))
    {
      
        $sql = "SELECT user_id, username, password FROM userdata WHERE username = ?";
        $username = $password = "";
		$username = trim($_POST["username"]);
		$password = trim($_POST["pass"]);
        if($stmt = mysqli_prepare($conndb, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: myPage.php");
                        } else{
                            // Display an error message if password is not valid
                            $error = "The password you entered was not valid.";
                        }
                    }
                } 
				else
				{
                    // Display an error message if username doesn't exist
                    $error = "No account found with that username.";
                }
            } 
			else
			{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
		// Close connection
        mysqli_close($conndb);
    }
	else
	{
	    $error = "You must put your username and password!";
	}
}
if(isset($_POST['btnreg']))
{
   header(("Location: signupPage.php"));
   exit();
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="CSSPage/cssLayout.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style type="text/css">

</style>
<title>Log in | Project for Finals</title>
</head>
<body id="backimg" data-spy="scroll" data-offset="60">
<nav class='navbar navbar-inverse'>
  <div class='container-fluid'>
	<?php
		include('includes/navibar.php');
	?>
  </div>
</nav>
<div class="col-sm-4" id='login_container'>
<center>        
<form action="loginPage.php" method="POST">
<h3 id="title_head"><b>Log in your Account</b></h3><br>
<span id="error"><b><?php
  if (isset($_SESSION['msg'])) {
  echo $_SESSION['msg'];
  unset($_SESSION['msg']);
   }
   echo $error;
?>
</b></span><br><br>
       <input type="text" name="username" placeholder="Username"><br><br>
       <input type="password" name="pass" placeholder="Password"><br><br>
       <input type="submit" name="btnlog" value="LOG IN" id="log_btn"><br>
       <br><b>Still don't have an account?</b><br>
       <input type="submit" name="btnreg" value="SIGN UP" id="sign_btn"><br><br>
</form>
</center>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


</body>
</html>