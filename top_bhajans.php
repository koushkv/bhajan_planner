<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Visitor Tracking</title>
</head>
<style>
    body {
        background-color: #f2f2f2;
        font-family: monospace;
        margin: 0;
        padding: 0;
    }

    .container {
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 90%;
        width: 800px;
    }

    h1 {
        font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
        font-size: 2em;
        margin-top: 20px;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        overflow-x: auto;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        font-family: monospace;
        font-size: 1em; /* Set font size to 1em */
    }

    th {
        background-color: #535353;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .pagination {
        margin-top: 15px;
    }

    .pagination a, .pagination .current-page {
        margin: 0 5px;
        padding: 5px 10px;
        text-decoration: none;
        color: #333;
        border-radius: 3px;
    }

    .pagination .current-page {
        font-weight: bold;
        color: white;
        background-color: #333;
    }

    .page-indicator {
        margin-top: 10px;
        font-size: 0.9em;
        color: #666;
    }

    /* Responsive adjustments for mobile */
    @media (max-width: 450px) {
        .container {
            padding: 10px;
            width: 100%;
        }

        /* Mobile-friendly table */
        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
            width: 100%;
            border: none;
        }

        th, td {
            padding: 10px;
            font-size: 0.9em;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination a, .pagination .current-page {
            margin: 2px;
            padding: 5px;
            font-size: 0.9em;
        }
    }
  
</style>
<body>
    <div class="container">
        <h1>Visitor Stats</h1>

        <?php
        // Enable error reporting
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        include 'db_connect.php';

        // Set the number of results per page
        $resultsPerPage = 15;

        // Determine the current page number
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $resultsPerPage;

        // Query to fetch visitor data, including CountryCode, ordered by VisitDate descending with pagination
        $sql = "SELECT IP, PageVisited, OS, CountryCode, VisitDate FROM visitor_stats ORDER BY VisitDate DESC LIMIT ? OFFSET ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $resultsPerPage, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table class='visitor-table'>";
            echo "<thead><tr><th>IP</th><th>Page Visited</th><th>OS</th><th>Country</th><th>Date and Time</th></tr></thead>";
            echo "<tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td data-label='IP'>" . htmlspecialchars($row['IP']) . "</td>";
                echo "<td data-label='Page Visited'>" . htmlspecialchars($row['PageVisited']) . "</td>";
                echo "<td data-label='OS'>" . htmlspecialchars($row['OS']) . "</td>";
                echo "<td data-label='Country'>" . htmlspecialchars($row['CountryCode']) . "</td>";
                echo "<td data-label='Time'>" . htmlspecialchars($row['VisitDate']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No data found.</p>";
        }

        // Get the total number of records to calculate the total pages
        $countQuery = "SELECT COUNT(*) as total FROM visitor_stats";
        $countResult = $mysqli->query($countQuery);
        $totalRows = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalRows / $resultsPerPage);

        // Pagination links
        if ($totalPages > 1) {
            echo "<div class='pagination'>";
            
            // Display previous page link if not on the first page
            if ($page > 1) {
                echo "<a href='?page=" . ($page - 1) . "'>&laquo;</a> ";
            }

            if ($totalPages <= 10) {
                // If total pages are less than or equal to 10, show all pages
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $page) {
                        echo "<span class='current-page'>$i</span> ";
                    } else {
                        echo "<a href='?page=$i'>$i</a> ";
                    }
                }
            } else {
                // If more than 10 pages, limit the displayed pages
                if ($page <= 6) {
                    // Display first 10 pages if on or near the start
                    for ($i = 1; $i <= 10; $i++) {
                        if ($i == $page) {
                            echo "<span class='current-page'>$i</span> ";
                        } else {
                            echo "<a href='?page=$i'>$i</a> ";
                        }
                    }
                    echo "<span>...</span> <a href='?page=$totalPages'>$totalPages</a>";
                } elseif ($page > 6 && $page <= $totalPages - 5) {
                    // Display "..." around the current page if in the middle range
                    echo "<a href='?page=1'>1</a> <span>...</span> ";
                    for ($i = $page - 4; $i <= $page + 4; $i++) {
                        if ($i == $page) {
                            echo "<span class='current-page'>$i</span> ";
                        } else {
                            echo "<a href='?page=$i'>$i</a> ";
                        }
                    }
                    echo "<span>...</span> <a href='?page=$totalPages'>$totalPages</a>";
                } else {
                    // Display last 10 pages if near the end
                    echo "<a href='?page=1'>1</a> <span>...</span> ";
                    for ($i = $totalPages - 9; $i <= $totalPages; $i++) {
                        if ($i == $page) {
                            echo "<span class='current-page'>$i</span> ";
                        } else {
                            echo "<a href='?page=$i'>$i</a> ";
                        }
                    }
                }
            }

            // Display next page link if not on the last page
            if ($page < $totalPages) {
                echo " <a href='?page=" . ($page + 1) . "'>&raquo;</a>";
            }

            echo "</div>";
        }

        // Display current page number just below the pagination links
        echo "<p class='page-indicator'>Currently on page $page of $totalPages</p>";

        // Close the database connection
        $stmt->close();
        $mysqli->close();
        ?>
    </div>
</body>
</html>
