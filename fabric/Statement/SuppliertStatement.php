
<html>
<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
	
	
	$sql = "SELECT COMPANY_NAME FROM fabric_merchants_tbl";
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
	
	
	
	
	
	

  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Pushy is an off-canvas navigation menu for your website.">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <link rel="stylesheet" href="/<?=$nitinTraders?>/css/normalize.css">
        <link rel="stylesheet" href="/<?=$nitinTraders?>/css/demo.css">
        <!-- Pushy CSS -->
        <link rel="stylesheet" href="/<?=$nitinTraders?>/css/pushy.css">
        
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        
	<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
		
	<script type="text/javascript">
	

		$(document).ready(function() {
				
				var web_dir=<?php echo json_encode($nitinTraders); ?>;
					
				var buyernameArray = <?php echo json_encode($customercompanynames); ?>;
				$("#buyername").select2({
				  data: buyernameArray
				});
				
					$("#showBills").click(function(){
					
					var company_name=$("#buyername").val();
					var from_date=$("#from_date").val();
					var to_date=$("#to_date").val();
					var balance=0;
					
					$.ajax({
                        type:"post",
                        url:"SupplierStatementAction.php",
                        data:"company_name="+company_name+"&from_date="+from_date+"&to_date="+to_date+"&action=listSupplierStatement",
                        success:function(data){
						var counter=0;
						var credits=0;
						var old_balance=0;
						$("#listBills").show();
						
						
						var bills_list = JSON.parse(data);
						var i=0;
						$.each(bills_list, function( index, bill ) {
							
							if(bill["BILL AMOUNT"]==null){
								bill["BILL AMOUNT"]=0;
								bill["CGST"]=0;
								bill["SGST"]=0;
								bill["IGST"]=0;
							}
							if(bill["PAYMENT AMOUNT"]==null)
								bill["PAYMENT AMOUNT"]=0;
							
							if(i<=0){
								old_balance=bill["BILL AMOUNT"];
								balance=old_balance;
								credits=bill["PAYMENT AMOUNT"];
								var markup= "<tr><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center><span class='label1 warning'>"+old_balance+"</span></center></td></tr>";
							
								$("#bills_tbl").append(markup);
							
								i++;
							}
							else{
							//var markup= "<tr><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center>-</center></td><td><center><span class='label1 success'>cr"+credits+"</span></center></td></tr>";
							
							//$("#bills_tbl").append(markup);
							
							var total_amount=Math.round(Number(bill["BILL AMOUNT"])+Number(bill["CGST"])+Number(bill["SGST"])+Number(bill["IGST"]));
							
							balance=balance+total_amount- Number(bill["PAYMENT AMOUNT"]);
							
							i++;
							
							counter++;
							var markup;
							
							
							
							if(Number(bill["PAYMENT AMOUNT"])<Number(bill["BILL AMOUNT"])){
									markup= "<tr><td><center>"+bill["BILL ID"]+"</center></td><td><center>"+bill["DATE"]+"</center></td><td><center><a href='/"+web_dir+"/fabric/bills/scn/"+bill["loc"]+"'>invoice</a></center></td><td><center>"+bill["ITEM_QUANTITY"]+"</center></td><td><center>"+bill["ITEM_RATE"]+"</center></td><td><center>"+bill["BILL AMOUNT"]+"</center></td><td><center>"+bill["CGST"]+"</center></td><td><center>"+bill["SGST"]+"</center></td><td><center>"+bill["IGST"]+"</center></td><td><center>"+total_amount+"</center></td>"
											+"<td><center><input type='number'  style='border-color:red;' class='payment_enter' value='"+Number(bill["PAYMENT AMOUNT"])+"' id='"+bill["BILL ID"]+"'/></center></td>"
											+"<td><center>"+(0+total_amount- Number(bill["PAYMENT AMOUNT"]))+"</center></td><td><center>"+(balance)+"</center></td></tr>";
							}else{
									markup= "<tr><td><center>"+bill["BILL ID"]+"</center></td><td><center>"+bill["DATE"]+"</center></td><td><center><a href='/"+web_dir+"/fabric/bills/scn/"+bill["loc"]+"'>invoice</a></center></td><td><center>"+bill["ITEM_QUANTITY"]+"</center></td><td><center>"+bill["ITEM_RATE"]+"</center></td><td><center>"+bill["BILL AMOUNT"]+"</center></td><td><center>"+bill["CGST"]+"</center></td><td><center>"+bill["SGST"]+"</center></td><td><center>"+bill["IGST"]+"</center></td><td><center>"+total_amount+"</center></td>"
											+"<td><center><input type='number'  style='border-color:green;' class='payment_enter' value='"+Number(bill["PAYMENT AMOUNT"])+"' id='"+bill["BILL ID"]+"'/></center></td>"
											+"<td><center>"+(0+total_amount- Number(bill["PAYMENT AMOUNT"]))+"</center></td><td><center>"+(balance)+"</center></td></tr>";
								
							}
							$("#bills_tbl").append(markup);
							}
							
						});
						
						
						var markup= "<tr><td colspan='12'><center>-</center></td><td><center><span class='label1 success' id='availableCredits'>"+credits+"</span></center></td></tr>";
							
						$("#bills_tbl").append(markup);
							
						
						var markup= "<tr><td colspan='2'><center>Total Bills:"+counter+"</center></td><td><center></center></td><td colspan='7'><center>Total Balance till date: "+to_date+"</center></td><td><center></center></td><td><center></center></td><td><center><span class='label1 danger'>"+(balance-credits)+"</span></center></td></tr>"
						
						
						$("#bills_tbl").append(markup);
						 markup= "<tr><td></td><td></td><td></td><td></td><td ><center><button class='print'>Print</button></center></td></tr>"
						$("#bills_tbl").append(markup);
						
										
                        }
                    });
					
				});
			
				
					$('#bills_tbl').on('keyup', '.payment_enter', function(event){
					
					
					if(event.keyCode==13){
                     	//alert("eneterkeyup"+$(this).attr("id"));
                     	//alert("eneterkeyup"+$(this).val());
						var company_name=$("#buyername").val();
						var paymentamount=$(this).val();
						var billId=$(this).attr("id");
						
						var creditsAvailable=0;
						
						
									$.ajax({
										async: false,
										type:"post",
										url:"SupplierStatementAction.php",
										data:"company_name="+company_name+"&action=getSupplierCredits",
										success:function(data){
										creditsAvailable=Number(data);	
										},
										error: function (jqXHR, exception) {
											alert(jqXHR);
										}
									});
						
						if(creditsAvailable>=paymentamount){
						
									
									$.ajax({
										async: false,
										type:"post",
										url:"SupplierStatementAction.php",
										data:"billId="+billId+"&paymentamount="+paymentamount+"&action=makePayment",
										success:function(data){
										
										if(data==1)
											alert("Bill Paid.");
											//$("#availableCredits").html(creditsAvailable-paymentamount);
										},
										error: function (jqXHR, exception) {
											alert(jqXHR);
										}
									});
						
						
						
								$.ajax({
										async: false,
										type:"post",
										url:"SupplierStatementAction.php",
										data:"company_name="+company_name+"&action=getSupplierCredits",
										success:function(data){
										creditsAvailable=Number(data);	
										$("#availableCredits").html(creditsAvailable);
										$(this).css('background-color', 'blue');
										},
										error: function (jqXHR, exception) {
											alert(jqXHR);
										}
									});
						
						
						}else{
							alert("Insufficient Credits. ("+creditsAvailable+")");
						}


					
					}
					
					
					
				});
			
				
				
				
				
				$('#bills_tbl').on('click', '.print', function(){
				
					var company_name=$("#buyername").val();
					var from_date=$("#from_date").val();
					var to_date=$("#to_date").val();
					
					
				
				window.open("printSupplierStatement.php?"+"company_name="+company_name+"&from_date="+from_date+"&to_date="+to_date);
				
				});
				
				
				
				$('#bills_tbl').on('click', '.viewbill', function(){
				
				
				window.open("showInvoice.php?bill_id="+$(this).val(),"_blank");
				
				});
				
				
				$('#bills_tbl').on('click', '.viewpayment', function(){
				
				
				window.open("../payments/listInvoicePayment.php?bill_id="+$(this).val(),"_blank");
				
				});
				
				
				
				
			});
	</script>
	
	
	</head>
	
	<style>*, *:before, *:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}



