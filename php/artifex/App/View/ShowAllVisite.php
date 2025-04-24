<?php
$title='Visite';
require 'header.php';
?>
<div class="content">
    <br>
    <br>
    <table>
        <tr>
            <th>Brand</th>
            <th>Model</th>
            <th>Screen Size</th>
            <th>Storage (GB)</th>
            <th>RAM (GB)</th>
            <th>OS</th>
            <th>Price ($)</th>
            <th>Release Date</th>
        </tr>

        <?php
        /** @var $tablets $tablet */
        foreach ($tablets as $tablet) {
        echo "<tr>
            <td>{$tablet['Brand']}</td>
            <td>{$tablet['Model']}</td>
            <td>{$tablet['ScreenSize']}</td>
            <td>{$tablet['StorageGB']}</td>
            <td>{$tablet['RAMGB']}</td>
            <td>{$tablet['OS']}</td>
            <td>{$tablet['Price']}</td>
            <td>{$tablet['ReleaseDate']}</td>
        </tr>";
        }
        echo "</table>";
        echo "</div>";
    require 'footer.php';
    ?>

