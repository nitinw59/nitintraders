<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
   
  $action=$_POST["action"];
 
  if($action=="fetchcustomerdetail"){
	 $customercompanyname=$_POST["customercompanyname"];
	 $sqlquery="Select * from fabric_merchants_tbl where COMPANY_NAME='".$customercompanyname."'";
     $show=mysqli_query($dbhandle,$sqlquery);
 
     while($row=mysqli_fetch_array($show)){
        $customerdetail['FABRIC_MERCHANTS_ID']=$row['FABRIC_MERCHANTS_ID'];
		$customerdetail['FNAME']=$row['FNAME'];
		$customerdetail['LNAME']=$row['LNAME'];
		$customerdetail['COMPANY_NAME']=$row['COMPANY_NAME'];
		$customerdetail['EMAIL']=$row['EMAIL'];
		$customerdetail['ADDRESS']=$row['ADDRESS'];
		$customerdetail['CITY']=$row['CITY'];
		$customerdetail['STATE']=$row['STATE'];
		$customerdetail['ZIP']=$row['ZIP'];
		
		
		echo json_encode($customerdetail);
		
		
		
		
     }
  }
  else if($action=="fetchbilldetails"){
	 $bill_id=$_POST["bill_id"];
	 $sqlquery="Select b.bill_id,b.TOTAL_AMOUNT,b.DATE,t.CGST,t.SGST,t.IGST from bills_tbl b, TAX_DETAILS_TBL t where b.BILL_ID=t.BILL_ID AND b.bill_id=".$bill_id;
     $show=mysqli_query($dbhandle,$sqlquery);
 
     while($row=mysqli_fetch_array($show)){
        $billdetail['bill_id']=$row['bill_id'];
		$billdetail['AMOUNT']=$row['TOTAL_AMOUNT'];
		$billdetail['DATE']=$row['DATE'];
		
		$billdetail['DATE']=$row['DATE'];
		$billdetail['CGST']=$row['CGST'];
		$billdetail['SGST']=$row['SGST'];
		$billdetail['IGST']=$row['IGST'];
		
		
		}
		
		$sqlquery="SELECT sum(amount) as amount FROM `payments_tbl` WHERE bill_id=".$bill_id;
		$show=mysqli_query($dbhandle,$sqlquery);
		if($row=mysqli_fetch_array($show))
		$billdetail['payment_amount']=$row['amount'];
		echo json_encode($billdetail);
		
  }else if($action=="addDebits"){
	$customer_id=$_POST["customer_id"];
	$date=$_POST["date"];
	$amount=$_POST["amount"];
	$remark=$_POST["remark"];
	$sqlquery="INSERT INTO debits_tbl (FABRIC_MERCHANTS_ID,DATE,AMOUNT,DESCRIPTION)VALUES(".$customer_id.",'".$date."',".$amount.",'".$remark."')";
    $show=mysqli_query($dbhandle,$sqlquery);
	echo $show;
  }else if($action=="listPayment"){
	$company_name=$_POST["company_name"];
	$from_date=$_POST["from_date"];
	$to_date=$_POST["to_date"];
	  
	 $sqlquery="SELECT p.date,p.amount,p.DESCRIPTION,p.BILL_ID FROM payments_tbl p, bills_tbl b, customers_tbl c WHERE p.BILL_ID=b.BILL_ID AND b.customer_id=c.customer_id AND c.COMPANY_NAME='".$company_name."' AND p.DATE>='".$from_date."' AND p.DATE<='".$to_date."'";
     $show=mysqli_query($dbhandle,$sqlquery);
 
	$payments_list;
	$row_count=0;
     while($row=mysqli_fetch_array($show)){
		$payment;
        $payment['date']=$row['date'];
		$payment['amount']=$row['amount'];
		$payment['DESCRIPTION']=$row['DESCRIPTION'];
		$payment['BILL_ID']=$row['BILL_ID'];
		
		$payments_list[$row_count]=$payment;
		$row_count++;
		}
		
		
		echo json_encode($payments_list);
		
  }
  
?>
