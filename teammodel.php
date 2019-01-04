<?php
if(!isset($_SESSION)) 
{ 
  session_start(); 
} 
function checkUserNameExists($userName){
	$db = mysqli_connect("localhost", "root", "", "beer");
	$sql = "select * from `user` where userName = '$userName'";
	$result = mysqli_query($db,$sql);
	$rows = mysqli_num_rows($result);
	if($rows>0){
		return true;
	}else{
		return false;
	}
}
function createTeam($userId,$teamName){
	$checkIfAvailable = "select * from `team` where teamName='$teamName'";
	$result = getDb($checkIfAvailable);
	$rows = mysqli_num_rows($result);
	if($rows>0){
		// got exists
	}else{
		$year = date("Y");
		$month = date("m");
		$date = date("d");
		$tmp = $teamName.$year.$month.$date;
		$teamId = $tmp;
		$sql = "insert into `team` (teamId,teamName,ownerId)VALUES('$teamId','$teamName','$userId')";
		$sql2 = "insert into `userinteam` (userId,teamId,prio)VALUES('$userId','$teamId',1)";
		getDb($sql);
		getDb($sql2);
	}

}
function getDb($sql)
{
	$db = mysqli_connect("localhost", "root", "", "beer");
  mysqli_set_charset($db,"utf8");
  $result = mysqli_query($db,$sql);
  return $result;
}
function loginM($userName,$pwd){
	// verify loginid and password to db
	// after verify, if yes, set up the $_SESSSION["loginId"]
	$status;
	$db = mysqli_connect("localhost", "root", "", "beer");
	$hashpwd = hash('sha512',$pwd);
	// echo $hashpwd;
	$sql = "select * from `user` where username = '$userName' and pwd='$hashpwd'";
	echo $sql;
	$result = mysqli_query($db,$sql);
	var_dump($result);
	$rows = mysqli_num_rows($result);
  if($rows>0 && $rows<2){
  	$row = $result->fetch_array(MYSQLI_ASSOC);
  	$_SESSION["loginId"]=$row["userid"];
  	$status=0;
  }else{
  	$status=1;
  }
  return $status;
}
function logout(){
	session_destroy();
}
function checkRole($loginId){
	// let set the variable "session["loginId"]" content is role
	// if session["loginid"] not set, mean user not select role yet
	// return status
	$sql = "select * from `userinteam` where userId='$loginId'";
	$result = getDb($sql);
	var_dump($result);
}
function selectRole($loginId){

}
function signUp($userName,$pwd,$rpwd){
	$db = mysqli_connect("localhost", "root", "", "beer");
	$status;
	// 0 ok 1 username exists 2 pwd not same
	// 3 username exists and pwd not same
	if(checkUserNameExists($userName)==false){
		$status = 0;
		if($pwd!=$rpwd){
			$status = 2;
		}
	}else{
		if($pwd!=$rpwd){
			$status = 3;
		}else{
			$status = 1;	
		}
	}
	// return $status;
	if($status == 0){
		$year = date("Y");
		$month = date("m");
		$date = date("d");
		$hashpwd = hash('sha512', $pwd);
		$tmp = $userName.$year.$month.$date;
		$userid = $tmp;
		echo $userid;
		$sql = "insert into `user` (username,userid,pwd)VALUES('$userName','$userid','$hashpwd')";
		$result = mysqli_query($db,$sql);
		echo "ok";
	}
	if($status == 1){
		echo "username exists";
	}
	if($status == 2){
		echo "pwd not same";
	}
	if($status == 3){
		echo "username + pwd got problem";
	}
}
function showMyControlTeam($userId){
	$sql = "select * from `team` where ownerId='$userId'";
	$result=getDb($sql);
	$teamNameArray = array();
	$teamIdArray = array();
	while($row=mysqli_fetch_assoc($result))
	{
	  array_push($teamNameArray, $row["teamName"]);
	  array_push($teamIdArray, $row["teamId"]);
	}
	return array(
        $teamNameArray,
        $teamIdArray
      );
}
function joinTeam($teamId,$userId,$role){
	// $checkIfAvailable = "select * from `userinteam` where teamId='$teamId'";
	$db = mysqli_connect("localhost", "root", "", "beer");
	$sql = "insert into `userinteam` (userId,teamId,role,prio)VALUES('$userId','$teamId','$role',0)";
	$result = mysqli_query($db,$sql);
	return 0;
}
function teamStatus($teamId){
	$sql = "select * from `userinteam` where teamId='$teamId' and prio=0";
	$teamMemberIdArray = array();
	$teamMemberRoleArray = array();
	// $teamIdArray = array();
	$result = getDb($sql);
	while($row=mysqli_fetch_assoc($result))
	{
		array_push($teamMemberIdArray, $row["userId"]);
		// array_push($teamIdArray, $row["teamId"]);
		array_push($teamMemberRoleArray, $row["role"]);
		// $row["userId"];
		// $row["teamId"];
		// $row["role"];
	  // array_push($teamNameArray, $row["teamName"]);
	}
	return array(
		$teamMemberIdArray,
		// $teamIdArray,
		$teamMemberRoleArray
	);
}
?>