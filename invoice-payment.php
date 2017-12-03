<?php
session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PayMe Invoice</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <style>
    
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title" colspan="2">
                                <img style="width:30%" src="http://52.220.44.181/~izzad/ServerSidePayMe/logo.png" style="width:100%; max-width:300px;">
                            </td>
                        </tr>
                        <tr>
                        <td style="text-align:left">
                        <strong>From</strong> <br />
                        Name : Izzad<br />
                        Company : PayMe Sdn Bhd<br />
                        Address : Universiti Teknologi PETRONAS,<br />32610 Seri Iskandar,<br />Perak Darul Ridzuan, Malaysia 
                        </td>
                        <td style="text-align:left">
                        <strong>To</strong> <br />
                        Name : Izzad<br />
                        Company : PayMe Sdn Bhd<br />
                        Address : Universiti Teknologi PETRONAS,<br />32610 Seri Iskandar,<br />Perak Darul Ridzuan, Malaysia 
                        </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>
                    Item
                </td>
                
                <td>
                    Quantity
                </td>

                <td>
                    Price
                </td>

                <td>
                    Total Price
                </td>

            </tr>
<?php

// Define database connection parameters
$hn      = 'localhost';
$un      = 'izzad_izzad';
$pwd     = 'izzad123';
$db      = 'izzad_izzad';
$cs      = 'utf8';


$par_invoice_id = $_GET['invoice_id'];
$_SESSION["invoice_id"] = $par_invoice_id;

$dsn  = "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
$opt  = array(
                     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                     PDO::ATTR_EMULATE_PREPARES   => false,
                    );
// Create a PDO instance (connect to the database)
$pdo  = new PDO($dsn, $un, $pwd, $opt);
$data = array();

// Create connection
$conn = new mysqli($hn, $un, $pwd, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = 'SELECT items.foreign_invoice_number, items.item_name, items.item_quantity, items.item_price, invoice.invoice_date, invoice.invoice_id FROM items INNER JOIN invoice ON items.foreign_invoice_number=invoice.invoice_number WHERE invoice.invoice_id='.$par_invoice_id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $grand_total = 0;
    $item_list = array();
    while($row = $result->fetch_assoc()) {
        array_push($item_list, $row);
        $qty = $row["item_quantity"];
        $price = number_format((float)$row["item_price"], 2, '.', '');
        $total_price = $qty * $price;
        $grand_total = $grand_total + $total_price;
        $grand_total = number_format((float)$grand_total, 2, '.', '');
        echo "<tr class='item'><td>".$row["item_name"]."</td><td>".$qty."</td><td>RM ".$price."</td><td>RM ".$total_price."</td></tr>";
    }
    echo "<tr><td></td><td></td><td></td><td class='total'>Total: RM ".$grand_total."</td></tr>";
} else {
    echo "0 results";
}

// Attempt to query database table and retrieve data  
/*
try {
   //$counter = 0;
   $stmt    = $pdo->query($sql);
   while($row  = $stmt->fetch(PDO::FETCH_OBJ))
   {
      // Assign each row of data to associative array
      $data[] = $row;
      //echo "alert(".$row['item_name'].")";
      //$counter = $counter + 1;
   }
   // Return data as JSON
   echo json_encode($data);
}
catch(PDOException $e)
{
   echo $e->getMessage();
}
*/
?>
        </table>
        <a href="paypal-express-checkout" ><img src="http://www.ajflookwindowcleaning.co.uk/wp-content/uploads/2017/03/PayPal-PayNow-Button.png" width="179" height="36"></a>
    </div>
</body>
</html>