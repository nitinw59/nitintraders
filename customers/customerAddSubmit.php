 <?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	
	


	
	

	$Fname=$_POST['Fname'];
	$Lname=$_POST['Lname'];
	$companyname=$_POST['companyname'];
	$address=$_POST['address'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$zip=$_POST['zip'];
	$mobile=$_POST['mobile'];
	$email=$_POST['email'];
	$GSTTREATMENT= $_POST['GSTTREATMENT'];
	$GSTN= $_POST['GSTN'];

 	$query_upload=" insert into customers_tbl(FNAME,LNAME,COMPANY_NAME,EMAIL,MOBILE,GSTTREATMENT,GSTN,ADDRESS,CITY,STATE,ZIP) VALUES('".$Fname."','".$Lname."','".$companyname."','".$email."',".$mobile.", '".$GSTTREATMENT."','".$GSTN."','".$address."','".$city."','".$state."','".$zip."');";
	echo $query_upload;
	
	
	

	

	$status=mysqli_query($dbhandle,$query_upload) ; 
	
	
	if($status==1){
	$url="customerDisplay.php?mobile=".$mobile;
	}else{
	$url="customerAddError.php";
	
	}
	
	
	echo "<meta http-equiv='refresh' content='0;url=".$url."'>";
	



?>

