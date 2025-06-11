<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	
	$company_name=$_GET["company_name"];
	$from_date=$_GET["from_date"];
	$to_date=$_GET["to_date"];
	  
	 $sqlquery="SELECT c.date,c.amount,c.DESCRIPTION FROM credits_tbl c, customers_tbl Cr WHERE cr.customer_id=c.customer_id AND cr.COMPANY_NAME='".$company_name."' AND c.DATE>='".$from_date."' AND c.DATE<='".$to_date."'";
     $show=mysqli_query($dbhandle,$sqlquery);
	
		echo "<left><h3>For: M/s. $company_name </h3></left>";
		echo "<table style='width:80%'  align=center><center>";
		echo "<caption>From: $from_date        To: $to_date </caption>";
		echo "<tr>";
				echo "<th><center>date</center></th>";
				echo "<th><center>amount</center></th>";
				
				echo "<th><center>DESCRIPTION</center></th>";
				
				echo "</tr>";
	 while($row=mysqli_fetch_array($show)){
	    
		
		
		 
				echo "<tr>";
				echo "<td><center>".$row['date']."</center></td>";
				echo "<td><center>".$row['amount']."</center></td>";
				
				echo "<td><center>".$row['DESCRIPTION']."</center></td>";
				
				echo "</tr>";
				
		
		}
		
		
		echo "</center>	</table>";
		?>
		
	<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
	</style>