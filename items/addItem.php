<?php
include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	
	include($_SERVER['DOCUMENT_ROOT']."/$omenNX/mysqlconnectdb.php");
	include($_SERVER['DOCUMENT_ROOT']."/$omenNX/var.php");
	include($_SERVER['DOCUMENT_ROOT']."/$omenNX/index.php");
	

?>

  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Pushy - Off-Canvas Navigation Menu</title>
        <meta name="description" content="Pushy is an off-canvas navigation menu for your website.">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <link rel="stylesheet" href="/<?=$omenNX?>/css/normalize.css">
        <link rel="stylesheet" href="/<?=$omenNX?>/css/demo.css">
        <!-- Pushy CSS -->
        <link rel="stylesheet" href="/<?=$omenNX?>/css/pushy.css">
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    
		<script>
		$(document).ready(function(){
			$("#GSTTREATMENT").on("change",function(){
        
			var gsttreatment=$("#GSTTREATMENT").val();

			
			if(gsttreatment=="REGISTERED"){
			$("#GSTNLABEL").show();
			$("#GSTN").show();
			}else{
			$("#GSTNLABEL").hide();
			$("#GSTN").hide();
			}

		});
		
		
		$("#btnSubmit").click(function(){
        
    });
		
		
		});
</script>
   </head>


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

    <body>
	  <form action="addItemSubmit.php" enctype="multipart/form-data" method="post">
      



        <h1>Labels Data</h1>
        
       
		
		
		
		
		
			<label for="mail">Fit</label>
		
		
	
	<td><select name='Ftype' id='Ftype' required>
	
	<?php
		for($i=0;$i<count($type);$i++){ 
				echo "<option value='".$type[$i]."'  selected >".$type[$i]."</option>";
					
				}
				echo "</select></td>";

	?>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		<label for="mail">Style</label>
		
		
	
	<td><select name='Fstyle' id='Fstyle' required>
	
	<?php
		for($i=0;$i<count($style);$i++){ 
				echo "<option value='".$style[$i]."'  selected >".$style[$i]."</option>";
					
				}
				echo "</select></td>";

	?>
	
	
	
	
	
	
	
		<label for="mail">Maker</label>
		
		
	
	<td><select name='Fmaker' id='Fmaker' required>
	
	<?php
		for($i=0;$i<count($maker);$i++){ 
				echo "<option value='".$maker[$i]."'  selected >".$maker[$i]."</option>";
					
				}
				echo "</select></td>";

	?>
	
	
	
	<label for="mail">Lot Id :  <input type="text" id="lotID" name="lotID" value="0" required></label>
			
	
	
	
	<label for="mail">22 :  <input type="text" id="size22" name="size22" value="0" required></label>
	
	<label for="mail">24 :  <input type="text" id="size24" name="size24" value="0" required></label>
	
	<label for="mail">26 :  <input type="text" id="size26" name="size26" value="0" required></label>
	
	<label for="mail">28 :  <input type="text" id="size28" name="size28" value="0" required></label>
			
	
	
	<label for="mail">30 :  <input type="text" id="size30" name="size30" value="0" required></label>
			
	
	
	<label for="mail">32 :  <input type="text" id="size32" name="size32" value="0" required></label>
			
	
	
	<label for="mail">34 :  <input type="text" id="size34" name="size34" value="0" required></label>
			
	
	
	<label for="mail">36 :  <input type="text" id="size36" name="size36" value="0" required></label>
			
	
	
	<label for="mail">38 :  <input type="text" id="size38" name="size38" value="0" required></label>
			
	
	
	<label for="mail">40 :  <input type="text" id="size40" name="size40" value="0" required></label>
			
	
	
	<label for="mail">42 :  <input type="text" id="size42" name="size42" value="0" required></label>
			
	
	
	<label for="mail">44 :  <input type="text" id="size44" name="size44" value="0" required></label>
	
	
	
	<label for="mail">46 :  <input type="text" id="size46" name="size46" value="0" required></label>
	
	
	
	<label for="mail">Rate</label>
    <input type="number" id="rate" name="rate" value=-1 required>
	</fieldset>
    
    <fieldset>

        <label for="job">File :</label>
    <input name="uploadedimage" type="file" value=null required>
	
   
   
	
	
	
	</fieldset>


        <button id="btnSubmit" type="submit">Generate</button>
      </form>
      



	<!-- Pushy JS -->
        <script src="/<?=$omenNX?>/js/pushy.min.js"></script>


    </body>
</html>




