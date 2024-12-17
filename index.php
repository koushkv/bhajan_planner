<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Allura&family=Satisfy&display=swap" rel="stylesheet">
    <title>Bhajan Planner</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- jQuery UI JavaScript -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.14/lottie.min.js"></script>
    <script>
    
    document.addEventListener("DOMContentLoaded", function() {
        // Countdown function
        function updateCountdown() {
        const today = new Date();
        const targetDate = new Date(today.getFullYear(), 10, 23); // November 23

        // Adjust for if the date has already passed this year
        if (today > targetDate) {
            targetDate.setFullYear(today.getFullYear() + 1);
        }

        const timeDiff = targetDate - today;
        const daysToGo = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

        const countdownElement = document.getElementById('countdown');

        // Check if today is the target date
        if (daysToGo === 365) {
            countdownElement.textContent = "";
        } else {
            countdownElement.textContent = "";
        }
    }

        // Run the countdown on load
        updateCountdown();

        // Lottie animation with delay
        setTimeout(function() {
            var animation = lottie.loadAnimation({
                container: document.getElementById('lottie-animation1'),
                renderer: 'svg',
                loop: false,
                autoplay: true,
                path: 'christmas.json' // Adjust the path as necessary
            });
        }, 1500);
    });
        function addLoginFields() {
            // Create username input
            var usernameInput = document.createElement("input");
            usernameInput.type = "text";
            usernameInput.name = "username";
            usernameInput.placeholder = "Enter Username";
            usernameInput.style.marginBottom = "10px";
            usernameInput.style.width = "50%";
            usernameInput.style.padding = "8px";

            // Create password input
            var passwordInput = document.createElement("input");
            passwordInput.type = "password";
            passwordInput.name = "password";
            passwordInput.placeholder = "Enter Password";
            passwordInput.style.marginBottom = "10px";
            passwordInput.style.width = "50%";
            passwordInput.style.padding = "8px";

            // Append the inputs to the formFields container
            var formFields = document.getElementById("formFields");
            formFields.appendChild(usernameInput);
            formFields.appendChild(passwordInput);

            // Change button text
            var addButton = document.getElementById("addButton");
            addButton.textContent = "Add Another Login Field";
        }

        $(function() {
            $('#datepicker1').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
        $(function() {
            $('#datepicker2').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });

        $(document).ready(function () {
            $('#datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: 0
            });
        });
        function toggleAll() {
            const allCheckbox = document.getElementById('all');
            const checkboxes = document.querySelectorAll('.block-container input[type="checkbox"]');
            
            checkboxes.forEach(checkbox => {
                if (checkbox.id !== 'all' && checkbox.id !== '6bt' && checkbox.id !== '7bt') {
                    checkbox.disabled = allCheckbox.checked;
                }
            });
        }
        
        /* Exclusive selection logic for 6 Beat and 7 Beat */
        function handleExclusive(selectedId, otherId) {
            const selectedCheckbox = document.getElementById(selectedId);
            const otherCheckbox = document.getElementById(otherId);
        
            if (selectedCheckbox.checked) {
                otherCheckbox.checked = false; // Uncheck the other one
            }
        }
        $(document).ready(function () {
    // Autocomplete functionality
    $('#autocompleteInput').on('input', function () {
        var term = $(this).val();
        if (term.length > 2) {
            $.ajax({
                url: 'autocomplete.php',
                dataType: 'json',
                data: { term: term },
                success: function (data) {
    $('#autocompleteList').empty();
    if (data.length > 0) {
        // Create a table structure
        const table = $('<table>');
        const thead = $('<thead>').append(
            $('<tr>')
                .append($('<th>').text('Bhajan'))
                .append($('<th>').text('Shruthi'))
                .append($('<th>').text('Last Sung'))
        );
        table.append(thead);
        const tbody = $('<tbody>');

        data.forEach(item => {
            const row = $('<tr>').addClass('autocomplete-item');

            // Create table cells for Bhajan Name, Shruthi, and Last Sung
            const nameCell = $('<td>').html(`<strong>${item.label}</strong>`).addClass('bhajan-name');
            const shruthiCell = $('<td>').html(`<strong>${item.shruthi}</strong>`).addClass('shruthi');
            const lastSungCell = $('<td>').text(item.lastsungon).addClass('last-sung');

            // Append cells to the row
            row.append(nameCell);
            row.append(shruthiCell);
            row.append(lastSungCell);

            // Add click functionality for each row
            row.on('click', function () {
                $('#autocompleteInput').val(item.label);
                $('#autocompleteList').empty();
            });

            // Append row to the table body
            tbody.append(row);
        });

        // Append the tbody to the table and display it
        table.append(tbody);
        $('#autocompleteList').append(table);
    }
}

            });
        } else {
            $('#autocompleteList').empty();
        }
    });

    // Close the autocomplete list when clicking outside
    $(document).on('click', function (e) {
        if (!$('#autocompleteList').is(e.target) && !$('#autocompleteInput').is(e.target)) {
            $('#autocompleteList').empty();
        }
    });
});

    </script>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: monospace;
        }
        .container {
            margin: 20px auto;
            background-color: #fff;
            min-width: 380px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 20%;
            position: relative;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #ffffff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-family: monospace;
        }
        th {
            background-color: #535353;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        legend {
            background-color: #FFFFFF;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1.2em;
            text-decoration: underline; 
        }
        .form-group {
            margin-bottom: 15px;
            text-align: center;
        }
        .control-label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }
        .help-block {
            color: #737373;
            font-size: 0.875em;
            margin-top: 5px;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .fixed-header .header {
            background-color: lightgrey;
            font-weight: bold;
            font-size: 1em;
            padding: 8px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }
        .btn-primary {
            background-color: #373737;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.05em;
            font-family: monospace;
        }
        .autocomplete {
            position: relative;
            display: inline-block;
            width: 300px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-family: monospace;
            font-size: 14px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 4px;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #fff;
        }

        .autocomplete-item {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }

        .autocomplete-items table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .autocomplete-items th, .autocomplete-items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-family: monospace;
            border: none;
            color:black;
        }

        .autocomplete-items th {
            background-color: #f1f1f1;
        }

        .autocomplete-item:hover {
            background-color: #f9f9f9;
            cursor: pointer;
        }

        .autocomplete-item strong.bhajan-name {
            flex: 2;
            text-align: left;/* Center the text */
        }

        .autocomplete-item span.shruthi,
        .autocomplete-item span.last-sung {
            text-align: right;
        }

        .autocomplete-item:hover {
            background-color: #f1f1f1;
        }
        .ui-datepicker {
    left: 50% !important; 
    transform: translateX(-50%);
}

