
<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
 
  $action=$_POST["action"];
 
   if($action=="listStatement"){
	$from_date=$_POST["from_date"];
	$to_date=$_POST["to_date"];
	  
	$sql = "SELECT B.BILL_NO, DATE, COMPANY_NAME,GSTN, AMOUNT, CGST, SGST, IGST FROM merchant_bills_tbl B,fabric_merchants_tbl C WHERE B.FABRIC_MERCHANTS_ID=C.FABRIC_MERCHANTS_ID AND B.DATE>='$from_date' AND B.DATE<='$to_date' ORDER BY B.DATE ";
	$show=mysqli_query($dbhandle,$sql);
	
	$bills_list;
	$row_count=0;
     while($row=mysqli_fetch_array($show)){
		$bill;
        $bill['BILL_NO']=$row['BILL_NO'];
		$bill['DATE']=$row['DATE'];
		$bill['COMPANY_NAME']=$row['COMPANY_NAME'];
		$bill['GSTN']=$row['GSTN'];
		$bill['CGST']=$row['CGST'];
		$bill['SGST']=$row['SGST'];
		$bill['IGST']=$row['IGST'];
		
		$bill['AMOUNT']=$row['AMOUNT'];
		
		$bills_list[$row_count]=$bill;
		$row_count++;
		}
		
		//echo $sqlquery;
		echo json_encode($bills_list);
		
  }
  
?>
