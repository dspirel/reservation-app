<body>
    <div id="reservation-form" style="display: block">
        <form action="add-reservation" method="POST">
            <h1>Reservation</h1>

            <label for="last_name"><b>Reservation by:</b></label>
            <input type="text" placeholder="Name" name="last_name" minlength="3" maxlength="50" required value="Ivan">
            <p style="color:red;"> <?php if (!empty($data["last_name"])) echo $data["last_name"] ?> </p>

            <label for="contact_info"><b>Phone:</b></label>
            <input type="number" placeholder="Phone" name="contact_info" minlength="8" maxlength="50" required value="12345678">
            <p style="color:red;"> <?php if (!empty($data["contact_info"])) echo $data["contact_info"] ?> </p>

            <label id="date_start" for="date_start"><b>Date start:</b></label>
            <input type="date" name="date_start" required value="2024-05-10">
            <p style="color:red;"> <?php if (!empty($data["date_start"])) echo $data["date_start"] ?> </p>

            <label for="time_start"><b>Time start (09-21):</b></label>
            <input type="time" step="1" name="time_start" placeholder="12:00" min="09:00" max="22:00" required value="12:00:00">
            <p style="color:red;"> <?php if (!empty($data["time_start"])) echo $data["time_start"] ?> </p>

            <label for="duration"><b>Duration(minutes):</b></label>
            <input type="number" name="duration" placeholder="in minutes" required value="60">
            <p style="color:red;"> <?php if (!empty($data["duration"])) echo $data["duration"] ?> </p>

            <label for="group_size"><b>Group size:</b></label>
            <input type="number" name="group_size" value="1" required>
            <p style="color:red;"> <?php if (!empty($data["group_size"])) echo $data["group_size"] ?> </p>

            <button type="submit">Create</button>
            <button type="button" onclick="window.location='/reservationsApp/'">Close</button>
        </form>
    </div>
</body>