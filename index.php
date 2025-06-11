
<?php
	include($_SERVER['DOCUMENT_ROOT']."/htaccess.php");
	include($_SERVER['DOCUMENT_ROOT']."/$nitinTraders/var.php");
	
	
	
	
	?>



<style>
body {
  background-color: #ADDBED;
}
</style>
<title>
 <?php echo $title; ?>

</title>

	
   
	
	<!-- Pushy Menu -->
<nav class="pushy pushy-left">
    <div class="pushy-content">
        <ul>
            <!-- Submenu -->
            <li class="pushy-submenu">
                <button>Customers</button>
                <ul>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/customers/customerAdd.php">Customers Add</a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/customers/customerList.php">Customers List</a></li>
					
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/customers/CustomerStatement.php">Customers Statment</a></li>
					
				</ul>
            </li>
			
			<li class="pushy-submenu">
                <button>Items</button>
                <ul>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/items/addItem.php">Items Add</a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/items/listItems.php">Items List</a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/items/ItemHistory.php">Items History</a></li>
					
				</ul>
            </li>
			
			<li class="pushy-submenu">
                <button>Invoice</button>
                <ul>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/invoice/newInvoice.php">New </a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/invoice/listInvoice.php">List Invoice</a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/invoice/listAllInvoice.php">Monthly Invoice</a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/invoice/deleteInvoice.php">Delete Invoice</a></li>
					
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/invoice/addTransportDetails.php">Add Transport Details</a></li>
					
				</ul>
            </li>
			<li class="pushy-submenu">
                <button>Payments</button>
                <ul>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/payments/newCredits.php">newCredits </a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/fabric/payments/newCredits.php">New Debit </a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/payments/listPayment.php">List credits </a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/payments/listDebits.php">List Debits</a></li>
					
					</ul>
            </li>
			<li class="pushy-submenu">
                <button>Supliers</button>
                <ul>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/fabric/bills/newInvoice.php">New bill </a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/fabric/Statement/listAllInvoice.php">Monthly Bill </a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/fabric/Statement/SuppliertStatement.php">Statement </a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/fabric/merchants/AddMerchant.php">Add supplier </a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/fabric/merchants/MerchantList.php">List Supplier </a></li>
					</ul>
            </li>
			<li class="pushy-submenu">
                <button>Cash Ledger</button>
                <ul>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/cashLegder/newCashTransaction.php">New Cash </a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/cashLegder/listCashTransaction.php">List Cash </a></li>
				</ul>
            </li>
			<li class="pushy-submenu">
                <button>Backup</button>
                <ul>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/Backup/backup.php">create new Backup </a></li>
				</ul>
            </li>
			<li class="pushy-submenu">
                <button>Report</button>
                <ul>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/report/monthsales.php">Sales Report </a></li>
					<li class="pushy-link"><a href="/<?=$nitinTraders?>/report/monthpurchase.php">Purchase Report </a></li>
					
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
    <button class="menu-btn">&#9776; Menu</button></td><td width="95%"><font face="serief" size="30px"><center>Nitin Traders</center></font></td></tr></table>
</div>

     
        

    


