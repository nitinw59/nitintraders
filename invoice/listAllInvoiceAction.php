<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
 
  $action=$_POST["action"];
 
   if($action=="listStatement"){
	$from_date=$_POST["from_date"];
	$to_date=$_POST["to_date"];
	  
	$sql = "SELECT B.BILL_ID, DATE, COMPANY_NAME,GSTN, TOTAL_AMOUNT, CGST, SGST, IGST FROM bills_tbl B,customers_tbl C, tax_details_tbl T WHERE B.BILL_ID=T.BILL_ID AND B.CUSTOMER_ID=C.CUSTOMER_ID AND b.DATE>='$from_date' AND b.DATE<='$to_date' ORDER BY COMPANY_NAME DESC";
	$show=mysqli_query($dbhandle,$sql);
	
	$bills_list;
	$row_count=0;
     while($row=mysqli_fetch_array($show)){
		$bill;
        $bill['BILL_ID']=$row['BILL_ID'];
		$bill['DATE']=$row['DATE'];
		$bill['COMPANY_NAME']=$row['COMPANY_NAME'];
		$bill['GSTN']=$row['GSTN'];
		$bill['CGST']=$row['CGST'];
		$bill['SGST']=$row['SGST'];
		$bill['IGST']=$row['IGST'];
		
		$bill['TOTAL_AMOUNT']=$row['TOTAL_AMOUNT'];
		
		$bills_list[$row_count]=$bill;
		$row_count++;
		}
		
		//echo $sqlquery;
		echo json_encode($bills_list);
		
  }
  
?>
