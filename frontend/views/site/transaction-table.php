<?php
$this->params['header_dark'] = true;
?>
<section>
    <div class="container">
        <table>
            <thead>
            <tr>
                <th width="15%">Reference Id</th>
                <th width="10%">Date</th>
                <th width="20%">Payer Name</th>
                <th width="35%">Quiz Name</th>
                <th width="10%">Amount</th>
                <th width="10%">Total Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>12354552</td>
                <td>22-09-2019</td>
                <td>Shshank Vasisht</td>
                <td>This is a quiz title</td>
                <td>1000</td>
                <td>1000</td>
            </tr>
            <tr>
                <td>12354552</td>
                <td>22-09-2019</td>
                <td>Ajay Juneja</td>
                <td>This is a quiz title byr bye</td>
                <td>1000</td>
                <td>2000</td>
            </tr>
            <tr>
                <td>12354552</td>
                <td>22-09-2019</td>
                <td>Nitesh Sharma</td>
                <td>This is a quiz title This is a quiz title</td>
                <td>500</td>
                <td>2500</td>
            </tr>
            <tr>
                <td>12354552</td>
                <td>22-09-2019</td>
                <td>Kulwinder Singh Sohal</td>
                <td>This is a quiz title</td>
                <td>3000</td>
                <td>5500</td>
                <td><a href=""></a></td>
            </tr>
            </tbody>
        </table>
    </div>
</section>
<?php
$this->registerCSS('
table { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #f7f7f7; 
}
th { 
  background: #eee; 
  color: #000; 
  font-weight: bold;
}
td, th { 
  padding: 10px; 
  border: 1px solid #DDD; 
  text-align: left; 
}
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/
	
	td:nth-of-type(1):before { content: "Reference ID"; }
	td:nth-of-type(2):before { content: "Date"; }
	td:nth-of-type(3):before { content: "Payer Name"; }
	td:nth-of-type(4):before { content: "Quiz Name"; }
	td:nth-of-type(5):before { content: "Amount"; }
	td:nth-of-type(6):before { content: "Total Amount"; }
}
')
?>
