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
   $data = array();


   // Attempt to query database table and retrieve data  
   try {
        $stmt    = $pdo->query('SELECT invoice_id, invoice_name, invoice_desc, invoice_status FROM invoice ORDER BY invoice_name ASC');
        while($row  = $stmt->fetch(PDO::FETCH_OBJ))
        {
            // Assign each row of data to associative array
            $data[] = $row;
        }
        // Return data as JSON
        echo json_encode($data);
   }
   catch(PDOException $e)
   {
      echo $e->getMessage();
   }


?>