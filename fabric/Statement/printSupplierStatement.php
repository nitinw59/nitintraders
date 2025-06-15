<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
	
	
	$company_name=$_GET["company_name"];
	$from_date=$_GET["from_date"];
	$to_date=$_GET["to_date"];
	
	
		$sqlquery="select ADVANCE_CREDIT FROM fabric_merchants_tbl C WHERE C.COMPANY_NAME='".$company_name."'  ";
		$show=mysqli_query($dbhandle,$sqlquery);
		$row=mysqli_fetch_array($show);
		$ADVANCE_CREDITS=$row['ADVANCE_CREDIT'];
	
			$sqlquery="select 
				SUM(B.AMOUNT+B.CGST+B.SGST+B.IGST) as 'total_amount' ,
				SUM(B.payment_amount) as 'total_payment'
				FROM merchant_bills_tbl B,
			
				fabric_merchants_tbl C 
			
				WHERE 
				B.DATE<'$from_date' AND
				B.FABRIC_MERCHANTS_ID=C.FABRIC_MERCHANTS_ID AND
				C.COMPANY_NAME='$company_name'
				ORDER BY DATE ASC"; 

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
			
			FROM merchant_bills_tbl B,
			
			fabric_merchants_tbl C 
			
			WHERE 

			B.FABRIC_MERCHANTS_ID=C.FABRIC_MERCHANTS_ID AND
			C.COMPANY_NAME='$company_name' AND
			B.DATE>='$from_date' AND B.DATE<='$to_date' 
    
			order by date asc";
		
		$bills_list;
	$row_count=0;
	
	
	
	$show_bill_list=mysqli_query($dbhandle,$sqlquery);
	
    while($row=mysqli_fetch_array($show_bill_list)){
		$bill;
        
		$bill['BILL ID']=$row['BILL ID'];
		$bill['DATE']=date('d/m/Y', strtotime($row['DATE']));
		$bill['BILL AMOUNT']=round($row['BILL AMOUNT']);
		$bill['SGST']=round($row['SGST']);
		$bill['CGST']=round($row['CGST']);
		$bill['IGST']=round($row['IGST']);
		$bill['loc']=$row['loc'];
		$bill['PAYMENT AMOUNT']=$row['PAYMENT AMOUNT'];
		$bill['ITEM_QUANTITY']=$row['ITEM_QUANTITY'];
		$bill['ITEM_RATE']=$row['ITEM_RATE'];
		
		
		$bills_list[$row_count]=$bill;
		$row_count++;
		}
		
		//echo $old_bill_amount;
		//echo $sqlquery;
		
		
		
			

	
		echo "<left></br></br><h3>For: M/s. $company_name </h3></left>";
		echo "<table style='width:80%'  align=center><center>";
		echo "<caption>Supplier Invoice Statement <b>$MY_COMPANY_GSTN($MY_COMPANY_NAME)</b>  From: $from_date        To: $to_date </caption>";
		
		echo "<tr>";
				echo "<th><center>BILL_ID</center></th>";
				echo "<th ><center>*****DATE*****</center></th>";
				echo "<th><center>QUANTITY</center></th>";
				echo "<th><center>RATE</center></th>";
				echo "<th><center>BILL AMOUNT</center></th>";
				echo "<th><center>CGST</center></th>";
				echo "<th><center>SGST</center></th>";
				
				echo "<th><center>IGST</center></th>";
				
				echo "<th><center>TOTAL AMOUNT</center></th>";
				echo "<th><center>PAYMENT</center></th>";
				echo "<th><center>PENDING</center></th>";
				echo "<th><center>BALANCE</center></th>";
				
				
				echo "</tr>";
		
		
        
		
				
				
				echo "<tr>";
				echo "<td><center>-</center></td>";
				echo "<td><center>-</center></td>";
				echo "<td><center>-</center></td>";
				
				echo "<td><center>-</center></td>";
				
				echo "<td><center>-</center></td>";
				echo "<td><center>-</center></td>";
				echo "<td><center>-</center></td>";
				echo "<td><center>-</center></td>";
				echo "<td><center>-</center></td>";
				
				echo "<td><center-center></td>";
				echo "<td><center>-</center></td>";
				
				echo "<td><center>".round($old_balance)."</center></td>";
				
				echo "</tr>";
				
				$CURRENT_BALANCE=$old_balance;
			foreach ($bills_list as $bill) {
  
				$TOTAL_AMOUNT=$bill['BILL AMOUNT']+$bill['CGST']+$bill['SGST']+$bill['IGST'];
				$CURRENT_BALANCE+=($TOTAL_AMOUNT-$bill['PAYMENT AMOUNT']);
				echo "<tr>";
				echo "<td><center>".$bill['BILL ID']."</center></td>";
				echo "<td><center>".$bill['DATE']."</center></td>";
				echo "<td><center>".$bill['ITEM_QUANTITY']."</center></td>";
				echo "<td><center>".$bill['ITEM_RATE']."</center></td>";
				echo "<td><center>".$bill['BILL AMOUNT']."</center></td>";
				
				echo "<td><center>".$bill['CGST']."</center></td>";
				
				echo "<td><center>".$bill['SGST']."</center></td>";
				
				echo "<td><center>".$bill['IGST']."</center></td>";
				echo "<td><center>".($TOTAL_AMOUNT)."</center></td>";
				
				echo "<td><center>".($bill['PAYMENT AMOUNT'])."</center></td>";
				echo "<td><center>".($TOTAL_AMOUNT-$bill['PAYMENT AMOUNT'])."</center></td>";
				echo "<td><center>".round($CURRENT_BALANCE)."</center></td>";
				
				
				
				echo "</tr>";
				
				
		
		}
		
		
		echo "<tr><td colspan='11'><center>avaialable credits</center></td><td><center>".round($ADVANCE_CREDITS)."</center></td></tr>";
		echo "<tr><td colspan='11'><center>Total Balance Till Date: $to_date</center></td><td><center>".round($CURRENT_BALANCE-$ADVANCE_CREDITS)."</center></td></tr>";
		
		
		echo "</center>	</table>";
		?>
		
	<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
	</style>