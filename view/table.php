<?php
    //an "if-else" code block that displays HTML elements based on the "$books" array, handling cases where the array is empty or contains one or more items.
    if(count($books) === 0) {
        //Constructing and displaying a "span" tag based on whether values ​​are stored in the associative indices of the "$_SESSION" superglobal variable.
        echo "<span class='messageWarningErrorNoBooks " . ($_SESSION['messageTableBooks']['type'] ?? '') . "'>" . ($_SESSION['messageTableBooks']['text'] ?? 'No books have been added to the library...') . "</span>";
    } else {
        //Displaying opening and closing tags for constructing an HTML table.
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Author(s)</th>";
        echo "<th>Year</th>";
        echo "<th>Status</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        //A "foreach" code block to display all the attributes of the books stored in the "$books" array.
        foreach($books as $bookAttribute) {
            echo "<tr>";
            echo "<td>$bookAttribute[0]</td>";
            echo "<td>$bookAttribute[1]</td>";
            echo "<td>$bookAttribute[2]</td>";
            echo "<td>$bookAttribute[3]</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }