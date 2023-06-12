<?php
    require_once "connectivity.php";
    // Check if a specific function is requested
    if (isset($_GET['function'])) {
      $function = $_GET['function'];
      // print_r($_GET);
      // Call the requested function
      if ($function === 'getTimeline') {
        $projectId = $_GET['projectId'];
        getTimeline($projectId);
      }

      else if ($function === 'viewInventory') {
        viewInventory();
      }
    }
    
    // Define the specific function
    // function getItems() {
    //     // echo "<script>console.log('Hello From The Other Side');</script>";
    //     global $pdo;
    //   // Perform actions specific to the function
    //   // Return the response or perform any necessary output
    //   $stmt = $pdo->query("SELECT itemName, itemsInStock FROM inventory");
    //     $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     echo '<table border="1">'."\n";
    //     echo "<tr><th>Name</th><th>Number In Stock</th></tr>";
    //     foreach ( $rows as $row ) {
    //         echo "<tr><td>";
    //         echo($row['itemName']);
    //         echo("</td><td>");
    //         echo($row['itemsInStock']);
    //         echo("</td></tr>\n");
    //     }
    //     echo "</table>\n";
    // }

    function getTimeline($projectId) {
      global $db;
      // echo "function inside php was called";
      // Use the $projectId parameter in your code
      $stmt = $db->prepare("CALL getTimelineSteps(:projectId)");
      $stmt->bindParam(':projectId', $projectId, PDO::PARAM_STR);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($rows);
  }

  function viewInventory(){
    global $db;
      // echo "function inside php was called";
      // Use the $projectId parameter in your code
      $stmt = $db->query("CALL getAllItems();");
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($rows);
  }
    // function createProject() {
    //   echo "<h1>HELLOOOO</h1>";
    //   global $pdo;
    //   if(isset($_POST['clientID']) && isset($_POST['projectName'])) {
    //     error_log('clientID: ' . $_POST['clientID']);
    //     error_log('projectName: ' . $_POST['projectName']);
    //      $sql = "INSERT INTO project (projectName, clientID) VALUES (:projectName, :clientID);";
    //      echo("<pre>\n".$sql."\n</pre>\n");
    //      $stmt = $pdo->prepare($sql);
    //      $stmt->execute(array(
    //         ':projectName' => $_POST['projectName'],
    //         ':clientID' => $_POST['clientID'],
    //      ));
    //      if ($stmt->errorCode() !== '00000') {
    //       $errorInfo = $stmt->errorInfo();
    //       echo "SQL Error: " . $errorInfo[2]; // Output the error message
    //   }
    // }
    // else{
    //   echo "<h1>else</h1>";
    // }
      
    // }
    
    

?>