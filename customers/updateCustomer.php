<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");


?>

  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Update Customer</title>
        <meta name="description" content="Pushy is an off-canvas navigation menu for your website.">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <link rel="stylesheet" href="/<?=$nitinTraders?>/css/normalize.css">
        <link rel="stylesheet" href="/<?=$nitinTraders?>/css/demo.css">
        <!-- Pushy CSS -->
        <link rel="stylesheet" href="/<?=$nitinTraders?>/css/pushy.css">
        <link rel="stylesheet" href="/<?=$nitinTraders?>/css/global.css">
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    
		</head>

    <script>
        $(document).ready(function(){
			$("#GSTTREATMENT").on("change",function(){
        
			var gsttreatment=$("#GSTTREATMENT").val();

			
			if(gsttreatment=="REGISTERED"){
			$("#GSTNLABEL").show();
			$("#GSTNT").show();
			}else{
			$("#GSTNLABEL").hide();
			$("#GSTNT").hide();
			}

		});
		});
        </script>
	
    <body>
	
	<?php
		include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/index.php");

    
    $COMPANY_NAME= $_GET["COMPANY_NAME"];
    $sql = "SELECT * FROM customers_tbl where COMPANY_NAME='$COMPANY_NAME'";
    if($result=mysqli_query($dbhandle,$sql)){

      $row = mysqli_fetch_array($result);
     
      $customer_id=$row['customer_id'];
      $fname=$row['FNAME'];
      $lname=$row['LNAME'];
      $company_name=$row['COMPANY_NAME'];
      $email=$row['EMAIL'];
      $mobile=$row['MOBILE'];
      $address=$row['ADDRESS'];
      $city=$row['CITY'];
      $state=$row['STATE'];
      $zip=$row['ZIP'];
      $GSTN=$row['GSTN'];
      $GSTTREATMENTdb=$row['GSTTREATMENT'];
      }



	?>
      <form action="updateCustomerSubmit.php" enctype="multipart/form-data" method="post">
      



        <h1>Update Customer</h1>
        
        <fieldset>
          <legend><span class="number">1</span>Basic info</legend>
          
          <label for="name">First Name:</label>
          <input type="text" id="Fname" name="Fname" value="<?=$fname?>" required>
		  
			<label for="name">Last Name:</label>
			<input type="text" id="Lname" name="Lname"  value="<?=$lname?>" required>
			
			<label for="name">Company Name:</label>
			<input type="text" id="companyname" name="companyname"  value="<?=$company_name?>" required>
			<input type="text" id="oldcompanyname" name="oldcompanyname"  value="<?=$company_name?>" hidden>

		  
		  
		  
        </fieldset>
        
        <fieldset>
          <legend><span class="number">2</span>Contact Details</legend>

			<label for="mail">Address </label>
			<input type="text" id="address" name="address"  value="<?=$address?>" required>	          
			
			<label for="mail">City </label>
			<input type="text" id="city" name="city"  value="<?=$city?>" required>	          
          
	
	
    

	<label for="mail">State</label>
		
		
	<?php
	echo "<td><select name='state' required>" ;
	
		for($i=0;$i<count($states);$i++){ 
        if($states[$i][0]==$state)
				echo "<option value='".$states[$i][0]."'  selected >".$states[$i][0]."</option>";
				else
				echo "<option value='".$states[$i][0]."'  >".$states[$i][0]."</option>";

				}
				echo "</select></td>";

	?>
	
			<label for="mail">Zip </label>
			<input type="text" id="zip" name="zip"   value="<?=$zip?>" required>	          
          
			<label for="mail">Mobile No: </label>
			<input type="text" id="mobile" name="mobile"   value="<?=$mobile?>" required>
			<label for="mail">Email </label>
			<input type="text" id="email" name="email"   value="<?=$email?>" >
        </fieldset>


        <fieldset>
		<legend><span class="number">3</span>GST Details</legend>
		<label for="mail">GST Treatment</label>
	    <td><select name='GSTTREATMENT' id='GSTTREATMENT' required>
	    <?php
		for($i=0;$i<count($GSTTREATMENT);$i++){ 
                if($GSTTREATMENTdb==$GSTTREATMENT[$i])
				echo "<option value='".$GSTTREATMENT[$i]."'  selected >".$GSTTREATMENT[$i]."</option>";
				else
                echo "<option value='".$GSTTREATMENT[$i]."'   >".$GSTTREATMENT[$i]."</option>";
				

                }
				echo "</select></td>";
                
                if($GSTTREATMENTdb=="REGISTERED"){
			    echo "<label id='GSTNLABEL' >GST NUMBER </label>";
			    echo "<input type='text' id='GSTNT' name='GSTNT'  value='<?=$GSTN?>'>";	
                }else{
                    echo "<label id='GSTNLABEL' style='display:none;'>GST NUMBER </label>";
			        echo "<input type='text' id='GSTNT' name='GSTNT' style='display:none;' value='' ";	
                }
        
        ?>
        </fieldset>



        <button type="submit" id="addcustomer">UPDATE Customer</button>
      </form>
      



	<!-- Pushy JS -->
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

h1 {
  margin: 0 0 30px 0;
  text-align: center;
}

input[type="text"],
input[type="password"],
input[type="date"],
input[type="datetime"],
input[type="email"],
input[type="number"],
input[type="search"],
input[type="tel"],
input[type="time"],
input[type="url"],
textarea,
select {
  background: rgba(255,255,255,0.1);
  border: none;
  font-size: 16px;
  height: auto;
  margin: 0;
  outline: 0;
  padding: 15px;
  width: 100%;
  background-color: #e8eeef;
  color: #8a97a0;
  box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
  margin-bottom: 30px;
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
  padding: 19px 39px 18px 39px;
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
  width: 30px;
  display: inline-block;
  font-size: 0.8em;
  margin-right: 4px;
  line-height: 30px;
  text-align: center;
  text-shadow: 0 1px 0 rgba(255,255,255,0.2);
  border-radius: 100%;
}

@media screen and (min-width: 480px) {

  form {
    max-width: 480px;
  }

}

	</style>

</html>




