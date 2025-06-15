<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
		$company_name=$_GET["company_name"];
	$from_date=$_GET["from_date"];
	$to_date=$_GET["to_date"];
	
	
	
	$sql = "SELECT B.BILL_NO, DATE, COMPANY_NAME,GSTN, AMOUNT, CGST, SGST, IGST FROM merchant_bills_tbl B,fabric_merchants_tbl C WHERE B.FABRIC_MERCHANTS_ID=C.FABRIC_MERCHANTS_ID AND B.DATE>='$from_date' AND B.DATE<='$to_date' ORDER BY B.DATE ";
			$show=mysqli_query($dbhandle,$sql);
	
		echo "<table style='width:80%'  align=center><center>";
		echo "<caption>Suppliers Invoice Statement Of <b>$MY_COMPANY_GSTN($MY_COMPANY_NAME)</b>  From: $from_date        To: $to_date </caption>";
		
		echo "<tr>";
				echo "<th><center>BILL_NO</center></th>";
				echo "<th ><center>*****DATE*****</center></th>";
				echo "<th><center>SUPPLIER</center></th>";
				echo "<th><center>GSTN</center></th>";
				
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
        
		$bill['BILL_NO']=$row['BILL_NO'];
		$bill['DATE']=$row['DATE'];
		$bill['COMPANY_NAME']=$row['COMPANY_NAME'];
		$bill['GSTN']=$row['GSTN'];
		$bill['AMOUNT']=$row['AMOUNT'];
		$bill['CGST']=$row['CGST'];
		$bill['SGST']=$row['SGST'];
		$bill['IGST']=$row['IGST'];
		$bill['TOTAL']=$bill['AMOUNT']+$bill['CGST']+$bill['SGST']+$bill['IGST'];
		
		
		$CGST+=$bill['CGST'];
		$SGST+=$bill['SGST'];
		$IGST+=$bill['IGST'];
		
		 
				echo "<tr>";
				echo "<td><center>".$bill['BILL_NO']."</center></td>";
				echo "<td><center>".$bill['DATE']."</center></td>";
				echo "<td><center>".$bill['COMPANY_NAME']."</center></td>";
				
				echo "<td><center>".$bill['GSTN']."</center></td>";
				
				echo "<td><center>".$bill['AMOUNT']."</center></td>";
				echo "<td><center>".$bill['CGST']."</center></td>";
				
				echo "<td><center>".$bill['SGST']."</center></td>";
				echo "<td><center>".$bill['IGST']."</center></td>";
				echo "<td><center>".round($bill['TOTAL'])."</center></td>";
				
				
				
				echo "</tr>";
				
				
		
		}
		
		
		echo "<tr>";
				echo "<td colspan='5'><center>TOTAL</center></td>";
				
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