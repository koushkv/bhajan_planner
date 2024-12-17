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
                path: 'birthday.json' // Adjust the path as necessary
            });
        }, 1500);
    });
        function addNewBhajanField() {
            var newInput = document.createElement("input");
            newInput.type = "text";
            newInput.name = "bhajan[]";
            newInput.placeholder = "Enter Bhajan";
            newInput.style.marginBottom = "10px";
            newInput.style.width = "60%";
            newInput.style.padding = "8px";

            $(newInput).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "autocomplete.php",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(JSON.parse(data));
                        }
                    });
                },
                minLength: 2
            });

            var formFields = document.getElementById("formFields");
            formFields.appendChild(newInput);

            var addButton = document.getElementById("addButton");
            addButton.textContent = "Add Another Bhajan";
        }

        $(function() {
            $('#datepicker1').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: 0
            });
        });

        $(document).ready(function () {
            $('#datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: 0
            });
            
            $('#keyword, #newbhajan, #delbhajan').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "autocomplete.php",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(JSON.parse(data));
                        }
                    });
                },
                minLength: 2,
                focus: function(event, ui) {
                    // Prevent value from being inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    // Set the value of the input to the selected item's label
                    $(this).val(ui.item.label);
                    return false;
                },
                open: function() {
                    // Add custom styling if needed
                    $(this).autocomplete('widget').addClass('custom-autocomplete');
                }
    }).data("ui-autocomplete")._renderMenu = function(ul, items) {
        var that = this;
        ul.append("<div class='autocomplete-item header'><strong class='bhajan-name'>Bhajan</strong><span class='shruthi'>Shruthi</span><span class='last-sung'>Sung</span></div>");
        $.each(items, function(index, item) {
            that._renderItemData(ul, item);
        });
    };
    $.ui.autocomplete.prototype._renderItem = function(ul, item) {
        return $("<li>")
            .append("<div class='autocomplete-item'><strong class='bhajan-name'>" + item.label + "</strong><span class='shruthi'>" + item.shruthi + "</span><span class='last-sung'>" + item.lastsungon + "</span></div>")
            .appendTo(ul);
    };
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
        .btn-primary {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 1em;
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
        .ui-autocomplete {
        max-width: 100%;

        left: 41.25% !important; /* Ensure it's positioned in the center */
        transform: translateX(0%); /* Center the dropdown */
    }

        .autocomplete-item.header {
            background-color: lightgrey;
            pointer-events: none;
            width: 315px;
            text-align: right;
        }

        .autocomplete-item {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-family: monospace;
            font-size: 1em;
            width: 315px; /* Set a fixed width */
            margin: 10 auto; /* Center the autocomplete box */
        }

        .autocomplete-item strong.bhajan-name {
            flex: 2;
            text-align: left; /* Center the text */
        }

        .autocomplete-item span.shruthi,
        .autocomplete-item span.last-sung {
            text-align: right;
            width: 50px; /* Set fixed width for other columns */
        }
        .ui-datepicker {
    left: 50% !important; 
    transform: translateX(-50%);
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
        .countdown {
  font-family: 'Allura', cursive;
  font-size: 1em;
  margin-top:0;
  margin-bottom:0;
  color: #ff4500;
  opacity: 0; /* Start with opacity 0 */
  transition: opacity 2s ease-in-out; /* Smooth fade effect */
  animation: fadeInOut 6s ease-in-out forwards; /* Run animation once */
}

/* Fade-in and fade-out animation */
@keyframes fadeInOut {
  0% {
    opacity: 0;
  }
  25% {
    opacity: 1; /* Fully visible */
  }
  75% {
    opacity: 1; /* Keep visible for a bit */
  }
  100% {
    opacity: 0; /* Fade out */
  }
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


        @media (max-width: 450px) {
    .container {
        width: 80%;
        padding: 10px;
    }
    .btn-primary {
        width: 50%;
        padding: 8px;
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
    .ui-autocomplete {
        max-width: 80%;

        left: -5% !important; /* Ensure it's positioned in the center */
        transform: translateX(20%); /* Center the dropdown */
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
        margin-left: -80px;
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
        <p><?php echo htmlspecialchars($message); ?></p> <!-- Display the message here -->
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
            <div class="form-group">
                <button type="button" id="addButton" onclick="addNewBhajanField()" class="btn-primary-mob">Add Bhajan</button>
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn-primary-mob">Update</button>
            </div>
        </fieldset><br>
    </form>

        <form action="/add_bhajan.php">
            <fieldset>
                <legend>Add a Bhajan</legend>
                <div class="form-group">
                    <label for="newbhajan">Name of the bhajan:</label>
                    <input id="newbhajan" name="newbhajan" type="text" placeholder="Enter the name of the bhajan" required style="width: 47%; padding: 8px; font-family: monospace;"><br>
                </div>
                <div class="form-group">
                    <label for="newshruthi">Shruthi:</label>
                    <select id="newshruthi" name="newshruthi" style="width: 47%; padding: 8px;">
                        <option value=" ">Select</option>
                        <option value="1P">1P</option>
                        <option value="2P">2P</option>
                        <option value="3P">3P</option>
                        <option value="1M">1M</option>
                        <option value="2M">2M</option>
                        <option value="3M">3M</option>
                        <option value="1.5P">1.5P</option>
                        <option value="2.5P">2.5P</option>
                        <option value="1.5M">1.5M</option>
                        <option value="2.5M">2.5M</option>
                        <option value="7P">7P</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="newdeity">Choose Deity:</label>
                    <select id="newdeity" name="newdeity" style="width: 37%; padding: 8px; font-family: monospace;">
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
                </div>
                <div class="form-group">
                    <u><label for="speed">Speed:</label></u><br><br>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="slow" name="speed" value="Slow">
                        <label for="slow">Slow</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input type="radio" id="medium" name="speed" value="Medium">
                        <label for="medium">Medium</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input type="radio" id="mfast" name="speed" value="Mfast">
                        <label for="mfast">Medium Fast</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input type="radio" id="fast" name="speed" value="Fast">
                        <label for="fast">Fast</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input type="radio" id="thirdspeed" name="speed" value="Third Speed">
                        <label for="thirdspeed">Third Speed</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lyrics">Lyrics:</label>
                    <textarea id="lyrics" name="lyrics" rows="10" cols="50" style="width: 80%; padding: 8px; font-family: monospace;" placeholder="Enter lyrics here..."></textarea>
                </div>
                <div class="form-group">
                    <button id="submit" name="submit" class="btn-primary-mob">Add a new bhajan</button>
                </div>
            </fieldset><br>
        </form>


        

        <form action="/delete_bhajan.php">
            <fieldset>
                <legend>Remove Bhajan</legend>
                <div class="form-group">
                    <label for="delbhajan">Name of the bhajan:</label>
                    <input id="delbhajan" name="delbhajan" type="text" placeholder="Enter bhajan" required style="width: 47%; padding: 8px;             font-family: monospace;
"><br>
                </div>
                <div class="form-group">
                    <button id="submit" name="submit" class="btn-primary-mob">Remove</button>
                </div>
            </fieldset><br>
        </form>

<!--##################################################### 
#################### REQUIRE LOGIN ######################
##################################################### -->

<form action="/notice.php">
            <fieldset>
                <legend>Post a Note</legend>
                <div class="form-group">
                    <button id="submit" name="submit" class="btn-primary-mob">Write</button>
                </div>
                <p class="help-block">Add a note on the bhajan list page to indicate if the bhajans are by the Parthi Yatra group</p>

            </fieldset><br>
        </form>

        

        <form action="/index.php">
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
