<?php
  include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");

   
  $action=$_POST["action"];
 
  if($action=="fetchTransportDetails"){
	 $bill_id=$_POST["bill_id"];
	 $sqlquery="Select t.LR,t.EWAY,t.transport_name,t.transport_parcels,t.DATE, c.COMPANY_NAME from transport_tbl t, customers_tbl c,bills_tbl b where b.BILL_ID=t.BILL_ID and b.customer_id=c.customer_id and t.bill_id=".$bill_id;
     $show=mysqli_query($dbhandle,$sqlquery);
	
	
	
     while($row=mysqli_fetch_array($show)){
        $transportDetails['LR']=$row['LR'];
        $transportDetails['LR_EWAY']=$row['EWAY'];
		$transportDetails['transport_name']=$row['transport_name'];
		$transportDetails['transport_parcels']=$row['transport_parcels'];
		$transportDetails['DATE']=$row['DATE'];
		$transportDetails['COMPANY_NAME']=$row['COMPANY_NAME'];
		
		echo json_encode($transportDetails);
		
		
		
		
     }
  }
  else if($action=="updateTransportDetails"){
	  
	$status=0;
	$location="";	
	
		if(isset($_FILES['img_file']['name'])){
		
				$filename = $_FILES['img_file']['name'];
				$filename = $_POST['bill_id'].".jpg";

				$location = "LR/".$filename;
				$uploadOk = 1;
				$imageFileType = pathinfo($location,PATHINFO_EXTENSION);

				$valid_extensions = array("jpg","jpeg","png");
					if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
						$uploadOk = 0;
						$location="";
					}

							if($uploadOk == 0){
								$status=0;
								$location="";
							}else{
								if(move_uploaded_file($_FILES['img_file']['tmp_name'],$location)){
								$status=1;
								}else{
								$status=0;
								$location="";
								}
							}
	
	
		}
	
	
	
	
	$bill_id=$_POST['bill_id'];
	$LR_DATE=$_POST['LR_DATE'];
	$LR_TRANSPORT=$_POST['LR_TRANSPORT'];
	$LR_PARCELS=$_POST['LR_PARCELS'];
	$LR=$_POST['LR'];
	$LR_EWAY=$_POST['LR_EWAY'];
	
	if (strcmp($location, "") !== 0)
	$query_upload="update transport_tbl set LR_LOC='$location',date='".$LR_DATE."' ,lr=".$LR.",EWAY=".$LR_EWAY.",transport_name='".$LR_TRANSPORT."',transport_parcels=".$LR_PARCELS." where bill_id=".$bill_id.";";
	else
	$query_upload="update transport_tbl set date='".$LR_DATE."' ,EWAY=".$LR_EWAY.",transport_name='".$LR_TRANSPORT."',transport_parcels=".$LR_PARCELS." where bill_id=".$bill_id.";";
	
	$status=mysqli_query($dbhandle,$query_upload); 
	
	echo $status;
	
	}
	
	




















	
  
  
?>
