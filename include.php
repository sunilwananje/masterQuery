<?php
error_reporting(0);
//echo phpinfo();
//ini_set('display_errors',1);*/
require_once 'config/db.php';
date_default_timezone_set("Asia/Calcutta");
function filterInput($var,$connection){
  $htmlentity = htmlentities(trim($var));
	return mysqli_real_escape_string($connection,$htmlentity);
}

function insertQuery($table,$dataArray,$connection){
   $keys = array_keys($dataArray);
   $colmuns = implode(",",$keys);
   $values =array_values($dataArray);
   $valueData = implode("','",$values);
	$query = "INSERT INTO $table ($colmuns) VALUES ('$valueData')";
	$result = mysqli_query($connection,$query);
	//echo $query;
	if($result){
		$id = mysqli_insert_id($connection);
		return $id;
	}
	return false;
}

function updateQuery($table,$dataArray,$connection,$pk,$id){
	$query = "UPDATE $table SET ";
	foreach($dataArray as $key=>$value){
		$query.= $key."='".$value."',";
	}
	$query=substr($query,0,-1);
	$query .= " WHERE $pk = '$id'";
	$result = mysqli_query($connection,$query);
	//echo $query;
	if($result){
		return $result;
	}
	return false;
}
function selectAll($connection,$table,$sortColumn='id',$order='DESC'){
	$query = "SELECT * FROM $table ORDER BY $sortColumn $order";
	$result = mysqli_query($connection,$query);
	
	while($row = mysqli_fetch_assoc($result)){
		$dataArray[]=$row;
	}
	return $dataArray;
}
function select($connection,$table,$columnName,$columnValue){
	$query = "SELECT * FROM $table WHERE $columnName = '$columnValue'";
	$result = mysqli_query($connection,$query);
	$row = mysqli_fetch_assoc($result);
	return $row;
}

function redirect($path){
	header('location:'.$path);
}

$data = array('name'=>'sunil','email'=>'sunil@gmail.com','mobile_no'=>'949944949');
echo updateQuery('bookings',$data,$connection,'');
?>