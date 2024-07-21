<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Details</title>
</head>
<body>
    <div class="container">
        <form action="view_details.php" method="get">
            Search: <input type="text" name="query" value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>">
            <input type="submit" value="Search">
            Sort by: 
            <select name="sort">
                <option value="name" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'name') echo 'selected'; ?>>Name</option>
                <option value="usn" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'usn') echo 'selected'; ?>>USN</option>
                <option value="phone" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'phone') echo 'selected'; ?>>Phone</option>
            </select>
            <input type="submit" value="Sort">
        </form>

        <h2>View Details</h2>
        <table border="1">
        <!-- Display Records -->
            <tr>
                <th>Name</th>
                <th>USN</th>
                <th>Phone Number</th>
                <th>Delete Record</th>
                <th>Update Record</th>
            </tr>

            <?php
            $conn = new mysqli('localhost', 'root', '', 'wshop');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $search_query = isset($_GET['query']) ? $_GET['query'] : '';
            $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name';

            $sql = "SELECT * FROM students WHERE name LIKE '%$search_query%' OR usn LIKE '%$search_query%' OR phone LIKE '%$search_query%' ORDER BY $sort_by";

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["name"] . "</td>
                            <td>" . $row["usn"] . "</td>
                            <td>" . $row["phone"] . "</td>
                            <td>
                                <form action='delete.php' method='post' class='action-form'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <input type='submit' value='Delete'>
                                </form>
                            </td>
                            <td>
                                <form action='update.php' method='post' class='action-form update-form'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <input type='submit' value='Update'>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='no-records'>No records found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
