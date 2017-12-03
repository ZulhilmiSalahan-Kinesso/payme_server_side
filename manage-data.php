<?php
   header('Access-Control-Allow-Origin: *');

   // Define database connection parameters
   $hn      = 'localhost';
   $un      = 'izzad_izzad';
   $pwd     = 'izzad123';
   $db      = 'izzad_izzad';
   $cs      = 'utf8';

   // Set up the PDO parameters
   $dsn  = "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
   $opt  = array(
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                       );
   // Create a PDO instance (connect to the database)
   $pdo  = new PDO($dsn, $un, $pwd, $opt);

   // Retrieve specific parameter from supplied URL
   $key  = strip_tags($_REQUEST['key']);
   echo($key."<br />");
   $data    = array();


   // Determine which mode is being requested
   switch($key)
   {

      // Add a new record to the technologies table
      case "create":

         // Sanitise URL supplied values
         $invoice_number       = filter_var($_REQUEST['invoice_number'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $invoice_name       = filter_var($_REQUEST['invoice_name'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $invoice_desc   = filter_var($_REQUEST['invoice_desc'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $invoice_status   = filter_var($_REQUEST['invoice_status'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            echo(invoice_name."<br />");
            echo(invoice_desc."<br />");
         // Attempt to run PDO prepared statement
         try {
            $sql  = "INSERT INTO invoice(invoice_number, invoice_name, invoice_desc, invoice_status) VALUES(:invoice_number, :invoice_name, :invoice_desc, :invoice_status)";
            $stmt    = $pdo->prepare($sql);
            $stmt->bindParam(':invoice_number', $invoice_number, PDO::PARAM_STR);
            $stmt->bindParam(':invoice_name', $invoice_name, PDO::PARAM_STR);
            $stmt->bindParam(':invoice_desc', $invoice_desc, PDO::PARAM_STR);
            $stmt->bindParam(':invoice_status', $invoice_status, PDO::PARAM_STR);
            $stmt->execute();
            echo json_encode(array('message' => 'Congratulations the record ' . $invoice_name . ' was added to the database'));
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;



      // Update an existing record in the technologies table
      case "update":

         // Sanitise URL supplied values
         $invoice_name          = filter_var($_REQUEST['invoice_name'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $invoice_desc   = filter_var($_REQUEST['invoice_desc'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $invoice_id      = filter_var($_REQUEST['invoice_id'], FILTER_SANITIZE_NUMBER_INT);

         // Attempt to run PDO prepared statement
         try {
            $sql  = "UPDATE invoice SET invoice_name = :invoice_name, invoice_desc = :invoice_desc WHERE invoice_id = :invoice_id";
            $stmt =  $pdo->prepare($sql);
            $stmt->bindParam(':invoice_name', $invoice_name, PDO::PARAM_STR);
            $stmt->bindParam(':invoice_desc', $invoice_desc, PDO::PARAM_STR);
            $stmt->bindParam(':invoice_id', $invoice_id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode('Congratulations the record ' . $invoice_name . ' was updated');
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;



      // Remove an existing record in the technologies table
      case "delete":

         // Sanitise supplied record ID for matching to table record
         $invoice_id   =  filter_var($_REQUEST['invoice_id'], FILTER_SANITIZE_NUMBER_INT);

         // Attempt to run PDO prepared statement
         try {
            $pdo  = new PDO($dsn, $un, $pwd);
            $sql  = "DELETE invoice , items FROM items INNER JOIN invoice WHERE invoice.invoice_number= items.foreign_invoice_number and invoice.invoice_id = :invoice_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':invoice_id', $invoice_id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode('Congratulations the record ' . $invoice_name . ' was removed');
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;



      case "createItem":
         // Sanitise URL supplied values
         $foreign_invoice_number       = filter_var($_REQUEST['foreign_invoice_number'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $item_name       = filter_var($_REQUEST['item_name'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $item_quantity   = filter_var($_REQUEST['item_quantity'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $item_price   = filter_var($_REQUEST['item_price'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            //echo(invoice_name."<br />");
            //echo(invoice_desc."<br />");
         // Attempt to run PDO prepared statement
         try {
            $sql  = "INSERT INTO items(foreign_invoice_number, item_name, item_quantity, item_price) VALUES(:foreign_invoice_number, :item_name, :item_quantity, :item_price)";
            $stmt    = $pdo->prepare($sql);
            $stmt->bindParam(':foreign_invoice_number', $foreign_invoice_number, PDO::PARAM_STR);
            $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
            $stmt->bindParam(':item_quantity', $item_quantity, PDO::PARAM_STR);
            $stmt->bindParam(':item_price', $item_price, PDO::PARAM_STR);
            $stmt->execute();
            echo json_encode(array('message' => 'Congratulations the record ' . $item_name . ' was added to the database'));
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;

      case "updateInvoiceStatus":
        // Sanitise URL supplied values
        $invoice_id       = filter_var($_REQUEST['invoice_id'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        // Attempt to run PDO prepared statement
        try {
            $sql  = "UPDATE invoice SET invoice_status='paid' WHERE invoice_id =".$invoice_id;
            $stmt    = $pdo->prepare($sql);
            $stmt->bindParam(':invoice_id', $invoice_id, PDO::PARAM_STR);
            $stmt->execute();
            echo json_encode(array('message' => 'Congratulations! Payment successful!!!'));
            header("Location: http://52.220.44.181/~izzad/ServerSidePayMe/payment-receive.html");
        }
        // Catch any errors in running the prepared statement
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }

    break;
   }

?>