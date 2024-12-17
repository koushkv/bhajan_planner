<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

?>

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
            const targetDate = new Date(today.getFullYear(), 10, 22); // November 22

            // Adjust for if the date has already passed this year
            if (today > targetDate) {
                targetDate.setFullYear(today.getFullYear() + 1);
            }

            const timeDiff = targetDate - today;
            const daysToGo = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

            document.getElementById('countdown').textContent = daysToGo + " days to go!";
        }

        // Run the countdown on load
        updateCountdown();

        // Lottie animation with delay
        setTimeout(function() {
            var animation = lottie.loadAnimation({
                container: document.getElementById('lottie-animation'),
                renderer: 'svg',
                loop: false,
                autoplay: true,
                path: 'birthday.json'
            });
        }, 1500);
    });
    function addNewBhajanField() {
    // Create a new input element for the Bhajan
    const newInput = $('<input>')
        .attr({
            type: 'text',
            name: 'bhajan[]',
            placeholder: 'Enter Bhajan',
        })
        .addClass('autocomplete-bhajan')
        .css({
            marginBottom: '2px',
            width: '65%',
            padding: '8px',
        });

    // Create an element for autocomplete list
    const autocompleteList = $('<div>').addClass('autocomplete-list');

    // Attach autocomplete functionality
    newInput.on('input', function () {
        const term = $(this).val();
        if (term.length > 0) {
            $.ajax({
                url: 'autocomplete.php',
                dataType: 'json',
                data: { term: term },
                success: function (data) {
                    autocompleteList.empty();
                    if (data.length > 0) {
                        // Create a table structure
                        const table = $('<table>').addClass('autocomplete-table');
                        const thead = $('<thead>').append(
                            $('<tr>')
                                .append($('<th>').text('Bhajan Name'))
                                .append($('<th>').text('Shruthi'))
                                .append($('<th>').text('Last Sung'))
                        );
                        table.append(thead);
                        const tbody = $('<tbody>');

                        // Populate the table with data
                        data.forEach(item => {
                            const row = $('<tr>').addClass('autocomplete-item');

                            const nameCell = $('<td>').text(item.label).addClass('bhajan-name');
                            const shruthiCell = $('<td>').text(item.shruthi).addClass('shruthi');
                            const lastSungCell = $('<td>').text(item.lastsungon).addClass('last-sung');

                            row.append(nameCell, shruthiCell, lastSungCell);

                            // Click event to select the item
                            row.on('click', function () {
                                newInput.val(item.label);
                                autocompleteList.empty();
                            });

                            tbody.append(row);
                        });

                        table.append(tbody);
                        autocompleteList.append(table);
                    }
                }
            });
        } else {
            autocompleteList.empty();
        }
    });

    // Close the autocomplete list when clicking outside
    $(document).on('click', function (e) {
        if (!autocompleteList.is(e.target) && !newInput.is(e.target)) {
            autocompleteList.empty();
        }
    });

    // Append the input and autocomplete list to the form
    $('#formFields').append(newInput, autocompleteList);

    // Update the button text
    $('#addButton').text('Add Another Bhajan');
}


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
        .autocomplete-list {
    position: absolute;
    margin-bottom:2px;
    border: none;
    background-color: #fff;
    z-index: 1000;
    max-height: 200px;
    overflow-y: auto;
    width: 85%;
}

.autocomplete-table {
    width: 100%;
    border-collapse: collapse;
}

.autocomplete-table th {
    background-color: #f0f0f0;
    padding: 5px;
    text-align: left;
    font-weight: bold;
    color: black;
}

.autocomplete-table td {
    padding: 5px;
    cursor: pointer;
}

.autocomplete-table tr:hover {
    background-color: #e0e0e0;
}

.bhajan-name {
    flex: 2;
}

.shruthi {
    flex: 1;
    color: #666;
}

.last-sung {
    flex: 1;
    color: #888;
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
    position: relative;
    display: inline-block;
    z-index: 1; /* Ensure the text appears above the animation */
}

#lottie-animation {
    position: absolute;
    width: 100%; /* Fill the container */
    height: 100%;
    transform: scale(1.2);
    z-index: -1; /* Place the animation behind the text */
    pointer-events: none; /* Prevent interaction */
}
.decorative-box {
    display: inline-flex;
    align-items: center;
    border: 1px solid #888;
    border-radius: 15px;
    width: 25%;
    margin-bottom: 10px;
    padding: 5px 10px;
    box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.15);
    background-color: #f4f4f4;
}

@media screen and (max-width: 400px) {
    .container {
        min-width: 323px;
        padding: 10px;
    }
    .decorative-box {
    width: 35%;
}

.form-check label {
        margin-left: 0px;
        align-items: left;
    }
    
    .form-check {
        margin-left: 100px;
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
            font-size: 1.2em;
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
        <p class="help-block">ॐ Aum Sri Sai Ram ॐ</p>
        <p id="countdown" class="countdown">__ days to go!</p> <!-- Countdown will display here -->

    <div class="text-container">
    <div id="lottie-animation"></div>
    <h1>Bhajan Planner</h1>
</div>
        <?php include "db_connect.php"; ?>
        <br>

        
        <div class="elegant-line"></div>


       
        

<!--##################################################### 
#################### REQUIRE LOGIN ######################
##################################################### -->



        <form action="/submit_todayslist.php" method="POST">
        <fieldset>
            <legend>Submit Bhajan List</legend>
            <div id="formFields">
                <div class="form-group">
                    <input type="date" id="appendDate" name="appendDate" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" required style="width: auto; padding: 8px; font-family: monospace;">

<p class="help-block">Select the date</p>
                </div>
            </div>
            <div class="form-group"><br>
                <button type="button" id="addButton" onclick="addNewBhajanField()" class="btn-primary-mob">Add Bhajan</button>
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn-primary-mob">Update</button>
            </div>
        </fieldset><br>
    </form>
        

            
<!--##################################################### 
#################### REQUIRE LOGIN ######################
##################################################### -->

        

        <form action="/logout.php">
            <fieldset>
                <div class="form-group" action="/logout.php">
                    <button id="submit" name="submit" class="btn-primary-mob">Logout</button>
                </div>
            </fieldset><br>
        </form>

        <?php $mysqli->close(); ?>
    </div>
</body>
</html>