.countdown {
  font-family: 'Allura', cursive;
  font-size: 1em;
  margin-top:0;
  margin-bottom:0;
  color: #ff7800;
  opacity: 0; /* Start with opacity 0 */
  transition: opacity 2s ease-in-out; /* Smooth fade effect */
  animation: fadeInOut 3s ease-in-out forwards; /* Run animation once */
}

/* Fade-in and fade-out animation */
@keyframes fadeInOut {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1; /* Fully visible */
  }
}

.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    margin-left:120px;
    gap: 15px; /* Optional: Adjust spacing between radio and label */
}

.form-check-inline {
    margin-right: 10px; /* Space between each radio input group */
}
        fieldset {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h1 {
            font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif; 
            font-size: 2em; /* You can adjust the size */
            margin-top:0px;
            margin-bottom:5px;
        }
        .elegant-line {
    margin-top: 0px;
    margin-bottom: 20px;
    border: none;
    height: 1.5px;
background: linear-gradient(to right, transparent, #ff8c00, #ffa500, #ff4500, #ff8c00, transparent);
    position: relative;

    /* Start with no scale and fade-in animation */
    transform-origin: center; /* Set the starting point to the center */
    transform: scaleX(0); /* Initially scale to 0 on the X-axis */
    opacity: 0;
    animation: centerExpand 2.5s ease forwards;
}

/* Keyframes for center expansion and fade-in */
@keyframes centerExpand {
    0% {
        transform: scaleX(0); /* Start as a dot in the center */
        opacity: 0;
    }
    20% {
        transform: scaleX(0); /* Initial fast expansion */
        opacity: 1;
    }
    100% {
        transform: scaleX(1);
        opacity: 0.7; /* Fade slightly */
    }
}

.text-container {
    width:100%;
    position: relative;
    display: inline-block;
    z-index: 1; /* Ensure the text appears above the animation */
}
#deity {
        width: 100%; /* Adjust to full width of parent */
        max-width: 400px; /* Set a max width */
        padding: 15px; /* Add some padding */
        font-family: monospace; /* Change to a modern font */
        font-weight:bold;
        font-size: 1.05em; /* Make text slightly larger */
        color: #333; /* Set text color */
        background-color: #fff; /* White background */
        border: 1px solid #ccc; /* Subtle border */
        border-radius: 5px; /* Rounded corners */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Add slight shadow */
        outline: none; /* Remove focus outline */
        transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Smooth hover effect */
    }

    #deity:focus {
        border-color: #373737; /* Green border on focus */
        box-shadow: 0 0 8px rgba(255, 120, 0, 0.5); /* Add glow */
    }

    /* Option styles (optional for better compatibility) */
    #deity option {
        padding: 10px; /* Padding inside options */
        font-size:1.05em; /* Consistent font size */
    }
    #sungdate {
        width: auto; /* Full width */
        padding: 10px 15px; /* Add padding for better spacing */
        font-family: monospace;
        font-size: 1.05em; /* Slightly larger text */
        color: #333; /* Text color */
        background-color: #fff; /* White background */
        border: 1px solid #ccc; /* Subtle border */
        border-radius: 5px; /* Rounded corners */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Light shadow */
        outline: none; /* Remove default focus outline */
        transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Smooth hover/focus effects */
    }

    #sungdate:focus {
        border-color: #373737; /* Green border on focus */
        box-shadow: 0 0 8px rgba(255, 120, 0, 0.5); /* Add glow */
    }

    /* Style for calendar button (optional, depends on browser) */
    #sungdate::-webkit-calendar-picker-indicator {
        cursor: pointer; /* Change cursor to pointer */
        color: #373737; /* Optional: color for the calendar icon */
    }

