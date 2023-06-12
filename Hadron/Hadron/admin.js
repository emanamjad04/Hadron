function toggleDateInputs(checkboxId) {
  console.log("Function Called!")
  var startInput = document.getElementById('start_' + checkboxId);
  var endInput = document.getElementById('end_' + checkboxId);
  var checkbox = document.getElementById(checkboxId);
  
  if (checkbox.checked) {
      startInput.disabled = false;
      endInput.disabled = false;
  } else {
      startInput.disabled = true;
      endInput.disabled = true;
  }
}

function validateCreateTimeline(){
    // Add your validation logic here
            // You can check the values of the input fields, perform validation checks, and display error messages
            
            // Example: Validate that at least one checkbox is checked
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var isChecked = Array.from(checkboxes).some(function(checkbox) {
                return checkbox.checked;
            });
            
            if (!isChecked) {
                alert('Please select at least one checkbox.');
                return false; // Prevent form submission
            }

            // Add more validation checks as needed
            
            return true; // Allow form submission
}

function populateSelect(selectId, optList, optId, optName){
  console.log(optList);
  let select_box = document.getElementById(selectId);
        for(let i=0; i<optList.length; i++){
            let opt = document.createElement("option");
            opt.value = optList[i][optId];
            opt.innerHTML = optList[i][optName];
            select_box.appendChild(opt);
        }
}

function getTimeline(event) {
  var projectId = document.getElementById("projectName2").value;

  var xhr = new XMLHttpRequest();
  xhr.open("GET", "functions.php?function=getTimeline&projectId=" + encodeURIComponent(projectId), true);
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Handle the response from the PHP script
        //var response = xhr.responseText;
        console.log(xhr.responseText);
        var response = JSON.parse(xhr.responseText);
        //document.getElementById("timeline_view").innerHTML = response;
        console.log(typeof(response));
        makeTimelineTable(response);
      } else {
        // Handle error
        console.error("Request failed with status:", xhr.status);
      }
    }
  };
  
  xhr.send();
  event.preventDefault();
}


function makeTimelineTable(response){
  console.log(response);
  var table = document.createElement('table');

  var headerRow = document.createElement('tr');

  var headers = ['Step Number', 'Step Name', 'Step Description', 'Completed'];

  headers.forEach(function(header) {
    var th = document.createElement('th');
    th.textContent = header;
    headerRow.appendChild(th);
  });

  table.appendChild(headerRow);

  response.forEach(function(step, index) {
    var row = document.createElement('tr');

    var stepNumberCell = document.createElement('td');
    stepNumberCell.textContent = index + 1;
    row.appendChild(stepNumberCell);

    var stepNameCell = document.createElement('td');
    stepNameCell.textContent = step.step_name;
    row.appendChild(stepNameCell);

    var stepDescriptionCell = document.createElement('td');
    stepDescriptionCell.textContent = step.description;
    row.appendChild(stepDescriptionCell);

    var checkStatusCell = document.createElement("td");
    var check = document.createElement("input");
    check.type = "checkbox";
    check.name = "completed"+index;
    check.value = step.project_step_id;
    if (step.status == "Completed" ){
      check.checked = true;
      check.disabled = true;
    }
    checkStatusCell.appendChild(check);
    row.appendChild(checkStatusCell);
    table.appendChild(row);
});


  // Add the table to the document body or any desired element
  var view = document.getElementById("timeline_view");
  while (view.firstChild) {
    view.removeChild(view.firstChild);
}
  view.appendChild(table);
   
  var update_btn = document.createElement("input");
  update_btn.type="submit";
  update_btn.id = "update_timeline_submit";
  update_btn.name = "update_timeline_form";
  update_btn.value = "GO";

  document.getElementById("timeline_view").appendChild(update_btn);
}

function viewInventory(event){
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "functions.php?function=viewInventory", true);
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Handle the response from the PHP script
        var response = JSON.parse(xhr.responseText);
        // document.getElementById("timeline_view").innerHTML = response;
        console.log(typeof(response));
        // console.log(response);
        makeInventoryTable(response);
      } else {
        // Handle error
        console.error("Request failed with status:", xhr.status);
      }
    }
  };
  
  xhr.send();
  event.preventDefault();
}

