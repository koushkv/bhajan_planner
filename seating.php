<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Singer Seating Arrangement</title>
    <style>
        table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-collapse: collapse;
        }
        td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ccc;
            text-transform: capitalize;
        }
        .center {
            text-align: center;
            font-family: monospace;
            text-transform: capitalize;
        }
        .add-row-btn {
            display: block;
            margin: 10px auto;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-family: monospace;
        }
        .add-row-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    
    <?php include "db_connect.php";
?>
<div class="center">
    <h2>Singer Seating Arrangement</h2>
    <form id="singerForm">
        <table id="singerTable">
            <tr>
                <td><input type="text" style="width: 40px" name="col1[]"></td>
                <td><input type="text"style="width: 40px" name="col2[]"></td>
                <td>🎹</td>
                <td><input type="text"style="width: 40px" name="col3[]"></td>
                <td><input type="text"style="width: 40px" name="col4[]"></td>
            </tr>
            <tr>
                <td><input type="text"style="width: 40px" name="col1[]"></td>
                <td><input type="text"style="width: 40px" name="col2[]"></td>
                <td> </td>
                <td><input type="text"style="width: 40px" name="col3[]"></td>
                <td><input type="text"style="width: 40px" name="col4[]"></td>
            </tr>
            <tr>
                <td><input type="text"style="width: 40px" name="col1[]"></td>
                <td><input type="text"style="width: 40px" name="col2[]"></td>
                <td> </td>
                <td><input type="text"style="width: 40px" name="col3[]"></td>
                <td><input type="text"style="width: 40px" name="col4[]"></td>
            </tr>
        </table>
        <br>
        <button type="button" class="add-row-btn" onclick="generateOrder()">Generate Singing Order</button>
    </form>
    <h3>Singing Order:</h3>
    <div id="singingOrder"></div>
    <button type="button" class="add-row-btn" onclick="copySingingOrder()">Copy to clipboard</button>

</div>

