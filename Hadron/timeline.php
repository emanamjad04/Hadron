<!DOCTYPE html>
<?php
    require_once "connectivity.php";
    // todo : get project id from client id after log id
    $project_id = 105;
    $stmt = $db->query("CALL GetTimelineSteps($project_id);");
    $steps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo("<pre>\n");
    // print_r($steps);
    // echo("\n</pre>\n");
    $json = json_encode($steps);    // converts this into javascript object notation
    // echo("<pre>\n");
    // print_r($json);
    // echo("\n</pre>\n");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="timeline.css">
</head>
<body>
    <div id="projectinfo">
        <div id="projTitle">[Insert Project Title]</div>
        <p id="projStatus">[Insert Project Status]</p>
        <p id="startdate">[Insert Start Date]</p>
        <p id="enddate">[Insert End Date]</p>
    </div>
    <div class='wrapper'>
<div class='steps' id='steps'>
  
</div> <!-- Div Steps ends here -->
</div> <!-- Div wrapper ends here -->
    <script src="timeline.js"></script>
    <script>
        let data = <?php echo $json; ?>;    // converts php variable to js variable where data is a list of objects
        console.log("DATA: ");
        console.log(data);
        // makeStep(4, "halo", "Hello World", "Completed");
        for(let i=1; i<= data.length; i++){
            makeStep(i, data[i-1].step_name, data[i-1].description, data[i-1].status);
        }
        document.getElementById("projTitle").innerHTML = data[0].projectName;
        document.getElementById("projStatus").innerHTML = "Status: ".concat(data[0].projectStatus);
        document.getElementById("startdate").innerHTML = "Commencement Date:   ".concat(data[0].start_date);
        document.getElementById("enddate").innerHTML = "Completion Date:   ".concat(data[data.length - 1].end_date);
    </script>
</body>
</html>

<!-- scroll to the currently active stage on reload -->