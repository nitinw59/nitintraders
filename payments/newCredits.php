
<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
	
	
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


  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Pushy is an off-canvas navigation menu for your website.">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <link rel="stylesheet" href="/<?=$nitinTraders?>/css/normalize.css">
        <link rel="stylesheet" href="/<?=$nitinTraders?>/css/demo.css">
        <!-- Pushy CSS -->
        <link rel="stylesheet" href="/<?=$nitinTraders?>/css/pushy.css">
        
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
						$("#paymentdetail").show();
					
					 
					 
                     $.ajax({
                        type:"post",
                        url:"newCreditsAction.php",
                        data:"customercompanyname="+customercompanyname+"&action=fetchcustomerdetail",
                        success:function(data){
							customerdetails = JSON.parse(data);
							
                        }
                     });
				});

				
				
				
				
				$("#makepayment").click(function(){
					
					
					var paymentdate=$("#paymentdate").val();
					var amount=$("#amount_payment").val();
					var remark=$("#remark_amount").val();
					
					
					$.ajax({
                        type:"post",
                        url:"newCreditsAction.php",
                        data:"customer_id="+customerdetails["customer_id"]+"&date="+paymentdate+"&amount="+amount+"&remark="+remark+"&action=addCredits",
                        success:function(data){
						//alert(data);
						var status = JSON.parse(data);
						
						if(status["STATUS"]==1){
							alert("Credits Made Successfuly.\n customer_id="+customerdetails["COMPANY_NAME"]+"\ndate="+paymentdate+"\namount="+amount+"\nwords="+status["AmountInwords"]+"\nremark="+remark);
							
							location.reload();
						}else{
							alert("Payment Failed.");
						}
										
                        }
                    });
					
				});
				
				

				
				
				
			});
	</script>
	
	
	</head>



    <body>
	
	<?php
    
include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/index.php");
$current_date=date('Y-m-d', time());
	?>
    <div class="buyerdetailst" id="buyerdetailst">
	<center><h3>New Credits</h3></center>
	
	
	<center><select id="buyername" style="width:300px;">
			<!-- Dropdown List Option -->
	</select>
	
	</center>
	
	
	
	</div>
    
	<div class="paymentdetaildiv" id="paymentdetaildiv" >
	
	<table>
	<tr>
		
		
		
	<td>	
	<div class="paymentdetail" id="paymentdetail" style="display:none;">
	
	<table>
	<tr><td>DATE </td><td><input type="date" id="paymentdate" value="<?=$current_date?>"  ></td></tr>
	
	<tr><td>AMOUNT </td><td><input type="number" id="amount_payment" name="amount_payment" ></td></tr>
	<tr><td>Remark </td><td><input type="text" id="remark_amount" name="remark_amount" ></td></tr>
	<tr><td colspan="2"><center><button id="makepayment">Make Payment</button></center></td></tr>
	
	</table>
	
	</div>
	</td>	
		</table>
		</div>
	<script src="/<?=$nitinTraders?>/js/pushy.min.js"></script>
		
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




