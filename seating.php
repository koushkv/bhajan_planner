<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Singer Seating Arrangement</title>

    <style>
        table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-collapse: collapse;
        }
        td {
            padding: 6px;
            text-align: center;
            border: 1px solid #ccc;
            text-transform: capitalize;
        }
        .center {
            text-align: center;
            font-family: monospace;
            text-transform: capitalize;
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
            <tr>
                <td><input type="text"style="width: 40px" name="col1[]"></td>
                <td><input type="text"style="width: 40px" name="col2[]"></td>
                <td> </td>
                <td><input type="text"style="width: 40px" name="col3[]"></td>
                <td><input type="text"style="width: 40px" name="col4[]"></td>
            </tr>
        </table>
        <br>
        <div class="center">
        <label for="dayOfWeek">Select Day of the Week:</label>
            <select id="dayOfWeek">
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
            </div>

            <div class="center"><br>

            
            <label for="timeOfDay">Select Time of Day:</label>
                <select id="timeOfDay">
                    <option value="Morning">Morning</option>
                    <option value="Evening">Evening</option>
                </select>
        </div>
            <br />
            
        <button type="button" class="add-row-btn" onclick="generateOrder()">Generate Singing Order</button><br>
        <div id="singingOrder" class="center order-container"></div><br>
    </form>
    <button type="button" class="add-row-btn" onclick="copySingingOrder()">Copy to clipboard</button>
    <br><br>
    <form action="index.php">
        <div class="form-group">
            <button type="submit" class="btn-primary-mob">Home</button>
        </div>
    </form>


</div>

<script>
   function copySingingOrder() {
    const singingOrderDiv = document.getElementById('singingOrder');
    let textToCopy = '';

    singingOrderDiv.childNodes.forEach(node => {
        if (node.nodeType === Node.ELEMENT_NODE && node.tagName === 'TABLE') {
            const rows = node.querySelectorAll('tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let rowText = '';
                let isEmptyRow = true;

                cells.forEach((cell, index) => {
                    const cellText = cell.innerText.trim();
                    if (cellText) {
                        isEmptyRow = false;
                    }
                    rowText += (index > 0 ? '    ' : '') + cellText; // Use four spaces instead of \t
                });

                if (!isEmptyRow) {
                    textToCopy += rowText + '\n';
                }
            });
        } else {
            textToCopy += node.textContent.trim() + '\n';
        }
    });

    const hiddenTextarea = document.createElement('textarea');
    hiddenTextarea.style.position = 'absolute';
    hiddenTextarea.style.left = '-9999px';
    hiddenTextarea.value = textToCopy;
    document.body.appendChild(hiddenTextarea);
    
    hiddenTextarea.select();
    hiddenTextarea.setSelectionRange(0, 99999);

    try {
        document.execCommand('copy');
        alert('Singing order copied to clipboard!');
    } catch (err) {
        alert('Failed to copy text');
    }
    
    document.body.removeChild(hiddenTextarea);
}


