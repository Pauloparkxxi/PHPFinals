<?php
session_start();
include('conDB.php');
date_default_timezone_set('Asia/Manila');
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location:loginPage.php");
    exit;
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
<style>
</style>
<title>About | Project for Finals</title>
</head>
<body id="backimg" data-spy="scroll" data-offset="60">
<nav class='navbar navbar-inverse'>
  <div class='container-fluid'>
	<?php
		include('includes/navibar.php');
	?>
  </div>
</nav>

<div class="col-sm-4" id='welcome_container'>
<center>
        <h2 id="title_page"><b>About this Project:</b></h2><br><br>
        <h2 id="txtcnt"><b>Project in CS301 - Web Programming and Development</b></h2>
        <h2 id="txtcnt"><b>myPage - Your Social Page | Sign Up and Log in System</b></h2><br><br><br>
		<h3 id="txtcnt"><b>Created by: Paulo A. Bollosa | 3rd Year - 1st Trimester</b></h3><br>
		<h3 id="txtcnt"><b>Submitted to: Sir Christopher Borja | S.Y. 2019 - 2020</b></h3><br>
</center>
</div>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>