<?php
session_start();
include('conDB.php');
date_default_timezone_set('Asia/Manila');
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
<title>Facts | Project for Finals</title>
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
<center><h2 id="title_page"><b>Facts</b></h2><br><br>
        <h2 id="txtcnt"><b>The creator of this webpage as a student of CS301 - Web Programming and Development</b></h2>
		<h2 id="txtcnt"><b>has been tasked to create a Sign Up and Log in system using the knowledge he got</b></h2>
		<h2 id="txtcnt"><b>from the class he had attended. He used PHP, SQL query and database, CSS, and HTML.</b></h2>
		<h2 id="txtcnt"><b>He also used XAMPP program in order for him to create and run php file and execute</b></h2>
		<h2 id="txtcnt"><b>a working webpage. This is part of his project and requirement for his subject,</b></h2>
		<h2 id="txtcnt"><b>the CS301 - Web Programming and Development.</b></h2>
</center>
</div>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>