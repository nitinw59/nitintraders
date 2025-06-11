
<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/omenweb/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/omenweb/var.php");
	$sql = "SELECT COMPANY_NAME FROM customers_tbl";
	$customercompanynames = array();
	if($result = mysqli_query($dbhandle,$sql) ){
		$count=0;
		$customercompanynames[$count]="select";
		$count++;
		while($row = mysqli_fetch_array($result)) {
		$customercompanynames[$count] = $row['COMPANY_NAME'];
		$count++;
		}
		
		
	}
	
	
	
	?>
	
<?php
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
				
				

				var buyernameArray = <?php echo json_encode($customercompanynames); ?>;
				$("#buyername").select2({
				  data: buyernameArray
				});
				
				
				
				

				
				
				
				
				
				
				$("#buyername").change(function(){
					
                     var customercompanyname=$("#buyername").val();
					$("#billdetails").show();
					 
					 
                     $.ajax({
                        type:"post",
                        url:"newPaymentAction.php",
                        data:"customercompanyname="+customercompanyname+"&action=fetchcustomerdetail",
                        success:function(data){
							
							//alert(data);
							customerdetails = JSON.parse(data);
							
							$("#company_name").html("COMPANY NAME: "+customerdetails["COMPANY_NAME"]);
							$("#customername").html(" BUYER NAME: "+customerdetails["FNAME"] +" "+ customerdetails["LNAME"]);
							$("#address").html("ADDRESS : "+customerdetails["ADDRESS"]);
							$("#city").html("CITY : "+customerdetails["CITY"]);
							$("#state").html("STATE : "+customerdetails["STATE"]);
							$("#gsttreatment").html("GST TREATMENT: "+customerdetails["GSTTREATMENT"]);
							$("#gstn").html("GSTN: "+customerdetails["GSTN"]);
							$("#credits").html("Credits: "+customerdetails["credits"]);
										$.ajax({
												type:"post",
												url:"newPaymentAction.php",
												data:"customercompanyname="+customercompanyname+"&action=fetchpendingbilldetails",
												success:function(data){
															//alert(data);
															var total_amount=0;
															
															var bills_list = JSON.parse(data);
																$.each(bills_list, function( index, bill ) {
																		var markup= "<tr id="+bill["bill_id"]+"><td><center>"+bill["bill_id"]+"</center></td><td><center>"+bill["DATE"]+"</center></td><td><center>"+bill["TAX"]+"</center></td><td><center>"+bill["AMOUNT"]+"</center></td><td><center>"+(total_amount+bill["AMOUNT"]+bill["TAX"])+"</center></td><td><center><button class='viewbill' value="+bill["bill_id"]+"::"+(total_amount+bill["AMOUNT"]+bill["TAX"])+" >MAKE PAYMENT</button></center></td></tr>";
																		$("#bills_tbl").append(markup);
																});
													
				
							
							
												}
											});
							
							
							
                        }
                     });
				});

				
				
				
				$('#bills_tbl').on('click', '.viewbill', function(){
				
				
				var bill = $(this).val().split("::");
				
				
						if(customerdetails["credits"]>=bill[1]){
						
							$.ajax({
								type:"post",
								url:"newPaymentAction.php",
								data:"bill_id="+bill[0]+"&amount="+bill[1]+"&action=addPayment",
								success:function(data){
						
									if(data==1){
										alert("Payment Made Successfuly.");
										customerdetails["credits"]-=bill[1];
										$("#credits").html("Credits: "+customerdetails["credits"]);
										document.getElementById(bill[0]).style.display = 'none';
							
									}else{
										alert("Payment Failed.");
									}
										
								}
							});
						
							
						}
						else{
						
						alert("Payment Failed. Insufficient Credits");
							
						}							
				
				
				//window.open("showInvoice.php?bill_id="+$(this).val(),"_blank");
				
				});
				
				
				
				

				
				
				
			});
	</script>
	
	
	</head>



    <body>
	
	<?php
    
include($_SERVER['DOCUMENT_ROOT']."$server_root/index.php");
	?>
    
	<div class="buyerdetailst" id="buyerdetailst">
	
	<table>
	<tr>
	<td>
	<select id="buyername" style="width:300px;">
			<!-- Dropdown List Option -->
	</select>
	</td>
	<td>
	<label id="credits"> Credits  </label>
	</td>
	</tr>
	</table>
	<div class="buyerdetails" id="buyerdetails">
	<table>
	
	<tr> 
	<td><label id="company_name"> COMPANY NAME:  </label> </td>
	<td><label id="customername"> BUYER NAME:  </label> </td>
	</tr>
	
	<tr>
	<td rowspan=2><label id="address">  ADDRESS:  </label></td> 
	<td><label id="city">  CITY:  </label></td>
	</tr> 
	
	<tr>
	<td><label id="state">  STATE:  </label></td>
	</tr>
	
	<tr>
	<td><label id="gsttreatment">  GST TREATMENT:  </label></td> 
	<td><label id="gstn">  GSTN:  </label></td>
	</tr>	
	</table>
	
	</div>
	
	
	
	<select id="buyerbills" style="width:300px;">
			<!-- Dropdown List Option -->
	</select>
	
	</div>
    
	<div class="paymentdetaildiv" id="paymentdetaildiv" >
	
	<table>
	<tr>
	<td width="50%">
	<div class="billdetails" id="billdetails" style="display:none;">
	
	<table id="bills_tbl">
	<tr><th>Bill Id </th><th>DATE </th><th>TAX </th><th>AMOUNT </th><th>TOTAL </th><th>Make Payments </th></tr>
	
	</table>
	
	</div>
     </td>	
		
		
		
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






.companydetails {
  max-width: 800px;
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

.paymentdetaildiv{
	 max-width: 800px;
	margin: 10px auto;
	padding: 10px 20px;
	background: #e8e8df;
	border-radius: 8px;
}


.viewbill {
  background: #3498db;
  background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
  background-image: -moz-linear-gradient(top, #3498db, #2980b9);
  background-image: -ms-linear-gradient(top, #3498db, #2980b9);
  background-image: -o-linear-gradient(top, #3498db, #2980b9);
  background-image: linear-gradient(to bottom, #3498db, #2980b9);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  font-family: Arial;
  color: #ffffff;
  font-size: 20px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

.viewbill:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
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

#makepayment {
  background: #3498db;
  background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
  background-image: -moz-linear-gradient(top, #3498db, #2980b9);
  background-image: -ms-linear-gradient(top, #3498db, #2980b9);
  background-image: -o-linear-gradient(top, #3498db, #2980b9);
  background-image: linear-gradient(to bottom, #3498db, #2980b9);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  font-family: Arial;
  color: #ffffff;
  font-size: 20px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

#makepayment:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
}


#addpayment {
  background: #3498db;
  background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
  background-image: -moz-linear-gradient(top, #3498db, #2980b9);
  background-image: -ms-linear-gradient(top, #3498db, #2980b9);
  background-image: -o-linear-gradient(top, #3498db, #2980b9);
  background-image: linear-gradient(to bottom, #3498db, #2980b9);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  font-family: Arial;
  color: #ffffff;
  font-size: 20px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

#addpayment:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
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




