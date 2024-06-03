<?php

function displayReservations($reservations)
{   
    // echo "<pre>";
    // var_dump($reservations);
    // echo "</pre>";
    if (!empty($reservations)) {

    echo "<table border='1'>";
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Contact</th>";
            echo "<th>Date start</th>";
            echo "<th>Time start</th>";
            echo "<th>Time end</th>";
            echo "<th>Group size</th>";
            echo "<th></th>";
        echo "</tr>";

        foreach ($reservations as $r) {
            echo "<tr>";
                foreach ($r as $k => $i) {
                    if ($k == "time_end") continue;
                    echo "<td>";
                    if ($k == "duration") {
                        echo $r["time_end"];
                    } else {
                        echo $i;
                    }
                    echo "</td>";
                }
            $id = $r['id'];
            echo "<td><button onclick=\"window.location='/reservationsApp/edit-reservation?rid=$id'\">EDIT</button></td>";
            echo "</tr>";
        }
    echo "</table>";
    } else {
        echo "<p>No reservations on selected date.</p>";
    }
}
