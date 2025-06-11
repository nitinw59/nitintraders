<?php
$server_root="/omenweb";


?>
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Pushy - Off-Canvas Navigation Menu</title>
        <meta name="description" content="Pushy is an off-canvas navigation menu for your website.">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <link rel="stylesheet" href="<?=$server_root?>/css/normalize.css">
        <link rel="stylesheet" href="<?=$server_root?>/css/demo.css">
        <!-- Pushy CSS -->
        <link rel="stylesheet" href="<?=$server_root?>/css/pushy.css">
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    </head>


<?php

include($_SERVER['DOCUMENT_ROOT']."$server_root/index.php");
include($_SERVER['DOCUMENT_ROOT']."/omenweb/var.php");
		

$filename=date('d-m-Y', time());
$filename="Backup-".$filename;


if(file_exists($filename)){
	unlink($filename);
}


$handle = fopen($filename,'w') or die('Cannot open file:  '.$filename);









include($_SERVER['DOCUMENT_ROOT']."/$server_root/mysqlconnectdb.php");

$tables = count($db_tables);
echo $tables;
for($i=0;$i<$tables;$i++){
	
$sql = "SELECT  *  FROM $db_tables[$i]";
$data= "\n$db_tables[$i]= array (\n";
if($result = mysqli_query($dbhandle,$sql) ){
	while($row = mysqli_fetch_array($result)){
		
		
		$data=$data."array(";
		for($k=0;$k<mysqli_num_fields($result)-1;$k++)
			$data=$data."'".$row[$k]."',";
		$data=$data."'".$row[$k]."'),\n";
		
		
	}
	$data=$data.");";
	fwrite($handle,$data);	
}  


}



$message = "Backup created successfully,".$_SERVER['DOCUMENT_ROOT']."/omenweb/backup/".$filename;
echo "<script type='text/javascript'>alert('$message');</script>";



?>



<body>
<!-- Pushy JS -->
        <script src="<?=$server_root?>/js/pushy.min.js"></script>

</body>