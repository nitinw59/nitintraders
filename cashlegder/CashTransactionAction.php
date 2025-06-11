<?php
  include($_SERVER['DOCUMENT_ROOT']."/omenweb/mysqlconnectdb.php");
 
   
  $action=$_POST["action"];
	if($action=="addCashPayment"){
	 
	 $trans_date=$_POST["trans_date"];
	 $trans_amount=$_POST["trans_amount"];
	 $trans_description=$_POST["trans_description"];
	 
	 $sqlquery="INSERT INTO cash_legder (DATE,AMOUNT,DESCRIPTION,TYPE) VALUES('".$trans_date."',".$trans_amount.",'".$trans_description."','OUT')";
     $show=mysqli_query($dbhandle,$sqlquery);
 
    echo $show;
  }else if($action=="listCashTransaction"){
	
	$from_date=$_POST["from_date"];
	$to_date=$_POST["to_date"];
	  
	 $sqlquery="SELECT cash_legder_id,DATE,AMOUNT,DESCRIPTION,TYPE FROM cash_legder WHERE DATE>='".$from_date."' AND DATE<='".$to_date."'";
     $show=mysqli_query($dbhandle,$sqlquery);
	
	$cash_list;
	$row_count=0;
     while($row=mysqli_fetch_array($show)){
		$cash_trans;
        $cash_trans['cash_legder_id']=$row['cash_legder_id'];
		$cash_trans['DATE']=$row['DATE'];
		$cash_trans['AMOUNT']=$row['AMOUNT'];
		$cash_trans['DESCRIPTION']=$row['DESCRIPTION'];
		$cash_trans['TYPE']=$row['TYPE'];
		
		$cash_list[$row_count]=$cash_trans;
		$row_count++;
		}
		
		
		echo json_encode($cash_list);
		
  }else if($action=="updateCashPayment"){
	 
	 $cash_ledger_id=$_POST["cash_ledger_id"];
	 $trans_date=$_POST["trans_date"];
	 $trans_amount=$_POST["trans_amount"];
	 $trans_description=$_POST["trans_description"];
	 
	 $sqlquery="UPDATE cash_legder SET DATE='".$trans_date."' ,AMOUNT=".$trans_amount." ,DESCRIPTION='".$trans_description."' ,TYPE='OUT' WHERE cash_legder_id=".$cash_ledger_id;
     $show=mysqli_query($dbhandle,$sqlquery);
 
    echo $show;
  }
  
?>
