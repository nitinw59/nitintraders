<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
	
	$company_name=$_GET["company_name"];
	$from_date=$_GET["from_date"];
	$to_date=$_GET["to_date"];
	  
		$sqlquery="SELECT * FROM `fabric_merchants_tbl` where COMPANY_NAME='$company_name'";
		$show=mysqli_query($dbhandle,$sqlquery);
		$row=mysqli_fetch_array($show);
		echo "<left>For: M/s. $company_name </left>";
		echo "<left></br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ".$row['ADDRESS'] ."</left>";
		echo "<left></br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ".$row['CITY'] ."</left>";
		echo "<left></br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp GSTN-".$row['GSTN'] ."</left>";
		
		echo "</br><table style='width:80%'  align=center><center>";
		echo "<caption>Payments Statement From: $from_date        To: $to_date </caption>";
		
		echo "<tr>";
				echo "<th><center>BILL_ID</center></th>";
				echo "<th width='20%'><center>DATE</center></th>";
				echo "<th><center>PAYMENT</center></th>";
				echo "<th><center>DESCRIPTION</center></th>";
				
					
				echo "</tr>";
		$TOTAL_AMOUNT=0;
		$TOTAL_PAYMENT=0;
		$TOTAL_PENDING=0;
		 $sqlquery="select B.MERCHANT_BILL_NUMBER, MP.DATE, MP.AMOUNT, MP.DESCRIPTION  FROM merchant_payments_tbl mp, MERCHANT_BILLS_TBL B,  FABRIC_MERCHANTS_TBL FM WHERE mp.BILL_ID=B.BILL_ID AND B.FABRIC_MERCHANTS_ID=FM.FABRIC_MERCHANTS_ID AND FM.COMPANY_NAME='".$company_name."' AND B.DATE>='".$from_date."' AND B.DATE<='".$to_date."'";
     $show=mysqli_query($dbhandle,$sqlquery);
	
	 while($row=mysqli_fetch_array($show)){
	    
		
		
		 
				echo "<tr>";
				echo "<td><center>".$row['MERCHANT_BILL_NUMBER']."</center></td>";
				echo "<td><center>".$row['DATE']."</center></td>";
				echo "<td><center>".$row['AMOUNT']."</center></td>";
				echo "<td><center>".$row['DESCRIPTION']."</center></td>";
				
				echo "</tr>";
				$TOTAL_PAYMENT+=$row['AMOUNT'];
				
		
		}
		
		
		echo "<tr><td colspan='2'><center>Total</center></td><td><center>$TOTAL_PAYMENT</center></td></tr>";
		
		
		echo "</center>	</table>";
		?>
		
	<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
	</style>