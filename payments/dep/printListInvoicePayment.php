<?php

	include($_SERVER['DOCUMENT_ROOT']."/omenweb/mysqlconnectdb.php");
 
	$bill_id=$_GET["bill_id"];
	
	  
	 $sqlquery="SELECT p.date,p.amount,p.DESCRIPTION,p.BILL_ID FROM payments_tbl P WHERE P.BILL_ID=$bill_id";
     $show=mysqli_query($dbhandle,$sqlquery);
	
		echo "<left><h3>For: Bill Id:  $bill_id </h3></left>";
		echo "<table style='width:80%'  align=center><center>";
		echo "<tr>";
				echo "<th><center>date</center></th>";
				echo "<th><center>amount</center></th>";
				echo "<th><center>BILL_ID</center></th>";
				
				echo "<th><center>DESCRIPTION</center></th>";
				
				echo "</tr>";
	 while($row=mysqli_fetch_array($show)){
	    
		
		
		 
				echo "<tr>";
				echo "<td><center>".$row['date']."</center></td>";
				echo "<td><center>".$row['amount']."</center></td>";
				echo "<td><center>".$row['BILL_ID']."</center></td>";
				
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