#lottie-animation1 {
    position: absolute;
    width: 20%; /* Fill the container */
    height: 100%;
    transform: scale(1.2);
    z-index: -1; /* Place the animation behind the text */
    pointer-events: none; /* Prevent interaction */

}
#lottie-animation2 {
    position: absolute;
    width: 90%; /* Fill the container */
    height: 100%;
    transform: scale(1.2);
    z-index: -1; /* Place the animation behind the text */
    pointer-events: none; /* Prevent interaction */

}
.decorative-box {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #888;
    border-radius: 15px;
    margin-bottom: 10px;
    font-size: 1.05em;
    font-weight: bold;
    padding: 8px 20px;
    box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.15);
    background-color: #f4f4f4;
    cursor: pointer;
    transition: background-color 0.2s, box-shadow 0.2s;
}

.decorative-box:hover {
    background-color: #e0e0e0;
    box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
}
/* Selected state */
input[type="checkbox"]:checked + .decorative-box {
    background-color: #d1f7d1;
    border-color: #5cb85c;
    box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
}

/* Disabled state for checkboxes and labels */
input[type="checkbox"]:disabled + .decorative-box {
    background-color: #e9e9e9;
    color: #999;
    border-color: #ccc;
    cursor: not-allowed;
    box-shadow: none;
}

/* Hide the actual checkbox */
input[type="checkbox"] {
    display: none;
}

/* Flex container for side-by-side checkboxes */
.flex-container {
    display: flex;
    gap: 10px;
    justify-content: center;
    text-wrap: nowrap;
    margin-bottom: 10px;
}

/* Block container for vertical alignment */
.block-container > div {
    margin-bottom: 10px;
}

/* Parent container to center the flex and block containers */
.center-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}

