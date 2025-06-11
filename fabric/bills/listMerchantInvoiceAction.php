<?php
  include($_SERVER['DOCUMENT_ROOT']."/omenweb/mysqlconnectdb.php");
 
   
  $action=$_POST["action"];
 
   if($action=="listMerchantInvoice"){
	$company_name=$_POST["company_name"];
	$from_date=$_POST["from_date"];
	$to_date=$_POST["to_date"];
	  
	 $sqlquery="select B.BILL_ID, B.MERCHANT_BILL_NUMBER,B.DATE,B.AMOUNT AS AMOUNT,B.TAX_AMOUNT AS TAX,(B.AMOUNT+B.TAX_AMOUNT) AS TOTAL_AMOUNT , (SELECT SUM(AMOUNT) FROM merchant_payments_tbl WHERE BILL_ID=B.BILL_ID) AS TOTAL_PAYMENT,to_maker,meters,rate FROM MERCHANT_BILLS_TBL B,  FABRIC_MERCHANTS_TBL FM WHERE B.FABRIC_MERCHANTS_ID=FM.FABRIC_MERCHANTS_ID AND FM.COMPANY_NAME='".$company_name."' AND B.DATE>='".$from_date."' AND B.DATE<='".$to_date."' order by B.date";
     $show=mysqli_query($dbhandle,$sqlquery);
	
	$bills_list;
	$row_count=0;
     while($row=mysqli_fetch_array($show)){
		$bill;
        $bill['BILL_ID']=$row['BILL_ID'];
		$bill['MERCHANT_BILL_NUMBER']=$row['MERCHANT_BILL_NUMBER'];
		$bill['DATE']=$row['DATE'];
		$bill['to_maker']=$row['to_maker'];
		$bill['meters']=$row['meters'];
		$bill['rate']=$row['rate'];
		$bill['AMOUNT']=$row['AMOUNT'];
		$bill['TAX']=$row['TAX'];
		
		$bill['TOTAL_AMOUNT']=$row['TOTAL_AMOUNT'];
		$bill['TOTAL_PAYMENT']=$row['TOTAL_PAYMENT'];
		
		$bills_list[$row_count]=$bill;
		$row_count++;
		}
		
		
		echo json_encode($bills_list);
		
  }
  
?>
