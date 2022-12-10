<?php
/*
if (isset($_SESSION['email'])) {
echo '<table border="1">
    <thead>
        <tr>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>Mileage</th>
            <th>Action</th>
        </tr>
    </thead>';
    foreach ($rows as $row) {
    echo "<tr>
        <td>";
            echo ($row['make']);
            echo ("</td>
        <td>");
            echo ($row['model']);
            echo "
        <td>";
            echo ($row['year']);
            echo ("</td>
        <td>");
            echo ($row['mileage']);
            echo ("</td>
        <td>");
            echo ('<a href="edit.php?autos_id=' . $row['autos_id'] . '">Edit</a> / ');
            echo ('<a href="delete.php?autos_id=' . $row['autos_id'] . '">Delete</a>');
            echo ("</td>
    </tr>\n");
    echo ("</td>
    </tr>\n");
    }
    echo "
</table>";
echo "<a href="add.php">Add New Entry</a>";
}*/
header("Location: ./index.php") 
?>