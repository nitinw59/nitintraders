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
	$GSTN= $_POST['GSTN'];

 	$query_upload=" insert into fabric_merchants_tbl(FNAME,LNAME,COMPANY_NAME,EMAIL,MOBILE,GSTN,ADDRESS,CITY,STATE,ZIP) VALUES('".$Fname."','".$Lname."','".$companyname."','".$email."',".$mobile.",'".$GSTN."','".$address."','".$city."','".$state."','".$zip."');";
	
	
	

	

	$status=mysqli_query($dbhandle,$query_upload) ; 
	
	
	if($status==1){
	$url="MerchantDisplay.php?mobile=".$mobile;
	}else{
	$url="AddMerchantError.php";
	
	}
	
	
	echo "<meta http-equiv='refresh' content='0;url=".$url."'>";
	



?>

