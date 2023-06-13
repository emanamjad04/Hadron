<!DOCTYPE html>
<?php 
    require_once "connectivity.php";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['create_project_form'])) {
            // Handle Create Project Form submission
            $project_name = $_POST['new_project_name'];
            echo "Form 1 submitted! Name: $project_name";
            print_r($_POST);
            if(isset($_POST['clientName']) && isset($_POST['new_project_name'])) {
                echo "True";
                $sql = "INSERT INTO project (projectName, clientID) VALUES (:projectName, :clientID);";
                echo("<pre>\n".$sql."\n</pre>\n");
                $stmt = $db->prepare($sql);
                $stmt->execute(array(
                    ':projectName' => $_POST['new_project_name'],
                    ':clientID' => $_POST['clientName'],
                ));
                $stmt->closeCursor();}
        }
        else if(isset($_POST['create_timeline_form'])){
            $project_name = $_POST['projectName'];
            $insert_data = array();
            if(isset($_POST['step1']) && isset($_POST['start_step1']) && isset($_POST['end_step1'])){
                $start = $_POST['start_step1'];
                $end = $_POST['end_step1'];
                $insert_data[1] = array($start, $end);
            }
            if(isset($_POST['step2']) && isset($_POST['start_step2']) && isset($_POST['end_step2'])){
                $start = $_POST['start_step2'];
                $end = $_POST['end_step2'];
                $insert_data[2] = array($start, $end);
            }
            if(isset($_POST['step3']) && isset($_POST['start_step3']) && isset($_POST['end_step3'])){
                $start = $_POST['start_step3'];
                $end = $_POST['end_step3'];
                $insert_data[3] = array($start, $end);
            }
            if(isset($_POST['step4']) && isset($_POST['start_step4']) && isset($_POST['end_step4'])){
                $start = $_POST['start_step4'];
                $end = $_POST['end_step4'];
                $insert_data[4] = array($start, $end);
            }
            if(isset($_POST['step5']) && isset($_POST['start_step5']) && isset($_POST['end_step5'])){
                $start = $_POST['start_step5'];
                $end = $_POST['end_step5'];
                $insert_data[5] = array($start, $end);
            }
            if(isset($_POST['step6']) && isset($_POST['start_step6']) && isset($_POST['end_step6'])){
                $start = $_POST['start_step6'];
                $end = $_POST['end_step6'];
                $insert_data[6] = array($start, $end);
            }
            if(isset($_POST['step7']) && isset($_POST['start_step7']) && isset($_POST['end_step7'])){
                $start = $_POST['start_step7'];
                $end = $_POST['end_step7'];
                $insert_data[7] = array($start, $end);
            }
            
            if(isset($_POST['step8']) && isset($_POST['start_step8']) && isset($_POST['end_step8'])){
                $start = $_POST['start_step8'];
                $end = $_POST['end_step8'];
                $insert_data[8] = array($start, $end);
            }
            
            if(isset($_POST['step9']) && isset($_POST['start_step9']) && isset($_POST['end_step9'])){
                $start = $_POST['start_step9'];
                $end = $_POST['end_step9'];
                $insert_data[9] = array($start, $end);
            }
            if(isset($_POST['step10']) && isset($_POST['start_step10']) && isset($_POST['end_step10'])){
                $start = $_POST['start_step10'];
                $end = $_POST['end_step10'];
                $insert_data[10] = array($start, $end);
            }
            if(isset($_POST['step11']) && isset($_POST['start_step11']) && isset($_POST['end_step11'])){
                $start = $_POST['start_step11'];
                $end = $_POST['end_step11'];
                $insert_data[11] = array($start, $end);
            }
            if(isset($_POST['step13']) && isset($_POST['start_step13']) && isset($_POST['end_step13'])){
                $start = $_POST['start_step13'];
                $end = $_POST['end_step13'];
                $insert_data[13] = array($start, $end);
            }
            if(isset($_POST['step14']) && isset($_POST['start_step14']) && isset($_POST['end_step14'])){
                $start = $_POST['start_step14'];
                $end = $_POST['end_step14'];
                $insert_data[14] = array($start, $end);
            }
            print_r($insert_data);
            $sql = "INSERT INTO projectstepbridge (projectId, step_id, start_date, end_date) VALUES ";
            foreach ($insert_data as $step => $dates) {
                $start = $dates[0];
                $end = $dates[1];
                $sql .= "('$project_name', $step, '$start', '$end'), ";
            }
            $sql = rtrim($sql, ', ') . ';';
            echo ($sql);
            try {
                // Your existing code for creating the SQL query and executing the insertion
                // ...
            
                // Execute the SQL query
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $stmt->closeCursor();
            
                // Check if any rows were affected (data inserted)
                if ($stmt->rowCount() > 0) {
                    echo "Data inserted successfully!";
                } else {
                    echo "No data inserted.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        else if(isset($_POST['update_timeline_form'])){
            echo "inside update_timeline php";
            for ($i = 0; $i < 14; $i++) {
                $checkboxName = 'completed' . $i;
                if (isset($_POST[$checkboxName])) {
                    $sql = "UPDATE projectstepbridge SET status = 'Completed' WHERE project_step_id = '$_POST[$checkboxName]';";
                    echo($sql);
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $stmt->closeCursor();
                }
            }
        }
        else if(isset($_POST['add_items_form'])){
            if(isset($_POST['item_name']) && isset($_POST['item_brand']) && isset($_POST['item_quality'])){
                $sql = "INSERT INTO inventory (itemName, brand, quality) VALUES (:item_name, :item_brand, :item_quality)";
            }
            else if(isset($_POST['item_name']) && isset($_POST['item_brand'])){
                $sql = "INSERT INTO inventory (itemName, brand) VALUES (:item_name, :item_brand);";
            }
            else if(isset($_POST['item_name']) && isset($_POST['item_quality'])){
                $sql = "INSERT INTO inventory (itemName, quality) VALUES (:item_name, :item_quality);";
            }
            else if(isset($_POST['item_name'])){
                $sql = "INSERT INTO inventory (itemName) VALUES (:item_name);";
            }
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':item_name', $_POST['item_name']);
            $stmt->bindParam(':item_brand', $_POST['item_brand']);
            $stmt->bindParam(':item_quality', $_POST['item_quality']);
            
            // Execute the statement
            $stmt->execute();
                    $stmt->closeCursor();
        }
        else if(isset($_POST['manage_transactions_form'])){
            if(isset($_POST['transaction_item']) && isset($_POST['transaction_date']) && 
            isset($_POST['transaction_amount']) && isset($_POST['transaction_type']) && 
            isset($_POST['transaction_with']) && (isset($_POST['suppliers']) || isset($_POST['clients']) || isset($_POST['offices']))){
                $item_id = $_POST['transaction_item'];
                $date = $_POST['transaction_date'];
                $amount = $_POST['transaction_amount'];
                if($_POST['transaction_type'] == "iss"){
                    $issued = $amount;
                    $recieved = null;
                } else if($_POST['transaction_type'] == "rec"){
                    $recieved = $amount;
                    $issued = null;
                }
                if($_POST['transaction_with'] == "supplier"){
                    $tsupplier_id = $_POST['suppliers'];
                    $toffice_id = null;
                    $tclient_id = null;
                } else if($_POST['transaction_with'] == "client"){
                    $tsupplier_id = null;
                    $toffice_id = $_POST['offices'];
                    $tclient_id = null;
                } else if($_POST['transaction_with'] == "office"){
                    $tsupplier_id = null;
                    $toffice_id = null;
                    $tclient_id = $_POST['clients'];
                }
                if(isset($_POST['transaction_remarks'])){
                    $remarks = $_POST['transaction_remarks'];
                }else{
                    $remarks = null;
                }
                
                
                // Prepare the SQL statement
                $sql = "CALL AddTransaction(:id, :tDate, :itemsIss, :itemsRec, :sId, :cId, :oId, :rem, @transaction_status)";

                // Prepare the statement
                $stmt = $db->prepare($sql);

                // Bind the IN parameters
                $stmt->bindParam(':id', $item_id);
                $stmt->bindParam(':tDate', $date);
                $stmt->bindParam(':itemsIss', $issued);
                $stmt->bindParam(':itemsRec', $recieved);
                $stmt->bindParam(':sId', $tsupplier_id);
                $stmt->bindParam(':cId', $tclient_id);
                $stmt->bindParam(':oId', $toffice_id);
                $stmt->bindParam(':rem', $remarks);

                // Execute the statement
                $stmt->execute();

                // Get the value of the OUT parameter
                $stmt->closeCursor();
                $statusStmt = $db->query("SELECT @transaction_status");
                $status = $statusStmt->fetchColumn();

                $statusStmt->closeCursor();

                // Output the value of the OUT parameter
                echo "Transaction status: " . $status;

            }  }
        else if(isset($_POST['add_c'])){
            if(isset($_POST['addclientid']) && isset($_POST['addclientpass'])){
                // echo "hi";
            $stmt = $db->prepare("INSERT INTO add_client (client_id,client_pass) values (?,?)");
            $clientid = $_POST['addclientid'];
            $clientpass = $_POST['addclientpass'];
                $stmt->bindParam(1,$clientid);
                $stmt->bindParam(2,$clientpass);
                $stmt->execute();
            }
        }
        else if(isset($_POST['change_status_button'])){
            if(isset($_POST['change_status'])){
                $stmt = $db->prepare("UPDATE complaint SET complaint_status= ? where client_id=?");
                $clientid =$_POST['change_status'];
                $stmt->bindValue(1,true);
                $stmt->bindParam(2,$clientid);
                $stmt->execute();
            }
        }
        else{
            echo "Form not submitted!";
        }
        header("Location: Admin.php"); // redirect
        exit;
    }
    


    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hadron Solar - Admin Panel</title>
    <link href="admin.css" type="text/css" rel="stylesheet">
    <script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>
    <script>
        var choice1="consultation";
        var choice2="complaint";
        var sql2="";
        const cols = ["fullname","contact","address","email","complaint_no","complaint_description","complaint_status","client_id"];
        $(document).ready(function(){
            $("#consul").click(function(){
                $("#consuldiv").load("comp_consul_table.php",{
                    action:"showconsultation_action",
                    data: choice1,
                    where:sql2,
                    cols:cols.slice(0,4)
                
                });
            })
            $("#comp").click(function(){
                $("#compdiv").load("comp_consul_table.php",{
                    action:"showcomplaint_action",
                    data: choice2,
                    where:sql2,
                    cols:cols.slice(4,8)
                
                });
            })

        })
    </script>
