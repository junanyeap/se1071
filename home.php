<?php
require("teammodel.php");
if(!isset($_SESSION["loginId"])){
	header('Location: teamview.php');
}else{
	$userId = $_SESSION["loginId"];
	echo "create a team";
	echo "
		<br>
		team name:
		<form action = 'teamcontrol.php' method='post'>
			<input type='text' name='teamName' value=''>
			<input type='hidden' name='userId' value='$userId'>
			<input type='submit' name='act' value='createTeam'>
		</form>
	";
	echo "join a team by enter teamID";
	echo "
		<form action = 'teamcontrol.php' method='post'>
			<input type='text' name='teamId' value=''>
			<input type='submit' name='act' value='joinTeam'>
		</form>
	";
	list($myTeam,$myTeamId) = showMyControlTeam($userId);
	for ($i=0;$i<count($myTeam);$i++){
	  $chacr = array("fac", "dist", "whole","ret");
		echo "Team : ".$myTeam[$i]."<br>";
		// show this team status
		list($memberId,$memberRole) = teamStatus($myTeamId[$i]);
		for ($j=0;$j<count($memberId);$j++){
			if(in_array($memberRole[$j], $chacr)){
				$chacr = array_diff($chacr, array($memberRole[$j]));
			}
			echo $memberId[$j]."___".$memberRole[$j]."<br>";
		}
		$chacr = array_values($chacr);
		for($j=0;$j<count($chacr);$j++){
			echo "<br>沒玩家".$chacr[$j];
			echo "
				<form action='teamcontrol.php' method='post'>
					<input type='hidden' name='teamId' value='$myTeamId[$i]'>
					<input type='hidden' name='userId' value='$userId'>
					<input type='hidden' name='role' value='$chacr[$j]'>
					<input type='submit' name='act' value='joinTeam'>
				</form>
			";
		}

	}
}
// $roleStatus = checkRole($_SESSION["loginId"]);
// echo $roleStatus;
?>