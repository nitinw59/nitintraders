

 

	
	<?php
	$server_dir="/omenweb/";
	?>
   
	
	<!-- Pushy Menu -->
<nav class="pushy pushy-right">
    <div class="pushy-content">
        <ul>
            <!-- Submenu -->
            <li class="pushy-submenu">
                <button>Customers</button>
                <ul>
					<li class="pushy-link"><a href="<?=$server_dir?>customers/customerAdd.php">Customers Add</a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>customers/customerList.php">Customers List</a></li>
					
				</ul>
            </li>
			
			<li class="pushy-submenu">
                <button>Items</button>
                <ul>
					<li class="pushy-link"><a href="<?=$server_dir?>items/addItem.php">Items Add</a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>items/listItems.php">Items List</a></li>
					
				</ul>
            </li>
			
			<li class="pushy-submenu">
                <button>Invoice</button>
                <ul>
					<li class="pushy-link"><a href="<?=$server_dir?>invoice/newInvoice.php">New </a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>invoice/listInvoice.php">List Invoice</a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>invoice/deleteInvoice.php">Delete Invoice</a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>invoice/listCustomerInvoice.php">List Customer Invoice</a></li>
					
				</ul>
            </li>
			<li class="pushy-submenu">
                <button>Payments</button>
                <ul>
					<li class="pushy-link"><a href="<?=$server_dir?>payments/newPayment.php">Make Payment </a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>payments/listPayment.php">List </a></li>
					</ul>
            </li>
			<li class="pushy-submenu">
                <button>Supliers</button>
                <ul>
					<li class="pushy-link"><a href="<?=$server_dir?>fabric/merchants/AddMerchant.php">Add supplier </a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>fabric/merchants/MerchantList.php">List Supplier </a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>fabric/bills/newInvoice.php">New bill </a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>fabric/bills/listMerchantInvoice.php">List Bill </a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>fabric/payments/newPayment.php">Make Payment </a></li>
					<li class="pushy-link"><a href="<?=$server_dir?>fabric/payments/listPayment.php">List Payment </a></li>
					</ul>
            </li>
			
            
        </ul>
    </div>
</nav>

<!-- Site Overlay -->
<div class="site-overlay"></div>

<!-- Your Content -->
<div id="container">
    <!-- Menu Button -->
	<table><tr><td>
    <button class="menu-btn">&#9776; Menu</button></td><td width="95%"><font face="selfish" size="30px"><center>Omen</center></font></td></tr></table>
</div>

     
        

    


