<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
	
  $action=$_POST["action"];
 
   if($action=="listMerchantPayments"){
	$company_name=$_POST["company_name"];
	$from_date=$_POST["from_date"];
	$to_date=$_POST["to_date"];
	  
	 $sqlquery="select B.MERCHANT_BILL_NUMBER, MP.DATE, MP.AMOUNT, MP.DESCRIPTION  FROM merchant_payments_tbl mp, MERCHANT_BILLS_TBL B,  FABRIC_MERCHANTS_TBL FM WHERE mp.BILL_ID=B.BILL_ID AND B.FABRIC_MERCHANTS_ID=FM.FABRIC_MERCHANTS_ID AND FM.COMPANY_NAME='".$company_name."' AND B.DATE>='".$from_date."' AND B.DATE<='".$to_date."'";
     $show=mysqli_query($dbhandle,$sqlquery);
		
	$payments_list;
	$row_count=0;
     while($row=mysqli_fetch_array($show)){
		$payment;
        $payment['MERCHANT_BILL_NUMBER']=$row['MERCHANT_BILL_NUMBER'];
		$payment['DATE']=$row['DATE'];
		$payment['AMOUNT']=$row['AMOUNT'];
		$payment['DESCRIPTION']=$row['DESCRIPTION'];
		
		
		$payments_list[$row_count]=$payment;
		$row_count++;
		}
		
		
		echo json_encode($payments_list);
		
  }
  
?>
