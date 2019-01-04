<?php
if(!isset($_SESSION)) 
{ 
  session_start(); 
}
if(isset($_SESSION["loginId"])){
	echo "LOGIN DONE<br>";
	echo '
		<form action="teamcontrol.php" method="post">
			<input name="act" type="submit" value="logout" />
		</form>
	';
	echo "You are : ".$_SESSION["loginId"]."<br>";
	echo '
		<iframe src="home.php" width="800" height="600">
		</iframe>
	';
}else{
	echo "LOGIN FIRST";
	echo '
		<form action="teamcontrol.php" method="post">
			<input type="text" name="loginId" placeholder="LoginID" required />
			<input type="password" name="pwd" placeholder="Password" required /><br>
			<input name="act" type="submit" value="login" />
		</form>
		<p>Not registered yet? <a href="reg.php">Register Here</a></p>
	';
}
?>