function makeInventoryTable(response){
  console.log(response);
  var table = document.createElement('table');

  var headerRow = document.createElement('tr');

  var headers = ['Item No.', 'Item', 'Stock'];

  headers.forEach(function(header) {
    var th = document.createElement('th');
    th.textContent = header;
    headerRow.appendChild(th);
  });

  table.appendChild(headerRow);

  response.forEach(function(item, index) {
    var row = document.createElement('tr');

    var itemNumberCell = document.createElement('td');
    itemNumberCell.textContent = index + 1;
    row.appendChild(itemNumberCell);

    var itemNameCell = document.createElement('td');
    itemNameCell.textContent = item.item;
    row.appendChild(itemNameCell);

    var itemStockCell = document.createElement('td');
    itemStockCell.textContent = item.itemsInStock;
    row.appendChild(itemStockCell);

    table.appendChild(row);
});


  // Add the table to the document body or any desired element
  document.getElementById("view_inventory").appendChild(table);
}

function toggleSelect(radio) {
  var select_client = document.getElementById("clients");
  var select_supplier = document.getElementById("suppliers");
  var select_office = document.getElementById("offices");
  if(radio.value == "client"){
      select_client.disabled = false;  // Enable the select box
      select_office.disabled = true;
      select_supplier.disabled = true;
  }
  else if(radio.value == "supplier"){
      select_client.disabled = true;  // Enable the select box
      select_office.disabled = true;
      select_supplier.disabled = false;
  }
  else if(radio.value == "office"){
      select_client.disabled = true;  // Enable the select box
      select_office.disabled = false;
      select_supplier.disabled = true;
    } 
}

// solar_panel = ["JINKO", "LONGI", "TRINA"];


// // function that adds options to a select input
// function addOptions(select, arr){
//     arr.forEach(function(element) {
//         opt = document.createElement("option");
//         opt.innerText = element;
//         opt.value = element;
//         select.appendChild(opt);
//       });
// }

// function categorySelected(){
//     selectCategory = document.getElementById("item_type");
//     selectedCategory = selectCategory.value;
//     selectBrand = document.getElementById("item_brand");
//     console.log("Selected Category: ",selectedCategory);
//     if(selectedCategory == 2){
//         addOptions(selectBrand, solar_panel);
//         selectBrand.disabled = false;
//     }
// }
// select = document.getElementById("try");
// addOptions(select, [1, 2, 3, 4, 5]);

// var get_items = document.getElementById("get_items");
// var items = document.getElementById("items");

// get_items.onclick = function() {
//   // Make an AJAX request to the PHP script
//   var xhr = new XMLHttpRequest();
//   xhr.open("GET", "functions.php?function=getItems", true);
  
//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === XMLHttpRequest.DONE) {
//       if (xhr.status === 200) {
//         // Handle the response from the PHP script
//         var response = xhr.responseText;
//         items.innerHTML = response; 
//       } else {
//         // Handle error
//         console.error("Request failed with status:", xhr.status);
//       }
//     }
//   };
  
//   xhr.send();
// };

// // Get the input field
// // const itemInput = document.getElementById('itemInput');

// // // Add event listener for input field changes
// // itemInput.addEventListener('input', function() {
// //   const searchText = itemInput.value;

// //   // Make an AJAX request to fetch the matching items
// //   // and display them as suggestions in a dropdown or autocomplete list
// //   // based on the searchText
// //   // ...
// // });


// // create_project.onclick = function() {
// //   console.log("This function was called!!")
// //   var xhr = new XMLHttpRequest();

// //   // Prepare the request
// //   xhr.open("POST", "functions.php?function=createProject", true);
// //   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

// //   // Set up the callback function for when the request completes
// //   xhr.onload = function() {
// //     if (xhr.status === 200) {
// //       // Request was successful
// //       console.log("Record inserted successfully!");
// //     } else {
// //       // Request was not successful
// //       console.log("Error: " + xhr.statusText);
// //     }
// //   };

// //   pName = document.getElementById("projectTitle").value
// //   cId = document.getElementById("clientName").value
// //   // Set up the data to send
// //   var data = "clientID=" + encodeURIComponent(cId) + "&projectName=" + encodeURIComponent(pName);
// //   console.log(data);
// //   xhr.send(data);
// // };