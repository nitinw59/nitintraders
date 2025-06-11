<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	
  $action=$_POST["action"];
 
 
 if($action=="listSupplierStatement"){
	
	
	
	//TO REFRESH PAYMENTS FROM CREDITS
	
	$company_name=$_POST["company_name"];
	$from_date=$_POST["from_date"];
	$to_date=$_POST["to_date"];
	  
	$sqlquery="select ADVANCE_CREDIT FROM FABRIC_MERCHANTS_TBL C WHERE C.COMPANY_NAME='".$company_name."'  ";
    $show=mysqli_query($dbhandle,$sqlquery);
	$row=mysqli_fetch_array($show);
	$ADVANCE_CREDITS=0;
	$ADVANCE_CREDITS=$row['ADVANCE_CREDIT'];
	
	//echo $ADVANCE_CREDITS;
	
	//while($row=mysqli_fetch_array($show) AND $CREDITS_AVAILABLE){
			//echo "c";
			//if($row['BILL AMOUNT']<=($ADVANCE_CREDITS-$ACCUMULATED_PAID_CREDITS)){
			//echo "a";
			//$payment_querry.="update merchant_bills_tbl set payment_amount=".$row['BILL AMOUNT']." where bill_id=".$row['BILL_ID'].";";
			//$ACCUMULATED_PAID_CREDITS+=($row['BILL AMOUNT']);
			
			//}else{
			//echo "b";
			
			//$CREDITS_AVAILABLE= false;
			//$newCredits=$ADVANCE_CREDITS-$ACCUMULATED_PAID_CREDITS;
			//$payment_querry.="update fabric_merchants_tbl set advance_credits=$newCredits where COMPANY_NAME='$company_name';";
			
	
			//}
			
		
	//}
	//echo "new credits: ".$ADVANCE_CREDITS;
	//echo "accumulated: ".$ACCUMULATED_PAID_CREDITS;
	
	//echo $ACCUMULATED_PAID_CREDITS;
	
		
    //echo $payment_querry;
	//echo "SHOW: ".$show;
	
	
	//$show=mysqli_multi_query($dbhandle,$payment_querry);
	//while (mysqli_next_result($dbhandle)) {;}
	
	
	//{
		
	
	$sqlquery="
	select 
			SUM(B.AMOUNT+B.CGST+B.SGST+B.IGST) as 'total_amount' ,
			SUM(b.payment_amount) as 'total_payment'
			FROM MERCHANT_BILLS_TBL B,
			
			FABRIC_MERCHANTS_TBL C 
			
			WHERE 
			B.DATE<'$from_date' AND
			B.FABRIC_MERCHANTS_ID=C.FABRIC_MERCHANTS_ID AND
			C.COMPANY_NAME='$company_name'

			ORDER BY DATE ASC	
	 
	 
	"; 
	
	
	
	$show=mysqli_query($dbhandle,$sqlquery);
	$row=mysqli_fetch_array($show);
	$old_amount=$row['total_amount'];
	$old_payment=$row['total_payment'];
	$old_balance=$old_amount-$old_payment;
	
		
		
	$sqlquery="select 
			B.BILL_ID as 'BILL ID',
			B.DATE as 'DATE',
			B.MTR as 'ITEM_QUANTITY'  ,
			B.RATE as 'ITEM_RATE'  ,
			B.AMOUNT AS 'BILL AMOUNT',
			B.CGST AS 'CGST',
			B.SGST AS 'SGST',
			B.IGST AS 'IGST',
			B.loc AS 'loc',
			payment_amount as 'PAYMENT AMOUNT'	
			
			FROM MERCHANT_BILLS_TBL B,
			
			FABRIC_MERCHANTS_TBL C 
			
			WHERE 

			B.FABRIC_MERCHANTS_ID=C.FABRIC_MERCHANTS_ID AND
			C.COMPANY_NAME='$company_name' AND
			b.DATE>='$from_date' AND b.DATE<='$to_date' 
    
			order by date asc";
		
		
		
		
	
	$bills_list;
	$row_count=0;
	
	
	$bill;
        
		$bill['BILL ID']=0;
		$bill['DATE']='';
		$bill['BILL AMOUNT']=$old_balance;
		$bill['CGST']=0;
		$bill['SGST']=0;
		$bill['IGST']=0;
		$bill['loc']='';
		$bill['PAYMENT AMOUNT']=$ADVANCE_CREDITS;
		$bill['ITEM_QUANTITY']='';
		$bill['ITEM_RATE']='';
		
		
		$bills_list[$row_count]=$bill;
	
	$row_count++;
		
	
	$show_bill_list=mysqli_query($dbhandle,$sqlquery);
	
    while($row=mysqli_fetch_array($show_bill_list)){
		$bill;
        
		$bill['BILL ID']=$row['BILL ID'];
		$bill['DATE']=date('d/m/Y', strtotime($row['DATE']));
		$bill['BILL AMOUNT']=$row['BILL AMOUNT'];
		$bill['SGST']=$row['SGST'];
		$bill['CGST']=$row['CGST'];
		$bill['IGST']=$row['IGST'];
		$bill['loc']=$row['loc'];
		$bill['PAYMENT AMOUNT']=$row['PAYMENT AMOUNT'];
		$bill['ITEM_QUANTITY']=$row['ITEM_QUANTITY'];
		$bill['ITEM_RATE']=$row['ITEM_RATE'];
		
		
		$bills_list[$row_count]=$bill;
		$row_count++;
		}
		
		//echo $old_bill_amount;
		//echo $sqlquery;
		
		echo json_encode($bills_list);
	
	//}
		
  }else if($action=="getSupplierCredits"){
	$company_name=$_POST["company_name"];
	$sqlquery="select ADVANCE_CREDIT FROM FABRIC_MERCHANTS_TBL C WHERE C.COMPANY_NAME='".$company_name."'  ";
    $show=mysqli_query($dbhandle,$sqlquery);
	$row=mysqli_fetch_array($show);
	$ADVANCE_CREDITS=0;
	$ADVANCE_CREDITS=$row['ADVANCE_CREDIT'];
	echo $ADVANCE_CREDITS;
	
   }else if($action=="makePayment"){
	$billId=$_POST["billId"];
	$paymentamount=$_POST["paymentamount"];
	$payment_querry="update merchant_bills_tbl set payment_amount=$paymentamount where bill_id=$billId;";
	$show=mysqli_query($dbhandle,$payment_querry);
	echo $show;
	
   }
  
  
 
?>