@media screen and (max-width: 400px) {
    .container {
        min-width: 320px;
        padding: 10px;
    }
    .decorative-box {
    width: 35%;
}
fieldset {
  border: 1px solid #ccc;
  border-radius: 5px;
  padding:2px;
}

.form-check label {
        margin-left: 0px;
        align-items: left;
    }
    
    .form-check {
        margin-left: 100px;
    }
    input[type="text"] {
            width: 90%;
            padding: 10px;
            font-family: monospace;
            font-size: 14px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .autocomplete {
            position: relative;
            display: inline-block;
            width: 80%;
        }
}



        @media (min-width: 401px) {
    .container {
        width: 80%;
        max-width:420px;
        padding: 10px;
    }
    .btn-primary {
        width: 50%;
        padding: 8px;
    }
    .decorative-box {
    width: 25%;
}
    legend {
            background-color: #FFFFFF;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1.4em;
            text-decoration: underline; 
            font-weight: bold;
        }
    input, select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }
    .form-check {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        margin-left: 30px;
    }

    .form-check-fast {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        margin-left: 20px;
    }
    .form-check-slow {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        margin-left: 20px;
    }
    .form-check-med {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        margin-left: 20px;
    }
    .form-check input[type="radio"] {
        margin-right: 0;
        width:15px;
        margin-left: 80px;
    }
    .form-check input[type="checkbox"] {
        margin-right: 0;
        width:15px;
        margin-left: 80px;
    }
    .form-check-fast input[type="radio"] {
        margin-left: 64px;
        width:80px;
        
    }
    .form-check-slow input[type="radio"] {
        margin-left: 64px;
        width:30px;

    }
    .form-check-med input[type="radio"] {
        margin-left: 48px;
        width:60px;

    }
    .form-check label {
        margin-left: -50px;
        align-items: left;
    }
    .form-check-fast label {
        margin-left: 0px;
    }
    .form-check-slow label {
        margin-left: 0px;
    }
    .form-check-med label {
        margin-left: 0px;
    }
}



    </style>
</head>
<body>
    <div class="container">
    <div class="text-container">
    <div id="lottie-animation1"></div>
    <div id="lottie-animation2"></div>
    
        <p class="help-block">ॐ Aum Sri Sai Ram ॐ</p>
        <p id="countdown" class="countdown">__ days to go!</p> <!-- Countdown will display here -->

    <h1>Bhajan Planner</h1>
</div>
        <?php
include "db_connect.php";
date_default_timezone_set('Asia/Kolkata');
// Get today's date
$today = date("Y-m-d");

// Fetch the latest message for today
$result = $mysqli->query("SELECT Message FROM messages_table WHERE MessageDate = '$today' LIMIT 1");
$message = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['Message'] : "";

$mysqli->close();
?>     
        <p style="margin-top:0px"><?php echo htmlspecialchars($message); ?></p> <!-- Display the message here -->
        <div class="elegant-line"></div>

        <form action="/search_keyword_name.php" method="GET">
    <fieldset>
        <legend><b>Search by Name</b></legend>
        <div class="autocomplete">
            <!-- Added name attribute to the input field -->
            <input id="autocompleteInput" name="keyword" type="text" placeholder="Bhajan Name" required>
            <div id="autocompleteList" class="autocomplete-items"></div>
        </div>
        <br><br>
        <p class="help-block">Search bhajans in the database</p>

        <div class="form-group">
            <button id="submit" name="submit" class="btn-primary">Search</button>
        </div>
    </fieldset>
</form>
       <!-- <form action="/search_keyword_deity.php">
            <fieldset>
            <legend>Search for Bhajans</legend>
             <legend>Search by Deity</legend>
                <div class="form-group">
                    <label for="deity">Deity:</label>
                    <select id="deity" name="deity" style="width: 37%; padding: 8px;             font-family: monospace;
">
                            <option value="Ganesha">Ganesha</option>
                        <option value="Guru">Guru</option>
                        <option value="Devi">Devi</option>
                        <option value="Sai">Sai</option>
                        <option value="Sarvadharma">Sarvadharma</option>
                        <option value="Vittala">Vittala</option>
                        <option value="Rama">Rama</option>
                        <option value="Dattatreya">Dattatreya</option>
                        <option value="Krishna">Krishna</option>
                        <option value="Narayana">Narayana</option>
                        <option value="Shiva">Shiva</option>
                        <option value="Srinivasa">Srinivasa</option>
                        <option value="Hanuman">Hanuman</option>
                        <option value="Subramanya">Subramanya</option>
                    </select>
                    <button id="submit" name="submit" class="btn-primary-mob">Search</button>

                </div>