.label1 {
  color: white;
  padding: 8px;
  font-family: Arial;
}
.success {background-color: #04AA6D;} /* Green */
.info {background-color: #2196F3;} /* Blue */
.warning {background-color: #ff9800;} /* Orange */
.danger {background-color: #f44336;} /* Red */ 
.other {background-color: #e7e7e7; color: black;} /* Gray */ 




.showBills {
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

.showBills:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
}

.viewpayment {
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

.viewpayment:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
}

.print{
	
	color: #FFF;
  background-color: #4bc970;
  font-size: 18px;
  text-align: center;
  font-style: normal;
  border-radius: 5px;
  width: 100%;
  border: 1px solid #3ac162;
  border-width: 1px 1px 3px;
  box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
  margin-bottom: 10px;
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

body {
  font-family: 'Nunito', sans-serif;
  color: #384047;
}


.listBills {
  max-width: 1150px;
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


.buyerdetailst {
  max-width: 1150px;
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
#invoicelist {
    width: 100%;
	height: 100%;
    overflow: scroll;
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

    <body>
	
	<?php 
	
include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/index.php");
	$current_date=date('Y-m-01', time());
	$current_due_date=date('Y-m-d', time());
	?>
    
	<div class="buyerdetailst" id="buyerdetailst">
	<center><h3>Supplier Statement</h3></center>
	
	
	<select id="buyername" style="width:300px;">
			<!-- Dropdown List Option -->
	</select>
	
	From Date: <input type="date" id="from_date" value="<?=$current_date?>" >
	To Date: <input type="date" id="to_date" value="<?=$current_due_date?>">
	
	&nbsp&nbsp&nbsp<button id="showBills" class="showBills" >Show</button>
	
	</div>
    <div class="listBills" id="listBills" style="display:none;">
	
	<table id="bills_tbl">
	<tr><th>BILL ID </th><th >******DATE****** </th><th>Loc</th><th>QUANTITY</th><th>RATE</th><th>AMOUNT</th><th>**CGST**</th><th>**SGST**</th><th>**IGST**</th><th>TOTAL AMOUNT </th><th>PAYMENT </th><th>PENDING </th><th>BALANCE </th></tr>
	
	</table>
	
	</div>	
	
	
	
	
			<script src="/<?=$nitinTraders?>/js/pushy.min.js"></script>
			
    </body>


</html>

