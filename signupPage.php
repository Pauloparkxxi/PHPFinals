<?php 
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: loginPage.php");
    exit;
}
include('conDB.php');
date_default_timezone_set('Asia/Manila');
$error = "";
if(isset($_POST['btn_register'])) 
{
	$fnameq = $_POST['firstname'];
	$lnameq = $_POST['lastname'];
	$usernameq = $_POST['username'];
	$emailq = $_POST['email'];
	$numberq = $_POST['mnumber'];
	$birthdateq = $_POST['birthdate'];
	
	//CHECK IF ALL FIELDS ARE FILLED UP BY USER
	if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['username']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && !empty($_POST['email']) && !empty($_POST['birthdate']) && !empty($_POST['mnumber'])) 
	{
		//CHECK IF SPECIAL CHARACTERS THAT MIGHT BE USED FOR INJECTION HAVE BEEN FILLED UP BY USER 
		if(!preg_match('/[\'^£$&}{~<#%>;|=]/', $_POST['firstname']) AND !preg_match('/[\'^£$&}{~<#%>;|=]/', $_POST['lastname']) AND !preg_match('/[\'^£$&}{~<#%>;|=]/', $_POST['username']) AND !preg_match('/[\'^£$&}{~<#%>;|=]/', $_POST['email']) AND !preg_match('/[\'^£$&}{~<#%>;|=]abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/', $_POST['mnumber'])) 
		{
			//CHECK IF SPECIAL CHARACTERS FOR PASSWORD THAT MIGHT BE USED FOR INJECTION HAVE BEEN FILLED UP BY USER 
			if(!preg_match('/[\'^£$&}{~<>;=]/', $_POST['pass1']) AND !preg_match('/[\'^£$&}{~<>;|=]/', $_POST['pass2']))
			{
				//CLEAN THE DATA THAT IS INPUTTED BY THE USER
				$firstnamex = mysqli_real_escape_string($conndb, $_POST['firstname']);
				$lastnamex = mysqli_real_escape_string($conndb, $_POST['lastname']);
				$usernamex = mysqli_real_escape_string($conndb, $_POST['username']);
				$pass1x = mysqli_real_escape_string($conndb, $_POST['pass1']);
				$pass2x = mysqli_real_escape_string($conndb, $_POST['pass2']);
				$emailx = mysqli_real_escape_string($conndb, $_POST['email']);
				
				$firstname = htmlspecialchars($firstnamex);
				$lastname = htmlspecialchars($lastnamex);
				$username = htmlspecialchars($usernamex);
				$pass1 = htmlspecialchars($pass1x);
				$pass2 = htmlspecialchars($pass2x);
				$email = htmlspecialchars($emailx);
				$mobnumber = $_POST['mnumber'];
				$birthdate = $_POST['birthdate'];
				
				//CHECK IF THE THE MOBILE NUMBER THAT HAD BEEN INPUT BY THE USER MUST BE 11 DIGITS
				if((strlen($mobnumber) >= 11) AND (strlen($mobnumber) <= 11))
				{
				//CHECK IF THE USER IS INPUTING INVALID EMAIL FORMAT
			    if(filter_var($emailq, FILTER_VALIDATE_EMAIL))
				{
				//CHECK IF THE PASSWORD CHARACTER INPUTTED BY THE USER IS 8 AND ABOVE
				  if(strlen($pass1) >= 8)
				  {
					 //CHECK IF THE USER IS INPUTTING MATCH CONFIRMING PASSWORD
					if($pass1 == $pass2)
					{
							
						//CHECK IF THE USERNAME INPUTTED BY THE USER IS ALREADY REGISTERED
						$checkusername = mysqli_query($conndb, "SELECT username FROM userdata WHERE username = '$username'");
						$num_of_rows = mysqli_num_rows($checkusername);
						
						if($num_of_rows < 1)
						{
							
							//COMPUTE THE AGE OF THE USER USING THE BIRTHDATE VARIABLE ($birthdate)
							$birthDate = $birthdateq;
							  //explode the date to get month, day and year
							  $birthDate = explode("-", $birthDate);
							  //get age from date or birthdate
							  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
								? ((date("Y") - $birthDate[0]) - 1)
								: (date("Y") - $birthDate[0]));
						//TO TELL USER THAT USER MUST REGISTER IF THE USER IS 18 YEARS OLD AND ABOVE		
						if($age >= 18){
							//GENERATE A UNIQUE MEMBER ID
							$x = date('y');
							function generateRandomString($length = 8) 
							{
								$characters = '1234567890';
								$charactersLength = strlen($characters);
								$randomString = '';
								for ($i = 0; $i < $length; $i++) 
								{
									$randomString .= $characters[rand(0, $charactersLength - 1)];
								}
								return $randomString;	
							}
							
							ulit:
							$member_idx = generateRandomString();
							$checkmemberid = mysqli_query($conndb, "SELECT member_id FROM userdata WHERE member_id = '$member_idx'");
							$countmemberid = mysqli_num_rows($checkmemberid);
							
							if($countmemberid<1)
							{
								$member_id = $x.$member_idx;
							}
							else
							{
								goto ulit;
							}
							
							//GENERATE A TOKEN ID
							function generateToken($length = 60) 
							{
								$characters = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
								$charactersLength = strlen($characters);
								$randomString = '';
								for ($i = 0; $i < $length; $i++) 
								{
									$randomString .= $characters[rand(0, $charactersLength - 1)];
								}
								return $randomString;	
							}
							
							token_ulit:
							$token_idx = generateToken();
							$checktoken = mysqli_query($conndb, "SELECT token_id FROM userdata WHERE token_id = '$token_idx'");
							$counttoken = mysqli_num_rows($checktoken);
							
							if($counttoken<1)
							{
								$token_id = $token_idx;
							}
							else
							{
								goto token_ulit;
							}
										
							
							//GET THE DATE TODAY - Date format will depend on database default format
							$date_registered=date('y/m/d');
							
							//ENSURE THAT THE PASSWORD WILL BE ENCRYPTED OR HASHED
							$hasspass = password_hash($pass1, PASSWORD_BCRYPT, array('cost'=>12));
							
							/*
							We have different ways to insert a record in SQL
							1. Mysql
							2. Mysqli
							3. Prepared Statements(we're going to use this!)
							4. PDO
							*/
							
							//PREPARE TO INSERT THE RECORD
							$ready = $conndb->prepare("INSERT INTO `userdata`(`user_id`, `member_id`, `first_name`, `last_name`,`username`, `email`, `mobile_number`, `birthdate`, `age`, `password`, `date_registered`, `token_id`, `verified`) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
							
							//BIND PARAMETERS
							$ready->bind_param("issssssisss", $member_id, $firstname, $lastname, $username, $email, $mobnumber, $birthdate, $age, $hasspass, $date_registered, $token_id);
							//CHECK IF THERE'S ERROR IN SAVING THE RECORD
							if($ready->errno)
							{
								$error = "Sorry, but your record has not been added to our database. Please try again.";
							}
							else
							{									
								//IF RECORD HAS BEEN ADDED TO THE DATABASE, SEND AN EMAIL TO VERIFY THE USER'S ACCOUNT
								/*$to = $email;
								$subject = 'Verify your account with PAB Supermarket';
								$headers = 'From: noreply@Pabsupermarket.com';	
								$message = 'Hello '.$username.'! '."\n\n" .'Thank you for registering an account with PAB Supermarket.'."\n\n".'To complete your registration, please click on the link below:'."\n\n".'https://mymusky.com?token='.$token_id.'&user='.$username.'';
								mail($to, $subject, $message, $headers);*/
								
								$ready->execute();															
								$ready->close();
								$conndb->close();								
                                $_SESSION['msg'] = "Your account registration is successful. You may now check your email to verify your account, then log in here.";; 
								header(('Location: loginPage.php'));
								exit;
							
							}
							
						}
						else{
							$error = "You must be 18 and above to register an account.";
						}
						}
						else
						{
							$error = "Username already taken. Please try again.";
						}
						
					}
					else
					{
						$error = "Password did not match. Please try again.";
					}
				}
				else
				{
					$error = "Password length must be at least 8 characters";
				}
				}
				else
				{
					$error = "Invalid email format!";
				}
				}
			else
			{
	          	$error = "Mobile mumber must be 11 digits";	
			}	
			}
			else
			{
				$error = "Some characters in password not allowed. Please try again.";
			}
		}
		else 
		{
			$error = "Some characters are not allowed. Please try again.";
		}
	}
	else 
	{
		$error = "All fields are required.";
	}
}
if(isset($_POST['btnlog']))
{
   header(("Location: loginPage.php"));
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="CSSPage/cssLayout.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style>
</style>
<title>Sign Up | Project for Finals</title>
</head>
<body id="backimg" data-spy="scroll" data-offset="60">
<nav class='navbar navbar-inverse'>
  <div class='container-fluid'>
	<?php
		include('includes/navibar.php');
	?>
  </div>
</nav>
		<div class="d-flex justify-content-center" id='signup_container'>
        <?php 
			if(!isset($_POST['btn_register'])) {
				echo "
                <center><span id='title_head'><h3><b>Register your Account</b></h3></span></center><br>
				<form action='signupPage.php' method='POST' class='needs-validation' novalidate>
				
					<div class='form-group'>
						<label for='Fname' id='label'>First Name</label>
						<input type='text' name='firstname' id='txt' class='form-control' autocomplete='off' />
					</div>
					
					<div class='form-group'>
						<label for='Lrname' id='label'>Last Name</label>
						<input type='text' name='lastname' id='txt' class='form-control' autocomplete='off' />
					</div>
					
					<div class='form-group'>
						<label for='username' id='label'>Username<i id='notice'> (This cannot be change after registration)</i></label>
						<input type='text' name='username' id='txt' class='form-control' autocomplete='off' />
					</div>	
					
					<div class='form-group'>
						<label for='email' id='label'>Email Address</label>
						<input type='email' name='email' id='txt' class='form-control' />
					</div>
					
					<div class='form-group'>
						<label for='number' id='label'>Mobile Number</label>
						<input name='mnumber' type='number' min='0' max='15' size='1' id='txt' class='form-control' />
					</div>
					
					<div class='form-group'>
						<label for='pass1' id='label'>Password</label>
						<input type='password' name='pass1' id='txt' class='form-control' autocomplete='new-password' />
					</div>

					<div class='form-group'>
						<label for='pass2' id='label'>Confirm Password</label>
						<input type='password' name='pass2' id='txt' class='form-control' />
					</div>
					
					<div class='form-group'>
						<label for='birthdate' id='label'>Date of Birth <i id='notice'>(This cannot be change after registration)</i></label>
						<input type='date' name='birthdate' id='txt' class='form-control' />
					</div>
					
					<center>
					<input type='submit' name='btn_register' value='REGISTER' id='register_btn'>
					<br><b>Already have an account?</b><br>
                    <input type='submit' name='btnlog' value='LOG IN' id='log_btn'><br><br></center>					
					</form>			
					";
			}

			else 
			{
				echo "
				<center><span id='title_head'><h3><b>Register your Account</b><h3></span></center>
				<center><span id='error'><b>".$error."</b></span><center><br>
				<form action='signupPage.php' method='POST' class='needs-validation' novalidate>
				    
					<div class='form-group'>
					    <label for='Fname' id='label'>First Name</label>
						<input type='text' name='firstname' id='txt' class='form-control' value='".$fnameq." '/>
					</div>
					
					<div class='form-group'>
						<label for='Lrname' id='label'>Last Name</label>
						<input type='text' name='lastname' id='txt' class='form-control' value='".$lnameq." '/>
					</div>
					
					<div class='form-group'>
						<label for='username' id='label'>Username<i id='notice'> (This cannot be change after registration)</i></label>
						<input type='text' name='username' id='txt' class='form-control' value='".$usernameq."'>
					</div>	
					
					<div class='form-group'>
						<label for='email' id='label'>Email Address</label>
						<input type='email' name='email' id='txt' class='form-control' value='".$emailq."' />
					</div>
					
					<div class='form-group'>
						<label for='number' id='label'>Mobile Number</label>
						<input name='mnumber' type='number' min='0' max='15' size='1' id='txt' class='form-control' value='".$numberq."' />
					</div>
					
					<div class='form-group'>
						<label for='pass1' id='label'>Password</label>
						<input type='password' name='pass1' id='txt' class='form-control' autocomplete='new-password' />
					</div>

					<div class='form-group'>
						<label for='pass2' id='label'>Confirm Password</label>
						<input type='password' name='pass2' id='txt' class='form-control' />
					</div>
					
					<div class='form-group'>
						<label for='birthdate' id='label'>Date of Birth <i id='notice'>(This cannot be change after registration)</i></label>
						<input type='date' name='birthdate' id='txt' class='form-control' value='".$birthdateq."' />
					</div>
					
					<center>
					<input type='submit' name='btn_register' value='REGISTER' id='register_btn'>
					<br><b>Already have an account?</b><br>
                    <input type='submit' name='btnlog' value='LOG IN' id='log_btn'><br><br></center>
					</form>			
					";
						
		}
			?>
		</div>
		
		
		<div class="col-sm-4">
		</div>
	</div>
</div>

<br><br>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>