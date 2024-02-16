<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anemia of Chronic Disease Treatment Calendar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" integrity="sha512-MOvpjevC4gDDezgdGjef0f4olSTbr6WMcSkDg4UG1IqMvS5KWJ4DgYhrHLQ0FlDbtUimswWxRcGNxrZ+yy2MGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../style/treatment_style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-VcQnKGMfGlW+pCZ7ZkoGwLWmVmSwpL3L5o6m1Kp1j9o1Xf+OFBBuCDntrRjaQXovJx9RuQlwGJx/UrUVON5wAg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js" integrity="sha512-m2qWwNigY56lj7k3DzAf5DQaW1Lkdj0L9W+XPH2MVpJRsjQDm8Fb7PKqoqmCqlB1zJ0YqUuUVrl7Xz4HKOBLMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <nav>
        <ul>
            <li><a href="home_page.php">Home</a></li>
            <li><a href="symptom_checker.php">Health Condition Checker</a></li>
            <li style="float:right; color:white" class="welcome">Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') : ''; ?></li>
            <li style="float:right"><a href="?logout">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Anemia of Chronic Disease Treatment Calendar</h1>
        <div id="calendar"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    {
                        title: 'Anemia of Chronic Disease Treatment (Iron Supplements)',
                        start: '2024-03-01', // Start date of treatment
                        end: '2024-03-30',   // End date of treatment
                        color: '#1E90FF',    // Color for the event
                        allDay: true         // Full day event
                    }
                    // Add more events as needed
                ]
            });

            calendar.render();
        });
    </script>
</body>
</html>