<script>
    function copySingingOrder() {
        const singingOrderDiv = document.getElementById('singingOrder');
        const range = document.createRange();
        range.selectNode(singingOrderDiv);
        window.getSelection().removeAllRanges(); // Clear current selection
        window.getSelection().addRange(range); // Select the text
        try {
            document.execCommand('copy');
            alert('Singing order copied to clipboard!');
        } catch (err) {
            alert('Failed to copy text');
        }
        window.getSelection().removeAllRanges(); // Deselect the text
    }
    
    document.querySelectorAll('input[type="text"]').forEach(input => {
        input.addEventListener('input', (event) => {
            event.target.value = event.target.value.toUpperCase();
        });
    });

    function generateOrder() {
        const form = document.getElementById('singerForm');
        const formData = new FormData(form);

        const col1 = formData.getAll('col1[]');
        const col2 = formData.getAll('col2[]');
        const col3 = formData.getAll('col3[]');
        const col4 = formData.getAll('col4[]');

        const order = [];
        let index = 0;
        let cycle=1;
        let end=0;

        // First Cycle
        while (order.length < 8) {

            do{
                if (col1[index] && col2[index]) {
                    order.push(`${col1[index]} ${col2[index]}`);
                }
                if (col3[index] && col4[index]) {
                    order.push(`${col3[index]} ${col4[index]}`);
                }

                if (!col1[index+1] && !col2[index+1]){
                    continue;
                } else {

                    if (!col2[index + 1]) {             //Only one fellow is there?
                        if (cycle % 2 !== 0) {          //Which cycle is it?
                            order.push(`${col1[index + 1]} ${col1[index]}`);
                        } else {
                            order.push(`${col1[index + 1]} ${col2[index]}`);
                        }
                    } else {                            //BOth are there
                        order.push(`${col1[index + 1]} ${col2[index + 1]}`);
                    }
    
                    if (!col3[index+1] && !col4[index+1]){
                        end=1;
                        break;
                    }
    
                    if (!col4[index + 1]) {
                        if (cycle % 2 !== 0) {
                            order.push(`${col3[index + 1]} ${col3[index]}`);
                        } else {
                            order.push(`${col3[index + 1]} ${col4[index]}`);
                        }
                    } else {
                        order.push(`${col3[index + 1]} ${col4[index + 1]}`);
                    }

                }

                if (!col1[index+2] && !col2[index+2]){
                    cycle++;
                    continue;
                } else {

                    if (!col2[index + 2]) {             //Only one fellow is there?
                        if (cycle % 2 !== 0) {          //Which cycle is it?
                            order.push(`${col1[index + 2]} ${col1[index+1]}`);
                        } else {
                            order.push(`${col1[index + 2]} ${col2[index+1]}`);
                        }
                    } else {                            //BOth are there
                        order.push(`${col1[index + 2]} ${col2[index + 2]}`);
                    }
    
                    if (!col3[index+2] && !col4[index+2]){
                        end=1;
                        break;
                    }
    
                    if (!col4[index + 2]) {
                        if (cycle % 2 !== 0) {
                            order.push(`${col3[index + 2]} ${col3[index+1]}`);
                        } else {
                            order.push(`${col3[index + 2]} ${col4[index+1]}`);
                        }
                    } else {
                        order.push(`${col3[index + 2]} ${col4[index + 2]}`);
                    }

                }
                
            
                
                cycle++;

            }while(end===0 && order.length < 8);
            cycle=2;
            while(end===1 && order.length < 8){
                
                if (col3[index] && col4[index]) {
                    order.push(`${col3[index]} ${col4[index]}`);
                }


                if (!col2[index + 1]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col1[index + 1]} ${col1[index]}`);
                        cycle++;
                    } else {
                        order.push(`${col1[index + 1]} ${col2[index]}`);
                        cycle++;
                    }
                } else {
                    order.push(`${col1[index]} ${col2[index]}`);
                }

                if(!col3[index+1] && !col4[index+1]){
                    order.push(`${col3[index]} ${col4[index]}`);
                    end=0;
                    break;

                }

                if (!col4[index + 1]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col3[index + 1]} ${col3[index]}`);
                    } else {
                        order.push(`${col3[index + 1]} ${col4[index]}`);
                    }
                } else {
                    order.push(`${col3[index+1]} ${col4[index+1]}`);
                }

                if (!col2[index + 1]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col1[index + 1]} ${col1[index]}`);
                        cycle++;
                    } else {
                        order.push(`${col1[index + 1]} ${col2[index]}`);
                        cycle++;
                    }
                } else {
                    order.push(`${col1[index+1]} ${col2[index+1]}`);
                }

                if(!col3[index+2] && !col4[index+2]){

                    if (!col2[index + 2]) {
                        if (cycle % 2 !== 0) {
                            order.push(`${col1[index + 2]} ${col1[index+1]}`);
                            end=0;
                            cycle++;
                            break;
                        } else {
                            order.push(`${col1[index + 2]} ${col2[index+1]}`);
                            end=0;
                            cycle++;
                            break;
                        }
                    } else {
                        order.push(`${col1[index+2]} ${col2[index+2]}`);
                    }
                }
                


            }

            
        }
    
        index = 0;

        // Second Cycle
        /*while (order.length < 8) {
            if (col1[index] && col2[index]) {
                order.push(`${col1[index]} ${col2[index]}`);
            }
            if (col3[index] && col4[index]) {
                order.push(`${col3[index]} ${col4[index]}`);
            }
            if (col1[index + 1] && !col2[index + 1]) {
                order.push(`${col1[index + 1]} ${col2[index]}`);
            }
            if (col3[index + 1] && col4[index + 1]) {
                order.push(`${col3[index + 1]} ${col4[index + 1]}`);
            }
            index++;
            if (index >= col1.length && index >= col2.length && index >= col3.length && index >= col4.length) {
                index = 0;
            }
        }*/

        const singingOrderDiv = document.getElementById('singingOrder');
        singingOrderDiv.innerHTML = order.map((pair, idx) => `<p>${idx + 1}. ${pair}</p>`).join('');
    }
</script>

</body>
</html>
