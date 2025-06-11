<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
	
	$company_name=$_GET["company_name"];
	$from_date=$_GET["from_date"];
	$to_date=$_GET["to_date"];
	
	
	$sqlquery="select SUM(B.TOTAL_AMOUNT+T.CGST+T.SGST+T.IGST) AS TOTALAMOUNT FROM bills_tbl B, tax_details_tbl T, customers_tbl C WHERE B.BILL_ID=T.BILL_ID AND B.customer_id=C.customer_id AND C.COMPANY_NAME='".$company_name."'  AND b.DATE<'".$from_date."' order by  b.BILL_ID desc";
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
			B.BILL_ID as 'BILL ID',
			B.DATE as 'DATE',
			(B.TOTAL_AMOUNT+T.CGST+T.SGST+T.IGST) AS 'BILL AMOUNT',
			(select GROUP_CONCAT(bi.quantity) from bill_items_tbl bi where bi.BILL_ID=b.BILL_ID) as 'QUANTITY'  ,
			(select GROUP_CONCAT(bi.rate) from bill_items_tbl bi where bi.BILL_ID=b.BILL_ID) as 'RATE'  ,
			DATE_FORMAT(tr.DATE, '%d/%m/%Y') as t_date,		
			tr.LR as LR,
			tr.transport_name as transport_name,
			tr.transport_parcels as transport_parcels,
			0 as 'PAYMENT AMOUNT',	
			0 as 'PAYMENT DESCRIPTION'

			FROM bills_tbl B,
			transport_tbl tr,
			tax_details_tbl T,
			customers_tbl C 
			
			WHERE 

			B.BILL_ID=tr.BILL_ID AND
			T.BILL_ID=B.BILL_ID AND
			B.customer_id=C.customer_id AND
			C.COMPANY_NAME='$company_name' AND
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
			customers_tbl Cr 

			WHERE
			cr.customer_id=c.customer_id 
			AND cr.COMPANY_NAME='$company_name' 
			AND c.DATE>='$from_date' 
			AND c.DATE<='$to_date'
			
			order by date asc";
			
			$show=mysqli_query($dbhandle,$sqlquery);
	
		echo "<center></br></br><h3>$MY_COMPANY_NAME($MY_COMPANY_GSTN) </h3></center>";
		echo "<center><h5>$MY_COMPANY_CITY </h5></center>";
		echo "<left></br></br><h3>For: M/s. $company_name </h3></left>";
		echo "<table style='width:80%'  align=center><center>";
		echo "<caption>Invoice Statement From: $from_date        To: $to_date </caption>";
		
		echo "<tr>";
				echo "<th><center>BILL_ID</center></th>";
				echo "<th ><center>*****DATE*****</center></th>";
				echo "<th><center>TRANSPORT</center></th>";
				echo "<th><center>BOOKING DATE</center></th>";
				
				echo "<th><center>LR</center></th>";
				
				echo "<th><center>PARCELS</center></th>";
				echo "<th><center>QUANTITY</center></th>";
				echo "<th><center>RATE</center></th>";
				echo "<th><center>BILL AMOUNT</center></th>";
				echo "<th><center>DESCRIPTION</center></th>";
				echo "<th><center>PAYMENT</center></th>";
				echo "<th><center>BALANCE</center></th>";
				
				
				echo "</tr>";
		
		$bill;
        
		$bill['BILL ID']='-';
		$bill['DATE']='-';
		$bill['BILL AMOUNT']='-';
		$bill['QUANTITY']='-';
		$bill['RATE']='-';
		$bill['t_date']='-';
		$bill['LR']='-';
		$bill['transport_name']='-';
		$bill['transport_parcels']='-';
		$bill['PAYMENT AMOUNT']='-';
		$bill['PAYMENT DESCRIPTION']='-';
				
				
				echo "<tr>";
				echo "<td><center>".$bill['BILL ID']."</center></td>";
				echo "<td><center>".$bill['DATE']."</center></td>";
				echo "<td><center>".$bill['transport_name']."</center></td>";
				
				echo "<td><center>".$bill['t_date']."</center></td>";
				
				echo "<td><center>".$bill['LR']."</center></td>";
				echo "<td><center>".$bill['transport_parcels']."</center></td>";
				echo "<td><center>".$bill['QUANTITY']."</center></td>";
				echo "<td><center>".$bill['RATE']."</center></td>";
				echo "<td><center>".$bill['BILL AMOUNT']."</center></td>";
				
				echo "<td><center>".$bill['PAYMENT DESCRIPTION']."</center></td>";
				echo "<td><center>".$bill['PAYMENT AMOUNT']."</center></td>";
				
				echo "<td><center>".$old_balance."</center></td>";
				
				echo "</tr>";
				
				
				
				
		while($row=mysqli_fetch_array($show)){
	    	$bill;
        
		$bill['BILL ID']=$row['BILL ID'];
		$bill['DATE']=$row['DATE'];
		$bill['BILL AMOUNT']=$row['BILL AMOUNT'];
		$bill['t_date']=$row['t_date'];
		$bill['LR']=$row['LR'];
		$bill['transport_name']=$row['transport_name'];
		$bill['transport_parcels']=$row['transport_parcels'];
		$bill['QUANTITY']=$row['QUANTITY'];
		$bill['RATE']=$row['RATE'];
		$bill['PAYMENT AMOUNT']=$row['PAYMENT AMOUNT'];
		$bill['PAYMENT DESCRIPTION']=$row['PAYMENT DESCRIPTION'];
		
		$old_balance=$old_balance+$bill['BILL AMOUNT']-$bill['PAYMENT AMOUNT'];
		
				if($bill['PAYMENT AMOUNT']==0){
						echo "<tr>";
						echo "<td><center>".$bill['BILL ID']."</center></td>";
						echo "<td><center>".$bill['DATE']."</center></td>";
						echo "<td><center>".$bill['transport_name']."</center></td>";
				
						echo "<td><center>".$bill['t_date']."</center></td>";
				
						echo "<td><center>".$bill['LR']."</center></td>";
						echo "<td><center>".$bill['transport_parcels']."</center></td>";
						echo "<td><center>".$bill['QUANTITY']."</center></td>";
						echo "<td><center>".$bill['RATE']."</center></td>";
						echo "<td><center>".$bill['BILL AMOUNT']."</center></td>";
						echo "<td><center>-</center></td>";
						echo "<td><center>-</center></td>";
						echo "<td><center>".$old_balance."</center></td>";
						echo "</tr>";
				}elseif($bill['BILL AMOUNT']==0){
						echo "<tr>";
						echo "<td><center>-</center></td>";
						echo "<td><center>".$bill['DATE']."</center></td>";
						echo "<td><center>-</center></td>";
				
						echo "<td><center>-</center></td>";
				
						echo "<td><center>-</center></td>";
						echo "<td><center>-</center></td>";
						echo "<td><center>-</center></td>";
						echo "<td><center>-</center></td>";
						echo "<td><center>-</center></td>";
						echo "<td><center>".$bill['PAYMENT DESCRIPTION']."</center></td>";
						echo "<td><center>".$bill['PAYMENT AMOUNT']."</center></td>";
						echo "<td><center>".$old_balance."</center></td>";
						echo "</tr>";
				}
				
				
		
		}
		
		
		echo "<tr><td colspan='11'><center>Total Balance Till Date: $to_date</center></td><td><center>$old_balance</center></td></tr>";
		
		
		echo "</center>	</table>";
		?>
		
	<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
	</style>