// Automatically convert input text to uppercase
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

    // Define separate schedules for morning and evening
    const schedule = {
        Morning: {
            Monday: ["Ganesha", "Shiva", "Rama", "Devi", "Sarv", "Krishna", "Sai/Guru", "Shiva", "Krishna"],
            Tuesday: ["Ganesha", "Devi", "Rama", "Sarv", "Shiva", "Krish", "Hanu", "Shiva", "Narayana"],
            Wednesday: ["Ganesha", "Krishna", "Shiva", "Rama", "Sarv", "Devi", "Krishna", "Rama/Vitt", "Narayana"],
            Thursday: ["Ganesha", "Guru", "Shiva", "Devi", "Sarv", "Rama", "Krishna", "Shiva", "Rama/Narayana"],
            Friday: ["Ganesha", "Devi", "Rama", "Shiva", "Sarv", "Krishna", "Shiva", "Rama", "Krishna/Narayan"],
            Saturday: ["Ganesha", "Rama", "Krishna", "Sarv", "Devi", "Shiva", "Krishna", "Rama/Vittala", "Shiva"],
            Sunday: ["Ganesha", "Sai", "Shiva", "Sarv", "Devi", "rama", "Narayana", "Shiva", "Vitt/Krishna"]
        },
        Evening: {
            Monday: ["Ganesha","Shiva", "Devi", "Sarv", "Rama", "Vitt", "Shiva", "Sai", "Rama", "Devi", "Krish", "Shiva", "Narayana", "Rama/Sai"],
    Tuesday: ["Ganesha","Rama", "Devi", "Shiva", "Sarv", "Krish", "Guru", "Vitt", "Hanuman", "Venkatesha", "Sai", "Rama", "Krish", "Shiva"],
    Wednesday: ["Ganesha","Krish", "Shiva", "Devi", "Sarv", "Rama", "Vitt", "Shiva", "Narayana", "Rama", "Krish", "Shiva", "Guru/Sai", "Krish"],
    Thursday: ["Ganesha","Guru", "Devi", "Shiva", "Sarv", "Vitt", "Rama", "Narayana", "Sai", "Rama", "Shiva", "Krish", "Shiva", "Krish"],
    Friday: ["Ganesha","Devi", "Rama", "Shiva", "Narayana", "Sarv", "Sai", "Vitt", "Guru", "Rama", "Krish", "Shiva", "Narayana", "Shiva"],
    Saturday: ["Ganesha","Rama", "Krish", "Devi", "Sarv", "Shiva", "Rama", "Narayana", "Hanuman", "Shiva", "Krish", "Rama", "Shiva", "Krish"],
    Sunday: ["Ganesha","Sai", "Shiva", "Sarv", "Krish", "Rama", "Devi", "Vitt", "Rama", "Venkatesha/Guru", "Narayana", "Shiva", "Krish", "Rama"]
        }
    };

    const order = [];
    // Extract current day of the week
    const dayOfWeek = document.getElementById('dayOfWeek').value;
    const timeOfDay = document.getElementById('timeOfDay').value;
    // Access the corresponding array from the schedule based on timeOfDay
    const additionalNames = (schedule[timeOfDay][dayOfWeek]) || [];
   
    let additionalIndex = 0;

    const maxOrderLength = timeOfDay === "Morning" ? 9 : 14;
    let index = 0;
    let cycle = 1;
    let end = 0;

    // First Cycle
    while (order.length < maxOrderLength) {
        do {
            if (col1[index] && col2[index]) {
                order.push(`${col1[index]} ${col2[index]} - ${additionalNames[additionalIndex] || ''}`);
                additionalIndex++;
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }
            if (col3[index] && col4[index]) {
                order.push(`${col3[index]} ${col4[index]} - ${additionalNames[additionalIndex] || ''}`);
                additionalIndex++;
                
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

            if (!col1[index + 1] && !col2[index + 1]) {
                continue;
            } else {
                if (!col2[index + 1]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col1[index + 1]} ${col1[index]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    } else {
                        order.push(`${col1[index + 1]} ${col2[index]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    }
                    // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }
                } else {
                    order.push(`${col1[index + 1]} ${col2[index + 1]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                }
                // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

                if (!col3[index + 1] && !col4[index + 1]) {
                    end = 1;
                    break;
                }
                // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

                if (!col4[index + 1]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col3[index + 1]} ${col3[index]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    } else {
                        order.push(`${col3[index + 1]} ${col4[index]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    }
                    // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }
                } else {
                    order.push(`${col3[index + 1]} ${col4[index + 1]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                }
                
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

            if (!col1[index + 2] && !col2[index + 2]) {
                cycle++;
                continue;
            } else {
                if (!col2[index + 2]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col1[index + 2]} ${col1[index + 1]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    } else {
                        order.push(`${col1[index + 2]} ${col2[index + 1]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    }
                } else {
                    order.push(`${col1[index + 2]} ${col2[index + 2]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                }
                // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

                if (!col3[index + 2] && !col4[index + 2]) {
                    end = 1;
                    break;
                }

                if (!col4[index + 2]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col3[index + 2]} ${col3[index + 1]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    } else {
                        order.push(`${col3[index + 2]} ${col4[index + 1]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    }
                } else {
                    order.push(`${col3[index + 2]} ${col4[index + 2]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                }
                // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }
            }

            if (!col1[index + 3] && !col2[index + 3]) {
                cycle++;
                continue;
            } else {
                if (!col2[index + 3]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col1[index + 3]} ${col1[index + 2]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    } else {
                        order.push(`${col1[index + 3]} ${col2[index + 2]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    }
                } else {
                    order.push(`${col1[index + 3]} ${col2[index + 3]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                }
                // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

                if (!col3[index + 3] && !col4[index + 3]) {
                    end = 1;
                    break;
                }
                // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

                if (!col4[index + 3]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col3[index + 3]} ${col3[index + 2]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    } else {
                        order.push(`${col3[index + 3]} ${col4[index + 2]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                    }
                } else {
                    order.push(`${col3[index + 3]} ${col4[index + 3]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                }
                
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

            cycle++;
        } while (end === 0 && order.length < maxOrderLength);
        cycle = 2;
        while (end === 1 && order.length < maxOrderLength) {
            if (col3[index] && col4[index]) {
                order.push(`${col3[index]} ${col4[index]} - ${additionalNames[additionalIndex] || ''}`);
                additionalIndex++;
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

            if (!col2[index + 1]) {
                if (cycle % 2 !== 0) {
                    order.push(`${col1[index + 1]} ${col1[index]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                    cycle++;
                } else {
                    order.push(`${col1[index + 1]} ${col2[index]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                    cycle++;
                }
            } else {
                order.push(`${col1[index]} ${col2[index]} - ${additionalNames[additionalIndex] || ''}`);
                additionalIndex++;
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

            if (!col3[index + 1] && !col4[index + 1]) {
                order.push(`${col3[index]} ${col4[index]} - ${additionalNames[additionalIndex] || ''}`);
                additionalIndex++;
                end = 0;
                break;
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

            if (!col4[index + 1]) {
                if (cycle % 2 !== 0) {
                    order.push(`${col3[index + 1]} ${col3[index]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                } else {
                    order.push(`${col3[index + 1]} ${col4[index]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                }
            } else {
                order.push(`${col3[index + 1]} ${col4[index + 1]} - ${additionalNames[additionalIndex] || ''}`);
                additionalIndex++;
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

            if (!col2[index + 1]) {
                if (cycle % 2 !== 0) {
                    order.push(`${col1[index + 1]} ${col1[index]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                    cycle++;
                } else {
                    order.push(`${col1[index + 1]} ${col2[index]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                    cycle++;
                }
            } else {
                order.push(`${col1[index + 1]} ${col2[index + 1]} - ${additionalNames[additionalIndex] || ''}`);
                additionalIndex++;
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

            if (!col3[index + 2] && !col4[index + 2]) {
                if (!col2[index + 2]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col1[index + 2]} ${col1[index + 1]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                        end = 0;
                        cycle++;
                        break;
                    } else {
                        order.push(`${col1[index + 2]} ${col2[index + 1]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                        end = 0;
                        cycle++;
                        break;
                    }
                } else {
                    order.push(`${col1[index + 2]} ${col2[index + 2]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                }
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }

            if (!col3[index + 3] && !col4[index + 3]) {
                if (!col2[index + 3]) {
                    if (cycle % 2 !== 0) {
                        order.push(`${col1[index + 3]} ${col1[index + 2]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                        end = 0;
                        cycle++;
                        break;
                    } else {
                        order.push(`${col1[index + 3]} ${col2[index + 2]} - ${additionalNames[additionalIndex] || ''}`);
                        additionalIndex++;
                        end = 0;
                        cycle++;
                        break;
                    }
                } else {
                    order.push(`${col1[index + 3]} ${col2[index + 3]} - ${additionalNames[additionalIndex] || ''}`);
                    additionalIndex++;
                }
            }
            // Break the loop if the order reaches the maxOrderLength
        if (order.length >= maxOrderLength) {
            break;
        }
        }
    }

    const formattedDate = formatDate();
    

    const singingOrderDiv = document.getElementById('singingOrder');
    singingOrderDiv.innerHTML = order.map((pair, idx) => `<p>${idx + 1}. ${pair}</p>`).join('');
    let seatingTableHTML = `
    <table style="border-collapse: collapse; width: 100%;">
        <tbody>
        <h1>${timeOfDay} Bhajans - ${formattedDate}</h1><br>
            ${[...Array(col1.length).keys()].map(i => `
                <tr>
                    <td style="border: 1px solid #000; padding: 8px;">${col1[i] || ''}</td>
                    <td style="border: 1px solid #000; padding: 8px;">${col2[i] || ''}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">${i === 0 ? '🎹' : ''}</td> <!-- Piano icon only in the first row -->
                    <td style="border: 1px solid #000; padding: 8px;">${col3[i] || ''}</td>
                    <td style="border: 1px solid #000; padding: 8px;">${col4[i] || ''}</td>

                    
                </tr>
            `).join('')}
            
        </tbody>
        
    </table><br>
`;
let additionalInfoHTML = `
<br>
    <h5>One 6bt please</h5>
`;

    // Append the seating arrangement table HTML below the singing order
    singingOrderDiv.innerHTML =seatingTableHTML + singingOrderDiv.innerHTML+ additionalInfoHTML;


    
    
}
function formatDate() {
    const today = new Date();
    const day = today.getDate();
    const month = today.toLocaleString('default', { month: 'short' });

    // Add ordinal suffix (st, nd, rd, th) to the day
    const dayWithSuffix = day + (day % 10 == 1 && day != 11 ? "st" : day % 10 == 2 && day != 12 ? "nd" : day % 10 == 3 && day != 13 ? "rd" : "th");

    return `${dayWithSuffix} ${month}`;
}


</script>

</body>
</html>
