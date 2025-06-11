<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	
  $action=$_POST["action"];
  if($action=="addBill"){
	  
	$status=0;
		
	
		if(isset($_FILES['img_file']['name'])){
		$filename=$_FILES['img_file']['name'];
		//$filename = strtotime("now").".jpg";
		//$location = "mbills/".$filename;
		$uploadOk = 1;
		$imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
		$valid_extensions = array("jpg","jpeg","png");
		
		if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
			$uploadOk = 0;
		}

				if($uploadOk == 0){
					$status=0;
				}else{
					$location=strtotime("now").".".$imageFileType;
					if(move_uploaded_file($_FILES['img_file']['tmp_name'],"scn/".$location)){
						$merchant_name=$_POST['merchant_name'];
						$meter=$_POST['meter'];
						$meterRate=$_POST['meterRate'];
						$B_DATE=$_POST['B_DATE'];
						$CGST=$_POST['CGST'];
						$SGST=$_POST['SGST'];
						$IGST=$_POST['IGST'];
						$amount=$_POST['amount'];
						$BILL_NO=$_POST['BILL_NO'];
						$sqlquery="INSERT INTO MERCHANT_BILLS_TBL(BILL_NO,DATE,FABRIC_MERCHANTS_ID,AMOUNT,CGST,SGST,IGST,loc,MTR,RATE)VALUES($BILL_NO,'".$B_DATE."',(SELECT fabric_merchants_id FROM fabric_merchants_tbl where COMPANY_NAME='".$merchant_name."'),$amount,$CGST,$SGST,$IGST,'$location','$meter','$meterRate')";                                                           
	
						$status=mysqli_query($dbhandle,$sqlquery); 
					}else{
					$status=0;
					}
				}
	
	
		}
	
	
	
	
	
	echo $status;
	
	}
	else if($action=="fetchcustomerdetail"){
	 $customercompanyname=$_POST["customercompanyname"];
	 $sqlquery="Select * from FABRIC_MERCHANTS_TBL where COMPANY_NAME='".$customercompanyname."'";
     $show=mysqli_query($dbhandle,$sqlquery);
 
     while($row=mysqli_fetch_array($show)){
        $customerdetail['FABRIC_MERCHANTS_ID']=$row['FABRIC_MERCHANTS_ID'];
		$customerdetail['FNAME']=$row['FNAME'];
		$customerdetail['LNAME']=$row['LNAME'];
		$customerdetail['COMPANY_NAME']=$row['COMPANY_NAME'];
		$customerdetail['EMAIL']=$row['EMAIL'];
		
		$customerdetail['GSTN']=$row['GSTN'];
		$customerdetail['ADDRESS']=$row['ADDRESS'];
		$customerdetail['CITY']=$row['CITY'];
		$customerdetail['STATE']=$row['STATE'];
		$customerdetail['ZIP']=$row['ZIP'];
		
		
		echo json_encode($customerdetail);
		
		
		
		
     }
  }
	




















	
  
  
?>
