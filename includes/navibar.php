<?php
include('conDB.php');
if(!isset($_SESSION['loggedin']))
{
	echo "
	<div class='navbar-header'>
	  <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>
		<span class='icon-bar'></span>
		<span class='icon-bar'></span>
		<span class='icon-bar'></span>                        
	  </button>
	  <a class='navbar-brand' href='loginPage.php'><b>myPage - Your Social Page</b></a>
	</div>
	<div class='collapse navbar-collapse' id='myNavbar'>
	  <ul class='nav navbar-nav navbar-right'>
		<li><a href='facts2.php'>Facts</a></li>
		<li><a href='about2.php'>About</a></li>
	  </ul>
	</div>";
}
else
{
	echo "
	<div class='navbar-header'>
	  <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>
		<span class='icon-bar'></span>
		<span class='icon-bar'></span>
		<span class='icon-bar'></span>                        
	  </button>
	  <a class='navbar-brand' href='myPage.php'><b>myPage - Your Social Page<b/></a>
	</div>
	<div class='collapse navbar-collapse' id='myNavbar'>
	  <ul class='nav navbar-nav navbar-right'>
		<li id='active'><a href='myPage.php'>Home</a></li>
		<li id='active'><a href='logout.php'>Log Out</a></li>
		<li><a href='facts.php'>Facts</a></li>
		<li><a href='about.php'>About</a></li>
	  </ul>
	</div>";
}
?>