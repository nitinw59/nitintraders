<?php

	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");

	$company_name=$_GET["company_name"];
	$from_date=$_GET["from_date"];
	$to_date=$_GET["to_date"];
	
	
	
	
	 $sqlquery = "SELECT B.BILL_ID, DATE, COMPANY_NAME,GSTN, TOTAL_AMOUNT, CGST, SGST, IGST,(select GROUP_CONCAT(bi.quantity) from bill_items_tbl bi where bi.BILL_ID=b.BILL_ID) as 'ITEM_QUANTITY'  ,
			(select GROUP_CONCAT(bi.rate) from bill_items_tbl bi where bi.BILL_ID=b.BILL_ID) as 'ITEM_RATE'  
			FROM bills_tbl B,customers_tbl C, tax_details_tbl T WHERE B.BILL_ID=T.BILL_ID AND B.CUSTOMER_ID=C.CUSTOMER_ID AND b.DATE>='$from_date' AND b.DATE<='$to_date' ORDER BY COMPANY_NAME DESC";
			$show=mysqli_query($dbhandle,$sqlquery);
	
		echo "<table style='width:80%'  align=center><center>";
		echo "<caption>Sale Invoice Statement Of <b>$MY_COMPANY_GSTN($MY_COMPANY_NAME)</b>  From: $from_date        To: $to_date </caption>";
		
		echo "<tr>";
				echo "<th><center>BILL_ID</center></th>";
				echo "<th ><center>*****DATE*****</center></th>";
				echo "<th><center>BUYER</center></th>";
				echo "<th><center>GSTN</center></th>";
				echo "<th><center>HSN</center></th>";
				echo "<th><center>Pieces</center></th>";
				echo "<th><center>Rate</center></th>";
				
				echo "<th><center>AMOUNT</center></th>";
				
				echo "<th><center>CGST</center></th>";
				echo "<th><center>SGST</center></th>";
				echo "<th><center>IGST AMOUNT</center></th>";
				echo "<th><center>TOTAL_AMOUNT</center></th>";
				
				
				echo "</tr>";
		
			
			
			$CGST=0;
			$SGST=0;
			$IGST=0;

			
		while($row=mysqli_fetch_array($show)){
	    	$bill;
        
		$bill['BILL_ID']=$row['BILL_ID'];
		$bill['DATE']=$row['DATE'];
		$bill['COMPANY_NAME']=$row['COMPANY_NAME'];
		$bill['GSTN']=$row['GSTN'];
		$bill['HSN']="6203";
		$bill['ITEM_QUANTITY']=$row['ITEM_QUANTITY'];
		$bill['ITEM_RATE']=$row['ITEM_RATE'];
		$bill['AMOUNT']=$row['TOTAL_AMOUNT'];
		$bill['CGST']=$row['CGST'];
		$bill['SGST']=$row['SGST'];
		$bill['IGST']=$row['IGST'];
		$bill['TOTAL']=$bill['AMOUNT']+$bill['CGST']+$bill['SGST']+$bill['IGST'];
		
		
		
		
		$CGST+=$bill['CGST'];
		$SGST+=$bill['SGST'];
		$IGST+=$bill['IGST'];
		
		
		
		
		 
				echo "<tr>";
				echo "<td><center>".$bill['BILL_ID']."</center></td>";
				echo "<td><center>".$bill['DATE']."</center></td>";
				echo "<td><center>".$bill['COMPANY_NAME']."</center></td>";
				
				echo "<td><center>".$bill['GSTN']."</center></td>";
				
				echo "<td><center>".$bill['HSN']."</center></td>";
				echo "<td><center>".$bill['ITEM_QUANTITY']."</center></td>";
				echo "<td><center>".$bill['ITEM_RATE']."</center></td>";
				echo "<td><center>".$bill['AMOUNT']."</center></td>";
				echo "<td><center>".$bill['CGST']."</center></td>";
				
				echo "<td><center>".$bill['SGST']."</center></td>";
				echo "<td><center>".$bill['IGST']."</center></td>";
				echo "<td><center>".$bill['TOTAL']."</center></td>";
				
				
				
				echo "</tr>";
				
				
		
		}
		
		echo "<tr>";
				echo "<td colspan='8'><center>TOTAL</center></td>";
				
				echo "<td><center>".$CGST."</center></td>";
				
				echo "<td><center>".$SGST."</center></td>";
				echo "<td><center>".$IGST."</center></td>";
				echo "<td><center></center></td>";
				
				
				
				echo "</tr>";
		
		
		echo "</center>	</table>";
		?>
		
	<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
	</style>