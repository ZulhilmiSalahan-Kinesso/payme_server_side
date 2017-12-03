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
         $template_name       = filter_var($_REQUEST['template_name'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $template_desc   = filter_var($_REQUEST['template_text'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            echo(template_name."<br />");
            echo(template_desc."<br />");
         // Attempt to run PDO prepared statement
         try {
            $sql  = "INSERT INTO template(template_name, template_text) VALUES(:template_name, :template_text)";
            $stmt    = $pdo->prepare($sql);
            $stmt->bindParam(':template_name', $template_name, PDO::PARAM_STR);
            $stmt->bindParam(':template_text', $template_desc, PDO::PARAM_STR);
            $stmt->execute();

            echo json_encode(array('message' => 'Congratulations the record ' . $template_name . ' was added to the database'));
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
         $template_name          = filter_var($_REQUEST['template_name'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $template_desc   = filter_var($_REQUEST['template_desc'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
         $template_id      = filter_var($_REQUEST['template_id'], FILTER_SANITIZE_NUMBER_INT);

         // Attempt to run PDO prepared statement
         try {
            $sql  = "UPDATE template SET template_name = :template_name, template_desc = :template_desc WHERE template_id = :template_id";
            $stmt =  $pdo->prepare($sql);
            $stmt->bindParam(':template_name', $template_name, PDO::PARAM_STR);
            $stmt->bindParam(':template_desc', $template_desc, PDO::PARAM_STR);
            $stmt->bindParam(':template_id', $template_id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode('Congratulations the record ' . $template_name . ' was updated');
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
         $template_id   =  filter_var($_REQUEST['template_id'], FILTER_SANITIZE_NUMBER_INT);

         // Attempt to run PDO prepared statement
         try {
            $pdo  = new PDO($dsn, $un, $pwd);
            $sql  = "DELETE FROM template WHERE template_id = :template_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':template_id', $template_id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode('Congratulations the record ' . $template_id . ' was removed');
         }
         // Catch any errors in running the prepared statement
         catch(PDOException $e)
         {
            echo $e->getMessage();
         }

      break;
   }

?>