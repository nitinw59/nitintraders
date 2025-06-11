<?php
  include($_SERVER['DOCUMENT_ROOT']."/omenweb/mysqlconnectdb.php");
 
   
  $action=$_POST["action"];
 
  if($action=="fetchcustomerdetail"){
	 $customercompanyname=$_POST["customercompanyname"];
	 $sqlquery="Select * from FABRIC_MERCHANTS_TBL where COMPANY_NAME='".$customercompanyname."'";
     $show=mysqli_query($dbhandle,$sqlquery);
 
     while($row=mysqli_fetch_array($show)){
        $customerdetail['FABRIC_MERCHANTS_ID']=$row['FABRIC_MERCHANTS_ID'];
		$customerdetail['FNAME']=$row['FNAME'];
		$customerdetail['LNAME']=$row['LNAME'];
		$customerdetail['COMPANY_NAME']=$row['COMPANY_NAME'];
		$customerdetail['EMAIL']=$row['EMAIL'];
		
		$customerdetail['GSTN']=$row['GSTN'];
		$customerdetail['ADDRESS']=$row['ADDRESS'];
		$customerdetail['CITY']=$row['CITY'];
		$customerdetail['STATE']=$row['STATE'];
		$customerdetail['ZIP']=$row['ZIP'];
		
		
		echo json_encode($customerdetail);
		
		
		
		
     }
  }
  else if($action=="getitemdetail"){
    $item_id=$_POST["item_id"];
    $sqlquery="Select items_id,DESCRIPTION,QUANTITY_RECEIVED,SIZE,RATE,TAX_RATE from items_tbl where items_id=".$item_id;
	$show=mysqli_query($dbhandle,$sqlquery);
	
	if($show=mysqli_query($dbhandle,$sqlquery)){
	while($row=mysqli_fetch_array($show)){
		
        
		$itemdetail['DESCRIPTION']=$row['DESCRIPTION'];
		$itemdetail['QUANTITY_RECEIVED']=$row['QUANTITY_RECEIVED'];
		$itemdetail['SIZE']=$row['SIZE'];
		$itemdetail['RATE']=$row['RATE'];
		$itemdetail['TAX_RATE']=$row['TAX_RATE'];
		
		echo json_encode($itemdetail);
     }
	}
	 else{
		 echo "no data";
		 
  }
  }else if($action=="insertBill"){
    $FABRIC_MERCHANTS_ID=$_POST["FABRIC_MERCHANTS_ID"];
	$billdate=$_POST["billdate"];
	$duedate=$_POST["duedate"];
	$merchant_bill_no=$_POST["merchant_bill_no"];
	$amount=$_POST["amount"];
	$tax=$_POST["tax"];
	$description=$_POST["description"];
	$meter=$_POST["meter"];
	$rate=$_POST["rate"];
	$to_maker=$_POST["to_maker"];
	
	
    $sqlquery="INSERT INTO MERCHANT_BILLS_TBL (MERCHANT_BILL_NUMBER,DATE,DUE_DATE,FABRIC_MERCHANTS_ID,amount,TAX_AMOUNT,description,meters,rate,to_maker)VALUES ($merchant_bill_no,'".$billdate."','".$duedate."',".$FABRIC_MERCHANTS_ID.",$amount,$tax,'".$description."','".$meter."','".$rate."','".$to_maker."')";                                                           
	
	$show=mysqli_query($dbhandle,$sqlquery);
	
				
	
	echo $show;
	
	
	
	
  }else if($action=="insertBillItems"){
    $bill_items_row=$_POST["itemsrow"];
	$bill_id=$_POST["bill_id"];
	
	$bill_items_row_array=explode("||||",$bill_items_row);
	for($i=0;$i< (sizeof($bill_items_row_array)-1);$i++){
			$bill_item_col_array=explode("||",$bill_items_row_array[$i]);
				
				$item_id=$bill_item_col_array[0];
				$item_quantity=$bill_item_col_array[1];
				$item_rate=$bill_item_col_array[2];
				
				$sqlquery="INSERT INTO BILL_ITEMS_TBL (BILL_ID,ITEMS_ID,QUANTITY,RATE) VALUES (".$bill_id.",".$item_id.",".$item_quantity.",".$item_rate.")";
				$show=mysqli_query($dbhandle,$sqlquery);
				echo $show;
				
				
	}
	
	
	
  }else if($action=="searchBillId"){
	$bill_id=$_POST["bill_id"];
	
	$sqlquery = "SELECT b.date,b.due_date,b.total_amount,c.fname,c.lname,c.company_name,c.mobile,c.gsttreatment,c.gstn,c.address,c.city,c.state,c.zip,c.mobile FROM bills_tbl b,customers_tbl c where b.customer_id=c.customer_id and bill_id='".$bill_id."' ORDER BY  bill_id DESC";
	
				
	$show=mysqli_query($dbhandle,$sqlquery);
	
	while($row=mysqli_fetch_array($show)){
        
	$COMPANY['NAME']=$row['company_name'];
	$COMPANY['ADDR']=$row['address'];
	$COMPANY['CITY']=$row['city'];
	$COMPANY['ZIP']=$row['zip'];
	$COMPANY['STATE']=$row['state'];
	$COMPANY['GSTTREATMENT']=$row['gsttreatment'];
	$COMPANY['GSTN']=$row['gstn'];
	$COMPANY['MOB']=$row['mobile'];
	
	$bill['COMPANY']=$COMPANY;
	$bill['date']=$row['date'];
	
	//$BILL_DATE['=$row['date'];
	//$BILL_DUE_DATE['=$row['due_date'];

	//	$TOTAL_AMOUNT=$row['total_amount'];
	
	$bill_items_list;
	$sqlquery="select  i.items_id,bi.quantity,bi.rate,i.description,I.SIZE,I.TAX_RATE  from bill_items_tbl bi,items_tbl i where bi.bill_id=".$BILL_ID." and bi.items_id=i.items_id;";
 
				
	$show=mysqli_query($dbhandle,$sqlquery);
	$rowcount=0;
	 while($row=mysqli_fetch_array($show)){
		$bill_item;
        
		$bill_item['items_id']=$row['items_id'];
		$bill_item['quantity']=$row['quantity'];
		$bill_item['rate']=$row['rate'];
		$bill_item['description']=$row['description'];
		$bill_item['SIZE']=$row['SIZE'];
		$bill_item['TAX_RATE']=$row['TAX_RATE'];
		
		$bill_items_list[$rowcount]=$bill_item;
     }
	
	$bill['bill_items_list']=$bill_items_list;
		
		echo json_encode($bill);
     }
	
	
	
  }
  
?>
