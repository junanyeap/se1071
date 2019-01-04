<?php
echo '
		<form action="teamcontrol.php" method="post">
			userName:
			<input type="text" name="userName" placeholder="LoginID" required /><br>
			Password:
			<input type="password" name="pwd" placeholder="Password" required /><br>
			Re-type Password:
			<input type="password" name="pwd2" placeholder="Re-type your Password" required /><br>
			<input name="act" type="submit" value="signUp" />
		</form>
	';
?>