<?php
 include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
   
  $action=$_POST["action"];
 
   if($action=="listCustomerStatement"){
	$company_name=$_POST["company_name"];
	$from_date=$_POST["from_date"];
	$to_date=$_POST["to_date"];
	$sqlquery="select SUM(B.TOTAL_AMOUNT+T.CGST+T.SGST+T.IGST) AS TOTALAMOUNT FROM bills_tbl B, tax_details_tbl T, customers_tbl C WHERE B.BILL_ID=T.BILL_ID AND B.customer_id=C.customer_id AND C.COMPANY_NAME='".$company_name."'  AND B.DATE<'".$from_date."' order by  B.BILL_ID desc";
    //$sqlquery="select SUM(B.TOTAL_AMOUNT) AS TOTALAMOUNT FROM bills_tbl B,  customers_tbl C WHERE B.customer_id=C.customer_id AND C.COMPANY_NAME='".$company_name."'  AND b.DATE<'".$from_date."' order by  b.BILL_ID desc";
    $show=mysqli_query($dbhandle,$sqlquery);
	$row=mysqli_fetch_array($show);
	$old_bill_amount=$row['TOTALAMOUNT'];
	
	
	
	
	 $sqlquery="
	 SELECT 
	 SUM(AMOUNT)  as TOTAL_PAYMENT
	 FROM credits_tbl cr, customers_tbl c
	 WHERE 
	 c.customer_id=cr.customer_id 
	 AND c.COMPANY_NAME='".$company_name."'  
	 AND cr.DATE<'".$from_date."'"; 
	 $show=mysqli_query($dbhandle,$sqlquery);
	$row=mysqli_fetch_array($show);
	
	if($row['TOTAL_PAYMENT']==null)
		$row['TOTAL_PAYMENT']=0;
	
		$old_payment=$row['TOTAL_PAYMENT'];
	
	$old_balance=$old_bill_amount-$old_payment;
	
	
	
	$sqlquery="select 
			b.BILL_ID as 'BILL ID',
			b.DATE as 'DATE',
			(b.TOTAL_AMOUNT+t.CGST+t.SGST+t.IGST) AS 'BILL AMOUNT',
			(select GROUP_CONCAT(bi.quantity) from bill_items_tbl bi where bi.BILL_ID=b.BILL_ID) as 'QUANTITY'  ,
			(select GROUP_CONCAT(bi.rate) from bill_items_tbl bi where bi.BILL_ID=b.BILL_ID) as 'RATE'  ,
			DATE_FORMAT(tr.DATE, '%d/%m/%Y') as t_date,		
			tr.LR as LR,
			tr.transport_name as transport_name,
			tr.transport_parcels as transport_parcels,
			0 as 'PAYMENT AMOUNT',	
			0 as 'PAYMENT DESCRIPTION'

			FROM bills_tbl b,
			transport_tbl tr,
			tax_details_tbl t,
			customers_tbl c 
			
			WHERE 

			b.BILL_ID=tr.BILL_ID AND
			t.BILL_ID=b.BILL_ID AND
			b.customer_id=c.customer_id AND
			c.COMPANY_NAME='$company_name' AND
			b.DATE>='$from_date' AND b.DATE<='$to_date' 
    

			UNION ALL


 
			SELECT 

			0 as 'BILL ID',
			c.date AS 'DATE',
			0 as 'BILL AMOUNT',
			'' as QUANTITY,
			'' as RATE,
			'' as t_date,
			'' as LR,
			'' as transport_name,
			0 as transport_parcels,
			c.amount as 'PAYMENT AMOUNT',
			c.DESCRIPTION as 'PAYMENT DESCRIPTION'
 
 
			FROM credits_tbl c,
			customers_tbl cr 

			WHERE
			cr.customer_id=c.customer_id 
			AND cr.COMPANY_NAME='$company_name' 
			AND c.DATE>='$from_date' 
			AND c.DATE<='$to_date'
			
			order by date asc";
			
	



	$show=mysqli_query($dbhandle,$sqlquery);
	
	$bills_list;
	$row_count=0;
	
	
	$bill;
        
		$bill['BILL ID']=0;
		$bill['DATE']='';
		$bill['BILL AMOUNT']=$old_balance;
		$bill['t_date']='';
		$bill['LR']=0;
		$bill['LR_LOC']='';
		$bill['transport_name']='';
		$bill['transport_parcels']=0;
		$bill['PAYMENT AMOUNT']=0;
		$bill['PAYMENT DESCRIPTION']='';
		$bill['ITEM_QUANTITY']='';
		$bill['ITEM_RATE']='';
		
		
		$bills_list[$row_count]=$bill;
	
	$row_count++;
	
	
	
	
    while($row=mysqli_fetch_array($show)){
		$bill;
        
		$bill['BILL ID']=$row['BILL ID'];
		$bill['DATE']=date('d/m/Y', strtotime($row['DATE']));
		$bill['BILL AMOUNT']=$row['BILL AMOUNT'];
		$bill['t_date']=$row['t_date'];
		$bill['LR']=$row['LR'];
		$bill['LR_LOC']=$row['LR_LOC'];
		$bill['transport_name']=$row['transport_name'];
		$bill['transport_parcels']=$row['transport_parcels'];
		$bill['PAYMENT AMOUNT']=$row['PAYMENT AMOUNT'];
		$bill['PAYMENT DESCRIPTION']=$row['PAYMENT DESCRIPTION'];
		$bill['ITEM_QUANTITY']=$row['QUANTITY'];
		$bill['ITEM_RATE']=$row['RATE'];
		
		
		$bills_list[$row_count]=$bill;
		$row_count++;
		}
		
		//echo $old_bill_amount;
		//echo $sqlquery;
		
		echo json_encode($bills_list);
		
  }
  
?>
