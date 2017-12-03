<?php
$currency = 'RM'; //Currency Character or code

//MySql 
$db_username 	= 'izzad_izzad';
$db_password 	= 'izzad123';
$db_name 		= 'izzad_izzad';
$db_host 		= 'localhost';

//paypal settings
$PayPalMode 			= 'sandbox'; // sandbox or live
$PayPalApiUsername 		= 'muhammadzulhilmi2493-facilitator_api1.gmail.com'; //PayPal API Username
$PayPalApiPassword 		= 'CGXSR3QXHNJVDBHP'; //Paypal API password
$PayPalApiSignature 	= 'AFcWxV21C7fd0v3bYYYRCpSSRl31AUHfSf6ichYYVOtPqg.hDqED8P7h'; //Paypal API Signature
$PayPalCurrencyCode 	= 'MYR'; //Paypal Currency Code
$PayPalReturnURL 		= 'http://muhammadzulhilmi.com'; //Point to paypal-express-checkout page
$PayPalCancelURL 		= 'http://52.220.44.181/~izzad/ServerSidePayMe/PHP-Shopping-Cart-PayPal-Express-Checkout/'; //Cancel URL if user clicks cancel

//Additional taxes and fees											
$HandalingCost 		= 0.00;  //Handling cost for the order.
$InsuranceCost 		= 0.00;  //shipping insurance cost for the order.
$shipping_cost      = 0.00; //shipping cost
$ShippinDiscount 	= 0.00; //Shipping discount for this order. Specify this as negative number (eg -1.00)
$taxes              = array( //List your Taxes percent here.
                            'VAT' => 0, 
                            'Service Tax' => 0
                            );

//connection to MySql						
$mysqli = new mysqli($db_host, $db_username, $db_password,$db_name);						
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
?>
