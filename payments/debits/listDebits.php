
<html>

<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/index.php");
			
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
        <title>Pushy - Off-Canvas Navigation Menu</title>
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
				
				$("#showPayments").click(function(){
					
					
					var company_name=$("#buyername").val();
					var from_date=$("#from_date").val();
					var to_date=$("#to_date").val();
					
					
					
					$.ajax({
                        type:"post",
                        url:"listDebitsAction.php",
                        data:"company_name="+company_name+"&from_date="+from_date+"&to_date="+to_date+"&action=listPayment",
                        success:function(data){
						
						$("#paymentdetail").show();
						var payments_list = JSON.parse(data);
						$.each(payments_list, function( index, payment ) {
							var markup= "<tr id='"+payment["debit_id"]+"'><td><center>"+payment["date"]+"</center></td><td><center>"+payment["amount"]+"</center></td><td><center>"+payment["DESCRIPTION"]+"</center></td><td><center><button class='delete' value='"+payment["debit_id"]+"'>delete</button></center></td></tr>"
							
							
							$("#payments_tbl").append(markup);
						});
										
                        }
                    });
					
				});
				
				
				$('#payments_tbl').on('click', '.print', function(){
				
					var company_name=$("#buyername").val();
					var from_date=$("#from_date").val();
					var to_date=$("#to_date").val();
					
					
				
				window.open("printListPayment.php?"+"company_name="+company_name+"&from_date="+from_date+"&to_date="+to_date);
				
				});
				
				
				
				$('#payments_tbl').on('click', '.delete', function(){
				if (confirm("You really want to delete? ask nitin!")){
					var debit_id=$(this).val();
						$.ajax({
                        type:"post",
                        url:"listDebitsAction.php",
                        data:"debit_id="+debit_id+"&action=deletePayment",
                        success:function(data)
						{
							
							try{
								
							if(Number(data)==1){
							$('#'+debit_id).remove();	
							alert ("Deleted Successfuly.");
							
							}else{
								
							alert("Failed To Delete");
							}
							}catch(e){
							$("#item_availability").html("call nitin: Item not available");
							
							}
										
                        }
                    });
					
				
				}
				
				
				
				});
				
				
				
				
				
				
				
			});
	</script>
	
	
	</head>
	
	

    <body>
	
	<?php
    
		
		$current_date=date('2017-07-01', time());
		$current_due_date=date('Y-m-t', time());
	
	?>
    <center><h3>List Debits</h3></center>
	<div class="buyerdetailst" id="buyerdetailst">
	
	<table><tr>
	<td>
	<select id="buyername" style="width:300px;">
			<!-- Dropdown List Option -->
	</select>
	</td>
	<td>
	From Date: <input type="date" id="from_date" value="<?=$current_date?>" >
	</td>
	<td>
	To Date: <input type="date" id="to_date" value="<?=$current_due_date?>">
	</td>
	</tr>
	<tr>
	<td></td><td></td>
	<td >
	<button id="showPayments">Show</button>
	
	</td>
	</tr>
	</table>
	</div>
    <div class="paymentdetail" id="paymentdetail" style="display:none;">
	
	<table id="payments_tbl">
	<tr><th>DATE </th><th>AMOUNT </th><th>Remark </th><th>Bill Id </th></tr>
	
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

.paymentdetail {
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

