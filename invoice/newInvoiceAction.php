<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	
   
  $action=$_POST["action"];
 
  if($action=="fetchcustomerdetail"){
	 $customercompanyname=$_POST["customercompanyname"];
	 $sqlquery="Select * from customers_tbl where COMPANY_NAME='".$customercompanyname."'";
     $show=mysqli_query($dbhandle,$sqlquery);
 
     while($row=mysqli_fetch_array($show)){
        $customerdetail['customer_id']=$row['customer_id'];
		$customerdetail['FNAME']=$row['FNAME'];
		$customerdetail['LNAME']=$row['LNAME'];
		$customerdetail['COMPANY_NAME']=$row['COMPANY_NAME'];
		$customerdetail['EMAIL']=$row['EMAIL'];
		$customerdetail['GSTTREATMENT']=$row['GSTTREATMENT'];
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
  }else if($action=="fetchItemDetails"){
    $brand=$_POST["brand"];
    $itemStyle=$_POST["itemStyle"];
    $size=$_POST["size"];
    $sqlquery="Select * from GENERALIZED_ITEMS where BRAND='$brand' and ITEM_STYLE='$itemStyle' and  SIZE='$size'";
	
	
	if($show=mysqli_query($dbhandle_stockmanager,$sqlquery)){
	while($row=mysqli_fetch_array($show)){
		
        
		
		$itemdetail['items_id']=$row['items_id'];
		$itemdetail['SELLING_PRICE']=$row['SELLING_PRICE'];
		$itemdetail['AVAIALABLE_QTY']=$row['AVAIALABLE_QTY'];
		
		
		echo json_encode($itemdetail);
     }
	 
	}
	 else{
		 echo "no data";
		 
  }
  }else if($action=="getBrandList"){
    
	$sql = "SELECT DISTINCT BRAND FROM GENERALIZED_ITEMS WHERE AVAIALABLE_QTY > 0 ";
	$brands = array();
	if($result = mysqli_query($dbhandle_stockmanager,$sql) ){
		$count=0;
		$brands[$count]="Select Item";
		$count++;
		while($row = mysqli_fetch_array($result)) {
		$brands[$count] = $row['BRAND'];
		$count++;
		}
	}
	echo json_encode($brands);
  
	}else if($action=="getStyleList"){
	$brand=$_POST["brand"];
	$sql = "SELECT DISTINCT ITEM_STYLE FROM GENERALIZED_ITEMS WHERE AVAIALABLE_QTY > 0 and brand = '$brand'";
	$styles = array();
	if($result = mysqli_query($dbhandle_stockmanager,$sql) ){
		$count=0;
		$styles[$count]="Select Item";
		$count++;
		while($row = mysqli_fetch_array($result)) {
		$styles[$count] = $row['ITEM_STYLE'];
		$count++;
		}
	}
	echo json_encode($styles);
  
}else if($action=="getSizeList"){
	$brand=$_POST["brand"];
	$style=$_POST["style"];
	$sql = "SELECT  SIZE  FROM GENERALIZED_ITEMS WHERE AVAIALABLE_QTY > 0 and brand = '$brand' and ITEM_STYLE = '$style'";
	$sizes = array();
	if($result = mysqli_query($dbhandle_stockmanager,$sql) ){
		$count=0;
		$sizes[$count]="Select Item";
		$count++;
		while($row = mysqli_fetch_array($result)) {
		$sizes[$count] = $row['SIZE'];
		$count++;
		}
	}
	echo json_encode($sizes);
  
}else if($action=="insertBill"){
    $customer_id=$_POST["customer_id"];
	$billdate=$_POST["billdate"];
	$duedate=$_POST["duedate"];
	$transportname=$_POST["transportname"];
	$transportparcels=$_POST["transportparcels"];
	
	
    $sqlquery="INSERT INTO BILLS_TBL (DATE,DUE_DATE,customer_id,total_amount,taxable_amount,transport_name,transport_parcels)VALUES ('".$billdate."','".$duedate."',".$customer_id.",0,0,'','')";                                                           
	
	$show=mysqli_query($dbhandle,$sqlquery);
	
				
	
	if($show==1){
		$show=mysqli_query($dbhandle,"select * from bills_tbl ORDER BY BILL_ID DESC;");
		$row=mysqli_fetch_array($show);
		
		$sqlquery="INSERT INTO TAX_DETAILS_TBL (BILL_ID,HSN,CGST_RATE,CGST,SGST_RATE,SGST,IGST_RATE,IGST) VALUES(".$row["BILL_ID"].",'HSN',2.5,0,2.5,0,5,0)";
		$show=mysqli_query($dbhandle,$sqlquery);
		
		$sqlquery="INSERT INTO transport_tbl (bill_id,DATE,transport_name,transport_parcels,LR)VALUES ('".$row["BILL_ID"]."','','".$transportname."',".$transportparcels.",'')";                                                           
	
		$show=mysqli_query($dbhandle,$sqlquery);
	
		
		
		echo $row["BILL_ID"];
		
	
	}else{
	
		echo "-1".$sqlquery;
	}
	
	
	
	
  }else if($action=="insertBillItems"){
    $bill_items_row=$_POST["itemsrow"];
	$bill_id=$_POST["bill_id"];
	
	$bill_items_row_array=explode("||||",$bill_items_row);
	for($i=0;$i< (sizeof($bill_items_row_array)-1);$i++){
			$bill_item_col_array=explode("||",$bill_items_row_array[$i]);
				
				$item_id=$bill_item_col_array[0];
				$item_quantity=$bill_item_col_array[2];
				$item_rate=$bill_item_col_array[3];
				$item_description=$bill_item_col_array[1];
				
				$sqlquery="INSERT INTO BILL_ITEMS_TBL (BILL_ID,ITEMS_ID,QUANTITY,RATE,description)
							 VALUES (".$bill_id.",".$item_id.",".$item_quantity.",".$item_rate.",'".$item_description."')";
				echo $sqlquery;
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
