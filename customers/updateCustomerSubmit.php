 
<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");

    $Fname=$_POST['Fname'];
	$Lname=$_POST['Lname'];
	$companyname=$_POST['companyname'];
	$oldcompanyname=$_POST['oldcompanyname'];
	$address=$_POST['address'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$zip=$_POST['zip'];
	$mobile=$_POST['mobile'];
	$email=$_POST['email'];
    $gsttreatment=$_POST['GSTTREATMENT'];
    $gstn=$_POST['GSTNT'];
 	$query_upload=" update customers_tbl set 
						FNAME='$Fname',
						LNAME='$Lname',
						COMPANY_NAME='$companyname',
						EMAIL='$email',
						MOBILE='$mobile',
						ADDRESS='$address',
						CITY='$city',
						STATE='$state',
						ZIP='$zip',
                        GSTTREATMENT='$gsttreatment',
                        GSTN='$gstn' 
						where COMPANY_NAME='$oldcompanyname' ;";
	
	
	

	$status=mysqli_query($dbhandle,$query_upload) ; 
	
	$query_upload;
	

	if($status==1){
	$url="customerDisplay.php?mobile=".$mobile;
	
	}else{
	$url="customerAddError.php";
	
	
	}
	
	
	echo "<meta http-equiv='refresh' content='0;url=".$url."'>";
	



?>

