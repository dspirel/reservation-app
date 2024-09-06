<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>
</head>

<body>
    <div>
        <div>
            <button onclick="window.location.href='add-reservation'">New Reservation</button>
        </div>
        <br>
        <h1>TEST</h1>
        <div>
            <form id="date-change" action="/reservationsApp/" method="GET">
                <label for="dpicker">Show reservations on:</label>
                <input name="dpicker" id="dpicker" name="dpicker" type="date">
            </form>
        </div>
        <p>Selected date: <?php if (isset($_GET["dpicker"])) { echo $_GET["dpicker"]; } else { echo "None"; } ?></p>
    </div>
    <div>
        <?php if (isset($data)) include "show-reservations.php"; displayReservations($data);?>
    </div>
    <div>
        <button onclick="window.location.href='logout'">Logout</button>
    </div>
    <script>
        const date_picker = document.getElementById("dpicker");

        date_picker.addEventListener("input", onDateChange);

        function onDateChange(e) {
            document.getElementById("date-change").submit();
            console.log("fasfsafa");
        }
    </script>
</body>

</html>