<?php
if(!isset($_SESSION)) 
{ 
  session_start(); 
} 
require("teammodel.php");
$db = mysqli_connect("localhost", "root", "", "beer");
$action = $_REQUEST['act'];
switch ($action) {
	case 'login':
		// $_REQUEST['loginId'],$_REQUEST['pwd'];
		$loginId = stripslashes($_REQUEST['loginId']); 
		$loginId = mysqli_real_escape_string($db,$loginId);
		$pwd = stripslashes($_REQUEST['pwd']);
		$pwd = mysqli_real_escape_string($db,$pwd);
		$status = loginM($loginId,$pwd);
		if($status == 1){
			echo "Login Failed, click to try again";	
			echo "<a href='teamview.php'>LOGIN AGAIN</a>";
		}else{
			header('Location: teamview.php');
		}
		break;
	
	case 'logout':
		logout();
		header('Location: teamview.php');
		break;
	
	case 'signUp':
		// $db = mysqli_connect("localhost", "root", "", "beer");
		$userName = stripslashes($_REQUEST['userName']); 
		$userName = mysqli_real_escape_string($db,$userName);

		$pwd = stripslashes($_REQUEST['pwd']);
		$pwd = mysqli_real_escape_string($db,$pwd);
		
		$pwd2 = stripslashes($_REQUEST['pwd2']);
		$pwd2 = mysqli_real_escape_string($db,$pwd2);
		
		$status = signUp($_REQUEST['userName'],$_REQUEST['pwd'],$_REQUEST['pwd2']);
		break;	
	
	case 'joinTeam':
		$userId = stripslashes($_REQUEST['userId']); 
		$userId = mysqli_real_escape_string($db,$userId);
		$teamId = stripslashes($_REQUEST['teamId']); 
		$teamId = mysqli_real_escape_string($db,$teamId);
		$role = stripslashes($_REQUEST['role']); 
		$role = mysqli_real_escape_string($db,$role);
		
		$status = joinTeam($teamId,$userId,$role);
		if($status!=0){
			echo "join Error";
		}
		break;

	case 'createTeam':
		$userId = stripslashes($_REQUEST['userId']); 
		$userId = mysqli_real_escape_string($db,$userId);
		$teamName = stripslashes($_REQUEST['teamName']); 
		$teamName = mysqli_real_escape_string($db,$teamName);
		// echo $teamName;
		createTeam($userId,$teamName);
		break;

	case 'showMyControlTeam':
		showMyControlTeam($_REQUEST['userId']);
		break;

	default:
  	break;
}
?>