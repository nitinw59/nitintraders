<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
	
	
	
?>

  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Pushy - Off-Canvas Navigation Menu</title>
        <meta name="description" content="Pushy is an off-canvas navigation menu for your website.">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <link rel="stylesheet" href="<?=$nitinTraders?>/css/normalize.css">
        <link rel="stylesheet" href="<?=$nitinTraders?>/css/demo.css">
        <!-- Pushy CSS -->
        <link rel="stylesheet" href="<?=$nitinTraders?>/css/pushy.css">
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        
	<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
			
	<script type="text/javascript">
	
	
	
			$(document).ready(function() {
				
				

			
				
				$("#addpayment").click(function(){
					
					$("#paymentdetail").show();
					
					$("#bill_id_payment").html($("#MERCHANT_BILL_NUMBER").html());
					
					
				});
			
				$("#makepayment").click(function(){
					
					
					var bill_id=$("#BILL_NUMBER").html();
					var paymentdate=$("#paymentdate").val();
					var amount=$("#amount_payment").val();
					var remark=$("#remark_amount").val();
					
					
					$.ajax({
                        type:"post",
                        url:"newPaymentAction.php",
                        data:"bill_id="+bill_id+"&date="+paymentdate+"&amount="+amount+"&remark="+remark+"&action=addPayment",
                        success:function(data){
						
						if(data==1){
							alert("Payment Made Successfuly.");
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
    
	include($_SERVER['DOCUMENT_ROOT']."$nitinTraders/index.php");
	
	
	
	 $sqlquery="select B.BILL_ID,B.MERCHANT_BILL_NUMBER,B.DATE,B.AMOUNT AS AMOUNT,B.TAX_AMOUNT AS TAX,(B.AMOUNT+B.TAX_AMOUNT) AS TOTAL_AMOUNT , (SELECT SUM(AMOUNT) FROM merchant_payments_tbl WHERE BILL_ID=B.BILL_ID) AS TOTAL_PAYMENT FROM MERCHANT_BILLS_TBL B WHERE B.BILL_ID=".$_GET['BILL_ID'];;
     $show=mysqli_query($dbhandle,$sqlquery);
	
     while($row=mysqli_fetch_array($show)){
        $billdetail['BILL_NUMBER']=$row['BILL_ID'];
		$billdetail['MERCHANT_BILL_NUMBER']=$row['MERCHANT_BILL_NUMBER'];
		$billdetail['AMOUNT']=$row['AMOUNT'];
		$billdetail['DATE']=$row['DATE'];
		
		$billdetail['TAX']=$row['TAX'];
		$billdetail['TOTAL_AMOUNT']=$row['TOTAL_AMOUNT'];
		$billdetail['TOTAL_PAYMENT']=$row['TOTAL_PAYMENT'];
		if($billdetail['TOTAL_PAYMENT']==null)
			$billdetail['TOTAL_PAYMENT']=0;
		
		}
		
		$PENDING=$billdetail['TOTAL_AMOUNT']-$billdetail['TOTAL_PAYMENT'];
		
		$current_date=date('Y-m-d', time());
	?>
    
	
    
	<div class="paymentdetaildiv" id="paymentdetaildiv" >
	<label id="BILL_NUMBER" style="display:none;"><?=$billdetail['BILL_NUMBER']?></label>
	<table>
	<tr>
	<td width="50%">
	<div class="billdetails" id="billdetails" >
	
	<table>
	<tr><td>MERCHANT_BILL_NUMBER</td><td><label id="MERCHANT_BILL_NUMBER"><?=$billdetail['MERCHANT_BILL_NUMBER']?></label></td></tr>
	<tr><td>DATE </td><td><label id="DATE"><?=$billdetail['DATE']?></label></td></tr>
	
	<tr><td>AMOUNT </td><td><label id="AMOUNT"><?=$billdetail['AMOUNT']?></label></td></tr>
	<tr><td>TAX </td><td><label id="TAX"><?=$billdetail['TAX']?></label></td></tr>
	<tr><td>TOTAL_AMOUNT</td><td><label id="TOTAL_AMOUNT"><?=$billdetail['TOTAL_AMOUNT']?></label></td></tr>
	<tr><td>TOTAL_PAYMENT </td><td><label id="bill_total_amount"><?=$billdetail['TOTAL_PAYMENT']?></label></td></tr>
	<tr><td>PENDING </td><td><label id="TOTAL_PAYMENT"><?=$PENDING?></label></td></tr>
	
	<tr><td colspan="2"><center><button id="addpayment">Make Payment</button></center></td></tr>
	
	</table>
	
	</div>
     </td>	
		
		
	<td>	
	<div class="paymentdetail" id="paymentdetail" style="display:none;">
	
	<table>
	<tr><td>Bill Id </td><td><label id="bill_id_payment"></label></td></tr>
	<tr><td>DATE </td><td><input type="date" id="paymentdate" value="<?=$current_date?>"></td></tr>
	
	<tr><td>AMOUNT </td><td><input type="number" id="amount_payment" name="amount_payment" ></td></tr>
	<tr><td>Remark </td><td><input type="text" id="remark_amount" name="remark_amount" ></td></tr>
	<tr><td colspan="2"><center><button id="makepayment">Make Payment</button></center></td></tr>
	
	</table>
	
	</div>
	</td>	
		</table>
		</div>
	<script src="<?=$nitinTraders?>/js/pushy.min.js"></script>
		
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