</fieldset>
                
            
        </form>

        <form action="/search_keyword_name.php">
        <fieldset>
        <legend>Search by Name</legend>
                <div class="form-group">
                    <input id="keyword" name="keyword" type="search" style="width: 50%; padding: 8px;             font-family: monospace;
">
                    <p class="help-block">Search bhajans in the database</p>
                </div>
                <div class="form-group">
                    <button id="submit" name="submit" class="btn-primary-mob">Search</button>
                </div>
                </fieldset>
</fieldset><br>
            </form> -->


            <form action="/quick_fix.php">
    <fieldset>
        <legend><b>Quick Search</b></legend>
        <div class="form-group">
            <label for="deity" style="font-size: 1.05em"><b>Choose Deity:</b></label>
            <select id="deity" name="deity" style="width:auto; padding: 10px; font-family: monospace;">
                <option value="">All Deities</option>
                <option value="Ganesha">Ganesha</option>
                <option value="Guru">Guru</option>
                <option value="Devi">Devi</option>
                <option value="Sai">Sai</option>
                <option value="Sarvadharma">Sarvadharma</option>
                <option value="Vittala">Vittala</option>
                <option value="Rama">Rama</option>
                <option value="Dattatreya">Dattatreya</option>
                <option value="Krishna">Krishna</option>
                <option value="Narayana">Narayana</option>
                <option value="Shiva">Shiva</option>
                <option value="Srinivasa">Srinivasa</option>
                <option value="Hanuman">Hanuman</option>
                <option value="Subrahmanya">Subramanya</option>
            </select>
            
        </div>

        
        <div class="flex-container">
    <div>
        <input type="checkbox" id="6bt" name="speeds[]" value="6bt" onclick="handleExclusive('6bt', '7bt')">
        <label for="6bt" class="decorative-box">6 Beat</label>
    </div>
    <div>
        <input type="checkbox" id="7bt" name="speeds[]" value="7bt" onclick="handleExclusive('7bt', '6bt')">
        <label for="7bt" class="decorative-box">7 Beat</label>
    </div>
</div>

<div class="block-container">
    <div>
        <input type="checkbox" id="all" name="speeds[]" value="" onclick="toggleAll()">
        <label for="all" class="decorative-box">All</label>
    </div>
    <div>
        <input type="checkbox" id="slow" name="speeds[]" value="Slow">
        <label for="slow" class="decorative-box">Slow</label>
    </div>
    <div>
        <input type="checkbox" id="medium" name="speeds[]" value="Medium">
        <label for="medium" class="decorative-box">Medium</label>
    </div>
    <div>
        <input type="checkbox" id="mfast" name="speeds[]" value="Mfast">
        <label for="mfast" class="decorative-box">Medium Fast</label>
    </div>
    <div>
        <input type="checkbox" id="fast" name="speeds[]" value="Fast">
        <label for="fast" class="decorative-box">Fast</label>
    </div>
    <div>
        <input type="checkbox" id="thirdspeed" name="speeds[]" value="Third Speed">
        <label for="thirdspeed" class="decorative-box">Third Speed</label>
    </div>
</div>

        <div class="form-group">
            <button id="submit" name="submit" class="btn-primary">Search</button>
        </div>
    </fieldset><br>
</form>

        <form action="/show_bhajans.php">
            <fieldset>
                <legend><b>Bhajans Sung On</b></legend>
                <div class="form-group">
                    
                <input type="date" id="sungdate" name="sungdate" 
                    value="<?php echo date('Y-m-d'); ?>" 
                    max="<?php echo date('Y-m-d'); ?>" 
                    required>
                    
                    <p class="help-block">Select the date</p>
                </div>
                
                <div class="form-group">
                    <button id="submit" name="submit" class="btn-primary">Search</button>
                </div>
            </fieldset><br>
        </form>

        

        <form action="login.php" method="POST">
            <fieldset>
                <legend><b>Administration</b></legend>
                <input id="uname" name="uname" placeholder="Username" style="width: 30%; padding: 8px;             font-family: monospace;
"><br><br>
                <input id="passwd" name="passwd" type="password" placeholder="Password" style="width: 30%; padding: 8px;             font-family: monospace;
"><br><br>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn-primary">Login</button>
                </div>
            </fieldset><br>
        </form>

        <?php $mysqli->close(); ?>
    </div>
</body>
</html>