
<html>

<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/omenweb/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/omenweb/var.php");
	
	
	
	
$server_root="/omenweb";

?>

  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Pushy - Off-Canvas Navigation Menu</title>
        <meta name="description" content="Pushy is an off-canvas navigation menu for your website.">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <link rel="stylesheet" href="<?=$server_root?>/css/normalize.css">
        <link rel="stylesheet" href="<?=$server_root?>/css/demo.css">
        <!-- Pushy CSS -->
        <link rel="stylesheet" href="<?=$server_root?>/css/pushy.css">
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        
	<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
		
	
	
			
	<script type="text/javascript">
	

		$(document).ready(function() {
				
				
				$('#payments_tbl').on('click', '.print', function(){
				
				window.open("printListInvoicePayment.php?"+"bill_id="+$(this).val());
				
				});
				
				
				
				
				
			});
	</script>
	</head>
	
	

    <body>
	
	<?php
    
include($_SERVER['DOCUMENT_ROOT']."$server_root/index.php");
	?>
	
    <div class="paymentdetail" id="paymentdetail" >
	
	<table id="payments_tbl">
	<tr><th>DATE </th><th>AMOUNT </th><th>Remark </th><th>Bill Id </th></tr>
	<?php
	
	
	$bill_id=$_GET["bill_id"];
	  
	$sqlquery="SELECT p.date,p.amount,p.DESCRIPTION,p.BILL_ID FROM payments_tbl P where P.BILL_ID=".$bill_id;;
    
	
	$show=mysqli_query($dbhandle,$sqlquery);
 
	  while($row=mysqli_fetch_array($show)){
		
        $payment['date']=$row['date'];
		$payment['amount']=$row['amount'];
		$payment['DESCRIPTION']=$row['DESCRIPTION'];
		$payment['BILL_ID']=$row['BILL_ID'];
		
		echo "<tr><td><center>".$row['date']."</center></td><td><center>".$row['amount']."</center></td><td><center>".$row['DESCRIPTION']."</center></td><td><center>".$row['BILL_ID']."</center></td></tr>";
						
		}
		
	
	echo  "<tr><td></td><td></td><td></td><td ><center><button class='print' value='$bill_id'>Print</button></center></td></tr>";
							
		
	
	
	
							
	?>
	</table>
	
	</div>	
	
	
	<script src="<?=$server_root?>/js/pushy.min.js"></script>
	
	
    </body>
	
	<style>
	*, *:before, *:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  font-family: 'Nunito', sans-serif;
  color: #384047;
}

form {
  max-width: 300px;
  margin: 10px auto;
  padding: 10px 20px;
  background: #f4f7f8;
  border-radius: 8px;
}

.paymentdetail {
  max-width: 850px;
  margin: 10px auto;
  padding: 10px 20px;
  background: #e8e8df;
  border-radius: 8px;
}

input[type="text"],

{
border: 2px solid rgb(173, 204, 204);
height: 31px;
width: 223px;
box-shadow: 0px 0px 27px rgb(204, 204, 204) inset;
transition:500ms all ease;
padding:3px 3px 3px 3px;
}


.buyerdetails {
  max-width: 800px;
  margin: 10px auto;
  padding: 10px 20px;
  background: #e8e8df;
  border-radius: 8px;
}
.buyerdetailst {
  max-width: 800px;
  margin: 10px auto;
  padding: 10px 20px;
  background: #e8e8df;
  border-radius: 8px;
}
.ItemsDetails {
  max-width: 800px;
  margin: 10px auto;
  padding: 10px 20px;
  background: #e8e8df;
  border-radius: 8px;
}

.TaxDetail{
	 max-width: 800px;
	margin: 10px auto;
	padding: 10px 20px;
	background: #e8e8df;
	border-radius: 8px;
}



h1 {
  margin: 0 0 30px 0;
  text-align: center;
}


input[type="radio"],
input[type="checkbox"] {
  margin: 0 4px 8px 0;
}

select {
  padding: 6px;
  height: 32px;
  border-radius: 2px;
}

button {
  
  color: #FFF;
  background-color: #4bc970;
  font-size: 18px;
  text-align: center;
  font-style: normal;
  border-radius: 5px;
  width: 30%;
  border: 1px solid #3ac162;
  border-width: 1px 1px 3px;
  box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
  margin-bottom: 10px;
}

fieldset {
  margin-bottom: 30px;
  border: none;
}

legend {
  font-size: 1.4em;
  margin-bottom: 10px;
}

label {
  display: block;
  margin-bottom: 8px;
}

label.light {
  font-weight: 300;
  display: inline;
}

.number {
  background-color: #5fcf80;
  color: #fff;
  height: 30px;
  width: 20px;
  display: inline-block;
  font-size: 0.8em;
  margin-right: 4px;
  line-height: 30px;
  text-align: center;
  text-shadow: 0 1px 0 rgba(255,255,255,0.2);
  border-radius: 100%;
}

table {
    border-collapse: collapse;
    width: 100%;
}

td {
    text-align: left;
    padding: 8px;
}

th {
    background-color: #4CAF50;
    color: white;
}



tr:nth-child(even){background-color: #f2f2f2}


@media screen and (min-width: 480px) {

  form {
    max-width: 480px;
  }

}

	</style>
</html>

