<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bhajans Sung on</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: monospace;
        }
        .container {
            margin: 20px auto;
            background-color: #fff;
            min-width: 400px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 40%;
        }
        .btn-primary, .btn-secondary {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
        }
        .btn-secondary {
            background-color: #008CBA;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .autocomplete-item {
            display: flex;
            justify-content: space-between;
            padding: 4px 8px;
        }
        .autocomplete-item strong {
            flex: 1;
        }
        .autocomplete-item .shruthi,
        .autocomplete-item .last-sung {
            flex: 0.5;
            text-align: right;
        }
    </style>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- jQuery UI JavaScript -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $('.bhajan-input').autocomplete({
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
                select: function(event, ui) {
                    $(this).val(ui.item.label);
                    return false;
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

            // Edit button logic
            $('#editBtn').click(function() {
                var bhajans = $('input[name="bhajan[]"]').map(function() {
                    return $(this).val();
                }).get();

                // Call AJAX to erase the last 10 characters
                $.ajax({
                    url: 'erase_last_sung.php',
                    type: 'POST',
                    data: {
                        bhajans: bhajans
                    },
                    success: function(response) {
                        console.log(response);  // Debugging, optional
                        alert("Last sung date erased for bhajans.");
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <?php
        include "db_connect.php";

        $formatDate = $_GET["sungdate"];
        $date = DateTime::createFromFormat('Y-m-d', $formatDate);
        $readableDate = $date->format('jS M, Y');

        echo "<h2> Bhajans sung on $readableDate </h2>";
        echo "<h2> !!! Press <b>ERASE THE DATE<b> button before editing the bhajans !!!</h2>";
        echo "<h2> !!! Make the changes and submit !!!</h2>";


        $sql = "SELECT BhajanName FROM bhajans_table WHERE LastSungOn LIKE '%" . $mysqli->real_escape_string($formatDate) . "%'";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            echo '<form action="submit_todayslist.php" method="POST">';
            echo '<input type="hidden" name="appendDate" value="'.$formatDate.'">';
            while ($row = $result->fetch_assoc()) {
                echo '<input type="text" name="bhajan[]" value="'.$row['BhajanName'].'" class="bhajan-input" autocomplete="off">';
            }
            echo '<button type="button" id="editBtn" class="btn-secondary" style="margin-right: 10px;">Erase the Date</button>';
echo '<button type="submit" id="submitBtn" class="btn-primary">Submit</button>';

            echo '</form>';
        } else {
            echo "No results found". "<br>";
        }

        $mysqli->close();
        ?><br><br>
        <a href="index.php" class="btn-primary">Return to main page</a>
    </div>
</body>
</html>
