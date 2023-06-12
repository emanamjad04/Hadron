<!DOCTYPE html>
<html lang="en">
<head>

<link rel="stylesheet" type="text/css" href="timeline.css">
<script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>
    <script>
        var choice3="complaint";
        const cols = ["complaint_no","complaint_description","complaint_status","client_id"];
        $(document).ready(function(){
            $("#pre_comp_btn").click(function(){
                $("#pre_comp_div").load("comp_consul_table.php",{
                    // action:"showcomp_action",
                    data: choice3,
                    cols:cols
                
                });
            })
        

        })
    </script>
    <?php
     require_once "connectivity.php";
     
        "/br";
        if(isset($_POST['comp_des'])){
            session_start();
            $user=$_SESSION['s_client_id'];
            $stmpt=$db->prepare("INSERT INTO complaint (complaint_description,complaint_status,client_id) values (?,?,?) ");
            $des=$_POST['comp_des'];
            $st=false;
            $stmpt->bindParam(1,$des);
            $stmpt->bindParam(2,$st);
            $stmpt->bindParam(3,$user);
            $stmpt->execute();
        }
        session_start();
        $user=$_SESSION['s_client_id'];
        echo "$user";

     $stmpt=$db->prepare("SELECT projectId FROM project where clientID='$user' ");
     $stmpt->execute();

    $project_id = $stmpt->fetchColumn();
    echo "pD "."'$project_id'";
    $stmt = $db->query("CALL GetTimelineSteps($project_id);");
    $steps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo("<pre>\n");
    // print_r($steps);
    // echo("\n</pre>\n");
    $json = json_encode($steps);


    ?>
    <script  type="text/javascript">
        function logout()
        {
            window.location.href="login.php";

        }
       
        

    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint</title>
</head>
<body>

    <div style="text-align:right">
    <input type="submit" class="clientsidebtns" value="logout" onclick='logout()'/></div>
    <form name="form" action="complaint.php" method="post">
    <h1>ADD COMPLAINT</h1>
    <input type="Text" name="comp_des" placeholder="ABC.."/>
    <input type="submit" class="clientsidebtns" value="Submit"  /> <br><br><br>
    </form>
    <input type="button" class="clientsidebtns" id="pre_comp_btn" value="Previous Complaints"/>
    <div id="pre_comp_div"></div>
<br><br><br>
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