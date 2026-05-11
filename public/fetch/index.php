
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,
        FILL,GRAD@20..48,100..700,0..1,-50..200">

<?php include("../templates/header.php"); ?>
<body>
    <div class="calendar-container">
        <header class="calendar-header">
            <p class="calendar-current-date"></p>
            <div class="calendar-navigation">
                <span id="calendar-prev" 
                      class="material-symbols-rounded">
                      <
                </span>
                <span id="calendar-next" 
                      class="material-symbols-rounded">
                      >
                </span>
            </div>
        </header>
        <div class="calendar-body">
            <ul class="calendar-weekdays">
                <li>Sun</li>
                <li>Mon</li>
                <li>Tue</li>
                <li>Wed</li>
                <li>Thu</li>
                <li>Fri</li>
                <li>Sat</li>
            </ul>
            <ul class="calendar-dates"></ul>
        </div>
    </div>
    <script src="script.js"></script>

</body>
<?php include("../templates/footer.php"); ?>

<script>
    let activityMap = {};
    let maxActivity = 0;

    async function getData() {
        let res = await fetch("http://library-tracker.local:8080/fetch/activity.php");
        let data = await res.json();

        data.forEach(item => {
            let book_id = item.book_id;

            let [activity_day, activity_time] = item.activity_date.split(" ");

            console.log("Book ID:", book_id);
            console.log("Day:", activity_day);
            console.log("Time:", activity_time);

            if (!activityMap[activity_day]) {
                activityMap[activity_day] = 0;
            }

            activityMap[activity_day]++;

            if (activityMap[activity_day] > maxActivity) {
                maxActivity = activityMap[activity_day];
            }

        });
        console.log("Activity Map:", activityMap);
        console.log("Max Activity:", maxActivity);

        manipulate();
    }

    getData();
    
    let date = new Date();
    let year = date.getFullYear();
    let month = date.getMonth();

    const day = document.querySelector(".calendar-dates");
    const currdate = document.querySelector(".calendar-current-date");
    const prenexIcons = document.querySelectorAll(".calendar-navigation span");

    const months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
    ];

    let clickedDay = null;
    let selectedDayElement = null;

    const manipulate = () => {
        let dayone = new Date(year, month, 1).getDay();
        let lastdate = new Date(year, month + 1, 0).getDate();
        let dayend = new Date(year, month, lastdate).getDay();
        let monthlastdate = new Date(year, month, 0).getDate();

        let lit = "";

        for (let i = dayone; i > 0; i--) {
            lit += `<li class="inactive">${monthlastdate - i + 1}</li>`;
        }

        for (let i = 1; i <= lastdate; i++) {
            let isToday = (i === date.getDate()
            && month === new Date().getMonth()
            && year === new Date().getFullYear()) ? "active" : ""; // Den dagen som är idag

            let dayString = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            let activityCount = activityMap[dayString] || 0;

            let intensity = activityCount / maxActivity;
            let highlightStyle = "";

            if (activityCount > 0) {
                let opacity = 0.2 + (0.8 * intensity);
                highlightStyle = `style="--activity-bg: rgba(105, 255, 100, ${opacity});"`;
            }

            lit += `
                <li class="${isToday}" data-day="${i}" ${highlightStyle}>
                    <a href="detail.php?date=${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}">${i}</a>
                </li>`;
        }


        for (let i = dayend; i < 6; i++) {
            lit += `<li class="inactive">${i - dayend + 1}</li>`;
        }

        currdate.innerText = `${months[month]} ${year}`;
        day.innerHTML = lit;

        addClickListenersToDays();
    };


    function addClickListenersToDays() {
    const allDays = day.querySelectorAll('li:not(.inactive)');
        allDays.forEach(li => {
            li.addEventListener('click', () => {
            if (selectedDayElement) {
                selectedDayElement.classList.remove('highlight');
            }

            li.classList.add('highlight');
            selectedDayElement = li;

            clickedDay = parseInt(li.getAttribute('data-day'));

            console.log('Clicked day:', clickedDay);
            });
        });
    }

    manipulate();

    prenexIcons.forEach(icon => {
        icon.addEventListener("click", () => {
            month = icon.id === "calendar-prev" ? month - 1 : month + 1;

            if (month < 0 || month > 11) {
                date = new Date(year, month, new Date().getDate());
                year = date.getFullYear();
                month = date.getMonth();
            } else {
                date = new Date();
            }

            clickedDay = null;
            selectedDayElement = null;

            manipulate();
        });
    });

    getData();
</script>