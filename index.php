<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Bhajan Planner</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- jQuery UI JavaScript -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
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
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            margin-left: 110px;
        }
        .form-check-fast {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            margin-left: 110px;

        }
        .form-check-slow {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            margin-left: 110px;

        }
        .form-check-med {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            margin-left: 110px;

        }

        .form-check input[type="radio"] {
        margin-right: 110px;
        width: 15px;

        }
        .form-check-fast input[type="radio"] {
                margin-right: 110px;
                width: 15px;
        }
        .form-check-slow input[type="radio"] {
                margin-right: 110px;
                width: 15px;
        }
        .form-check-med input[type="radio"] {
                margin-right: 110px;
                width: 15px;
        }
        .form-check div {
            display: flex;
            align-items: center;
        }
        .form-check label {
            margin-left: 0;
        }

        fieldset {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h1 {
            font-family: 'Palatino Linotype', serif; /* Change this to your desired font */
            font-size: 2em; /* You can adjust the size */
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
        <h1>Bhajan Planner</h1>
        <?php include "db_connect.php"; ?>
        <br>

        
        <div class="form-group">✦
    <input id="keyword" name="keyword" type="search" 
           placeholder="Enter the bhajan name" 
           style="width: 50%; padding: 8px; font-family: monospace;">  ✦
    <p class="help-block">Search bhajans in the database</p>
</div>
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
            <label for="deity"><b>Choose Deity:</b></label>
            <select id="deity" name="deity" style="width: 37%; padding: 8px; font-family: monospace;">
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

        <div class="form-check form-check-inline">
            <input type="radio" id="all" name="speed" value="" checked>
            <label for="all">All</label>
        </div>

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
        <br>
        <div class="form-group">
            <button id="submit" name="submit" class="btn-primary-mob">Search</button>
        </div>
    </fieldset><br>
</form>

        <form action="/show_bhajans.php">
            <fieldset>
                <legend>Bhajans Sung On</legend>
                <div class="form-group">
                    <input id="datepicker" name="sungdate" required readonly style="width: 25%; padding: 8px; font-family: monospace;">
                    <p class="help-block">Select the date</p>
                </div>
                
                <div class="form-group">
                    <button id="submit" name="submit" class="btn-primary-mob">Search</button>
                </div>
            </fieldset><br>
        </form>

        <!-- <form action="/search_all_bhajans.php">
            <fieldset>
                <legend>Resources</legend>
                <div class="form-group">
                    <button id="submit" name="submit" class="btn-primary-mob">Bhajan List</button>
                </div>
            </fieldset><br>
        </form> -->


        

        <form action="login.php" method="POST">
            <fieldset>
                <legend>Administration</legend>
                <input id="uname" name="uname" placeholder="Username" style="width: 30%; padding: 8px;             font-family: monospace;
"><br><br>
                <input id="passwd" name="passwd" type="password" placeholder="Password" style="width: 30%; padding: 8px;             font-family: monospace;
"><br><br>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn-primary-mob">Login</button>
                </div>
            </fieldset><br>
        </form>

        <?php $mysqli->close(); ?>
    </div>
</body>
</html>