</head>
<body>
    <div id="homediv1">
        <br>
        <ul id="ul1">
            <a href="#client_div"><li class="li1">CLIENT</li></a>
            <a href="#project_div"><li class="li1" >PROJECT</li></a>
            <a href="#inventory_div"><li class="li1">INVENTORY</li></a>
            <a href="home.php"><li class="li1">LOGOUT</li></a>

        </ul>
    </div>
    <center><div id="head_div" class="heading" style="margin-bottom: 60px;"><h1 style="letter-spacing:2px">ADMIN</h1></div></center>
    <div id=admin_container>
        <div id ="client_div">
        <fieldset>
    <legend id="head_div" class="heading" style="margin-bottom:50px ; font-size:40px">Add Client</legend>
            <div id="homediv">
            <form name="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            Client ID:<input type="text" name="addclientid"/>
            Password:<input type="text" name="addclientpass"/>
            <input type="submit" id="add_c" class="loginandform" value="+ add" name="add_c"  />
            </form>

            <br><br><br>
            </div>
            </fieldset>
            <br><br><br>

            <fieldset>
            <legend id="head_div" class="heading" style="margin-bottom:50px ; font-size:40px">Change Status</legend>
                <div>
                    <form name="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    
                    <input type="text" name="change_status"/>
                    <input type="submit" id="#change_status_button" name="change_status_button" value="Acknowleged/completed"/>
            </form>
                
            </div>


            </fieldset>
            <input type="submit" id="comp" class="loginandform" value="complaint" />
            <input type="submit" id="consul" class="loginandform" value="consultation"  />
            <div id="consuldiv"></div>
            <div id="compdiv"></div>
        </div>
        <div id="project_div">
            <div id="create_project">
                <form id="create_project_form" name="create_project_form" method="post">
                    <legend id="head_div" class="heading" style="margin-bottom:50px ; font-size:40px">Create Project</legend>
                    <label for="clientName"> Client: </label>
                    <select name="clientName" id="clientName">
                    </select>
                    <br/>
                    <label for="new_project_name">Project Title</label>
                    <input type="text" id="new_project_name" name= "new_project_name" required/>
                    <input type="submit" value="GO" id="create_project_submit" name="create_project_form">
                    <br/>
                </form>
            </div>
            <div id="create_timeline">
                <form id="create_timeline_form" name="create_timeline_form" method="post" onsubmit="return validateCreateTimeline()">
                    <legend id="head_div" class="heading" style="margin-bottom:50px ; font-size:40px">Create Project Timeline</legend>
                    <br><br>
                    <label for="projectName">Project</label>
                    <select name="projectName" id="projectName">
                    </select>
                    <br>
                    <div id="container_grid">
                    <span>
                    <input type="checkbox" id="step1" name="step1" value="1" onchange="toggleDateInputs('step1')">
                    <label for="step1"> Technical Survey</label></span>
                    <input type="date" id="start_step1" name="start_step1" disabled required/>
                    <input type="date" id="end_step1" name="end_step1" disabled required/>
                    
                    <span><input type="checkbox" id="step2" name="step2" value="2" onchange="toggleDateInputs('step2')">
                    <label for="step2"> Final Drawing</label></span>
                    <input type="date" id="start_step2" name="start_step2" disabled required/>
                    <input type="date" id="end_step2" name="end_step2" disabled required/>
                    
                    <span><input type="checkbox" id="step3" name="step3" value="3" onchange="toggleDateInputs('step3')">
                    <label for="step3"> Delivery - Civil Material</label></span>
                    <input type="date" id="start_step3" name="start_step3" disabled required/>
                    <input type="date" id="end_step3" name="end_step3" disabled required/>
                    
                    <span><input type="checkbox" id="step4" name="step4" value="4" onchange="toggleDateInputs('step4')">
                    <label for="step4"> Delivery - Structural Material</label></span>
                    <input type="date" id="start_step4" name="start_step4" disabled required/>
                    <input type="date" id="end_step4" name="end_step4" disabled required/>
                    
                    <span><input type="checkbox" id="step5" name="step5" value="5" onchange="toggleDateInputs('step5')">
                    <label for="step5"> Delivery - Solar Panels</label></span>
                    <input type="date" id="start_step5" name="start_step5" disabled required/>
                    <input type="date" id="end_step5" name="end_step5" disabled required/>
                    
                    <span><input type="checkbox" id="step6" name="step6" value="6" onchange="toggleDateInputs('step6')">
                    <label for="step6"> Delivery - BOQ</label></span>
                    <input type="date" id="start_step6" name="start_step6" disabled required/>
                    <input type="date" id="end_step6" name="end_step6" disabled required/>
                    
                    <span><input type="checkbox" id="step7" name="step7" value="7" onchange="toggleDateInputs('step7')">
                    <label for="step7"> Installation</label></span>
                    <input type="date" id="start_step7" name="start_step7" disabled required/>
                    <input type="date" id="end_step7" name="end_step7" disabled required/>
                    
                    <span><input type="checkbox" id="step8" name="step8" value="8" onchange="toggleDateInputs('step8')">
                    <label for="step8"> Quality Control (Q.C)</label></span>
                    <input type="date" id="start_step8" name="start_step8" disabled required/>
                    <input type="date" id="end_step8" name="end_step8" disabled required/>
                    
                    <span><input type="checkbox" id="step9" name="step9" value="9" onchange="toggleDateInputs('step9')">
                    <label for="step9"> Handover and Training</label></span>
                    <input type="date" id="start_step9" name="start_step9" disabled required/>
                    <input type="date" id="end_step9" name="end_step9" disabled required/>
                    
                    <span><input type="checkbox" id="step10" name="step10" value="10" onchange="toggleDateInputs('step10')">
                    <label for="step10"> Permitting</label></span>
                    <input type="date" id="start_step10" name="start_step10" disabled required/>
                    <input type="date" id="end_step10" name="end_step10" disabled required/>
                    
                    <span><input type="checkbox" id="step11" name="step11" value="11" onchange="toggleDateInputs('step11')">
                    <label for="step11"> Site Preparation</label></span>
                    <input type="date" id="start_step11" name="start_step11" disabled required/>
                    <input type="date" id="end_step11" name="end_step11" disabled required/>
                    
                    <span><input type="checkbox" id="step13" name="step13" value="13" onchange="toggleDateInputs('step13')">
                    <label for="step13"> Testing and Commissioning</label></span>
                    <input type="date" id="start_step13" name="start_step13" disabled required/>
                    <input type="date" id="end_step13" name="end_step13" disabled required/>
                    
                    <span><input type="checkbox" id="step14" name="step14" value="14" onchange="toggleDateInputs('step14')">
                    <label for="step14"> Mantainence and Support</label></span>
                    <input type="date" id="start_step14" name="start_step14" disabled required/>
                    <input type="date" id="end_step14" name="end_step14" disabled required/>
                    </div>
                    <br>
                    <input type="submit" value="GO" id="create_timeline_submit" name="create_timeline_form">
                </form>
            </div>
            <div id="update_timeline">
            <form id="update_timeline_form" name="update_timeline_form" method="post">
                <legend id="head_div" class="heading" style="margin-bottom:50px ; font-size:40px">Update Project Timeline</legend>
                <br><br>
                <label for="projectName2">Project</label>
                <select name="projectName2" id="projectName2">
                </select>
                <button id="get_timeline" onclick="getTimeline(event)">Get Timeline</button>
                <div id="timeline_view"></div>
            </div>
        </div>
        <div id="inventory_div">
            <div id="view_inventory">
                <legend id="head_div" class="heading" style="margin-bottom:50px ; font-size:40px">View Inventory</legend>
                <button id="view_inventory" onclick="viewInventory(event)">View Inventory</button>
            </div>
            <div id="add_items">
                <form id="add_items_form" name="add_items_form" method="post">
                    <legend id="head_div" class="heading" style="margin-bottom:50px ; font-size:40px">Add Items</legend>
                    <label for="item_name">Item Name: </label>
                    <input type="text" id="item_name" name="item_name"/>
                    <label for="item_brand">Brand: </label>
                    <input type="text" id="item_brand" name="item_brand"/>
                    <label for="item_quality">Quality: </label>
                    <input type="text" id="item_quality" name="item_quality"/>
                    <input type="submit" value="GO" id="add_items_submit" name="add_items_form">
                </form>
            </div>
            <div id="manage_transactions">
                <form id="manage_transactions_form" name="manage_transactions_form" method="post">
                    <legend id="head_div" class="heading" style="margin-bottom:50px ; font-size:40px">Manage Transactions</legend>
                    <input type = "radio" value="iss" name="transaction_type" id="transaction_iss"/>
                    <label for="transaction_iss">Issued</label>
                    <input type = "radio" value="rec" name="transaction_type" id="transaction_rec"/>
                    <label for="transaction_rec">Received</label>
                    <br/>

                    <select name="transaction_item" id="transaction_item">
                    </select>
                    <br/>

                    <label for="transaction_date">Date: </label>
                    <input type ="date" name="transaction_date" id="transaction_date" />
                    <br/>

                    <label for="transaction_amount">Amount: </label>
                    <input type ="number" name="transaction_amount" id="transaction_amount" />
                    <br/>

                    <input type = "radio" value="supplier" name="transaction_with" id="supplier" onclick="toggleSelect(this)"/>
                    <label for="supplier">Supplier</label>
                    <select name="suppliers" id="suppliers" disabled>
                        <option value="1">Sabri</option>
                        <option value="2">Jilani</option>
                    </select>
                    <input type = "radio" value="client" name="transaction_with" id="client" onclick="toggleSelect(this)"/>
                    <label for="client">Client</label>
                    <select name="clients" id="clients" disabled>
                    </select>
                    <input type = "radio" value="office" name="transaction_with" id="office" onclick="toggleSelect(this)"/>
                    <label for="office">Office</label>
                    <select name="offices" id="offices" disabled>
                        <option value="1">Lahore</option>
                        <option value="2">Karachi</option>
                        <option value="3">Sukkur</option>
                    </select>
                    <label for="transaction_remarks">Remarks: </label>
                    <input type="text" name="transaction_remarks" id="transaction_remarks"/>
                    <input type="submit" value="GO" id="manage_transactions_submit" name="manage_transactions_form">
                </form>
            </div>
        </div>
    </div>
<script src="admin.js"></script>
<?php
    // Get all Clients for client select box
    $stmt = $db->query("CALL getAllClients();");
    $client_options = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $json_clients = json_encode($client_options);
    echo "<script> 
    let client_options = $json_clients; 
    populateSelect('clientName', client_options, 'client_id', 'client_id');
    populateSelect('clients', client_options, 'client_id', 'client_id');
    </script>";
    $stmt->closeCursor();

    // Get all Projects for project select box
    $stmt = $db->query("CALL getAllProjects();");
    $project_options = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $json_projects = json_encode($project_options);
    echo "<script> 
    let project_options = $json_projects; 
    populateSelect('projectName', project_options, 'projectId', 'projectName');
    populateSelect('projectName2', project_options, 'projectId', 'projectName');
    </script>";
    
    // Get all items for transaction select box
    $stmt->closeCursor();
    $stmt = $db->query("CALL getAllItems();");
    $item_options = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $json_items = json_encode($item_options);
    echo "<script> 
    let item_options = $json_items; 
    populateSelect('transaction_item', item_options, 'itemId', 'item');
    </script>";
    $stmt->closeCursor();
    
?>
</body>
</html>
