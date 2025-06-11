<?php

	include($_SERVER['DOCUMENT_ROOT']."/omenweb/mysqlconnectdb.php");
 
	$company_name=$_GET["company_name"];
	$from_date=$_GET["from_date"];
	$to_date=$_GET["to_date"];
	
	
	
	
	
	
	
	
	
	
	 $sqlquery="SELECT SUM(P.AMOUNT) As total_payment FROM payments_tbl P ,bills_tbl B , customers_tbl c  where  p.BILL_ID = b.BILL_ID AND B.customer_id=C.customer_id AND C.COMPANY_NAME='".$company_name."'";
     $show=mysqli_query($dbhandle,$sqlquery);
	 while($row=mysqli_fetch_array($show)){
        $total_payment=$row['total_payment'];
		
     }
	 $sqlquery="SELECT SUM(AMOUNT) AS CREDITS FROM credits_tbl CR, customers_tbl C WHERE CR.customer_id=C.customer_id AND C.COMPANY_NAME='".$company_name."'";
     $show=mysqli_query($dbhandle,$sqlquery);
	 while($row=mysqli_fetch_array($show)){
        $total_credits=$row['CREDITS'];
		
     }
	 $available_credits=$total_credits-$total_payment;
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	  
	$sqlquery="select B.BILL_ID,B.DATE,B.TOTAL_AMOUNT AS AMOUNT,(T.CGST+T.SGST+T.IGST) AS TAX ,(B.TOTAL_AMOUNT+T.CGST+T.SGST+T.IGST) AS TOTALAMOUNT, (SELECT SUM(AMOUNT) FROM payments_tbl WHERE BILL_ID=B.BILL_ID) AS TOTAL_PAYMENT FROM bills_tbl B, tax_details_tbl T, customers_tbl C WHERE B.BILL_ID=T.BILL_ID AND B.customer_id=C.customer_id AND C.COMPANY_NAME='".$company_name."' AND b.DATE>='".$from_date."' AND b.DATE<='".$to_date."'";
    $show=mysqli_query($dbhandle,$sqlquery);
	
		echo "<left></br></br><h3>For: M/s. $company_name </h3></left>";
		echo "<left><h3>Avaialable Balance: $available_credits </h3></left>";
		echo "<table style='width:80%'  align=center><center>";
		echo "<caption>Invoice Statement From: $from_date        To: $to_date </caption>";
		
		echo "<tr>";
				echo "<th><center>BILL_ID</center></th>";
				echo "<th ><center>*****DATE*****</center></th>";
				echo "<th><center>AMOUNT</center></th>";
				echo "<th><center>TAX</center></th>";
				
				echo "<th><center>TOTALAMOUNT</center></th>";
				
				echo "<th><center>TOTAL_PAYMENT</center></th>";
				echo "<th><center>PENDING</center></th>";
				
				
				echo "</tr>";
		$TOTAL_AMOUNT=0;
		$TOTAL_PAYMENT=0;
		$TOTAL_PENDING=0;
		
	 while($row=mysqli_fetch_array($show)){
	    
		
		
		 
				echo "<tr>";
				echo "<td><center>".$row['BILL_ID']."</center></td>";
				echo "<td><center>".$row['DATE']."</center></td>";
				echo "<td><center>".$row['AMOUNT']."</center></td>";
				echo "<td><center>".$row['TAX']."</center></td>";
				
				echo "<td><center>".$row['TOTALAMOUNT']."</center></td>";
				if($row['TOTAL_PAYMENT']==null)
					$row['TOTAL_PAYMENT']=0;
				echo "<td><center>".$row['TOTAL_PAYMENT']."</center></td>";
				$pending=($row['TOTALAMOUNT']-$row['TOTAL_PAYMENT']);
				echo "<td><center>".$pending."</center></td>";
				
				
				echo "</tr>";
				
				$TOTAL_AMOUNT+=$row['TOTALAMOUNT'];
				$TOTAL_PAYMENT+=$row['TOTAL_PAYMENT'];
				$TOTAL_PENDING+=$pending;
				
		
		}
		
		
		echo "<tr><td colspan='4'><center>Total</center></td><td><center>$TOTAL_AMOUNT</center></td><td><center>$TOTAL_PAYMENT</center></td><td><center>$TOTAL_PENDING</center></td></tr>";
		
		
		echo "</center>	</table>";
		?>
		
	<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
	</style>