<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                dateFormat: 'yy-mm-dd'
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
            min-width: 390px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 20%;
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
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        legend {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1.2em;
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
        .ui-autocomplete {
            max-width: 400px;
            font-family: monospace;
            font-size: 1em;
            transform: translateX(-40%);
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

        .autocomplete-item.header {
            background-color: lightgrey;
            pointer-events: none;
        }

        .autocomplete-item {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-family: monospace;
            font-size: 1em;
        }

        .autocomplete-item span,
        .autocomplete-item strong {
            flex: 1;
            text-align: center;
        }

        .autocomplete-item strong.bhajan-name {
            text-align: left;
            flex: 2;
        }

        .autocomplete-item span.shruthi,
        .autocomplete-item span.last-sung {
            text-align: center;
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

        .form-check input[type="radio"] {
        margin-right: 110px;

        }
        .form-check-fast input[type="radio"] {
            margin-right: 110px;
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
        

        @media (max-width: 450px) {
    .container {
        width: 90%;
        padding: 10px;
    }
    .btn-primary {
        width: 50%;
        padding: 8px;
    }
    input, select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }
    .ui-autocomplete {
        left: 0 !important;
        transform: translateX(0);
    }
    .form-check {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        margin-left: 20px;
    }

    .form-check-fast {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        margin-left: 20px;
    }
    .form-check input[type="radio"] {
        margin-right: 0;
        width:60px;
        margin-left: 10px;
    }
    .form-check-fast input[type="radio"] {
        margin-left: 64px;
        width:60px;

    }
    .form-check label {
        margin-left: 70px;
    }
    .form-check-fast label {
        margin-left: 70px;
    }
}


    </style>
</head>
<body>
    <div class="container">
        <h1><a href="index.php">PMBG Planner</a></h1>
        <?php include "db_connect.php"; ?>
        <br>

        <form action="/quick_fix.php">
            <fieldset>
                <legend>Quick Fix</legend>
                <div class="form-group">
                    <label for="deity">Choose Deity:</label>
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
                </div>
                <div class="form-check">
                <label for="mfast">Medium Fast</label>

                    <input type="radio" id="mfast" name="speed" value="Mfast">
                </div>
                <div class="form-check-fast">
                <label for="fast">Fast</label>

                    <input type="radio" id="fast" name="speed" value="Fast">
                </div>
                <div class="form-check">
                <label for="thirdspeed">Third Speed</label>

                    <input type="radio" id="thirdspeed" name="speed" value="Third Speed">
                </div>
                <div class="form-group">
                    <button id="submit" name="submit" class="btn-primary">Fix</button>
                </div>
            </fieldset><br>
        </form>

        <form action="/search_keyword_deity.php">
            <fieldset>
                <legend>Search for Bhajans</legend>
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
                    <button id="submit" name="submit" class="btn-primary">Search by Deity</button>

                </div>
                
            
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
                    <button id="submit" name="submit" class="btn-primary">Search</button>
                </div>
                </fieldset>
            </fieldset><br>
            </form>

        <form action="/bhajans_sung_on.php">
            <fieldset>
                <legend>Bhajans Sung On</legend>
                <div class="form-group">
                <label for="sungdate">Select the Date:</label>
                    <input id="datepicker" name="sungdate" required style="width: 25%; padding: 8px;             font-family: monospace;
">
                </div>
                <div class="form-group">
                    <button id="submit" name="submit" class="btn-primary">Search</button>
                </div>
            </fieldset><br>
        </form>

        <form action="/search_all_bhajans.php">
            <fieldset>
                <legend>Resources</legend>
                <div class="form-group">
                    <button id="submit" name="submit" class="btn-primary">Bhajan List</button>
                </div>
            </fieldset><br>
        </form>


        

        <form action="login.php" method="POST">
            <fieldset>
                <legend>Administration</legend>
                <input id="uname" name="uname" placeholder="Username" style="width: 30%; padding: 8px;             font-family: monospace;
"><br><br>
                <input id="passwd" name="passwd" type="password" placeholder="Password" style="width: 30%; padding: 8px;             font-family: monospace;
">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn-primary">Login</button>
                </div>
            </fieldset><br>
        </form>

        <?php $mysqli->close(); ?>
    </div>
</body>
</html>
