<?php include("../templates/header.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,
        FILL,GRAD@20..48,100..700,0..1,-50..200">
    </head>

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
</html>
<?php include("../templates/footer.php"); ?>
<style>
    * {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        color: white !important;
    }

    body {
        display: flex;
        background: #edecec;
        min-height: 100vh;
        padding: 0 10px;
        align-items: center;
        justify-content: center;
    }

    .calendar-container {
        background: #484747;
        width: 320px;                
        border-radius: 10px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .calendar-container header {
        display: flex;
        align-items: center;
        padding: 15px 20px 8px;     
        justify-content: space-between;
    }

    header .calendar-navigation {
        display: flex;
    }

    header .calendar-navigation span {
        height: 30px;              
        width: 30px;
        margin: 0 2px;
        cursor: pointer;
        text-align: center;
        line-height: 30px;
        border-radius: 50%;
        user-select: none;
        color: #aeabab;
        font-size: 1.4rem;          
    }

    .calendar-navigation span:last-child {
        margin-right: -8px;
    }

    header .calendar-navigation span:hover {
        background: #f2f2f2;
    }

    header .calendar-current-date {
        font-weight: 500;
        font-size: 1.2rem;        
    }

    .calendar-body {
        padding: 10px;     
    }

    .calendar-body ul {
        list-style: none;
        flex-wrap: wrap;
        display: flex;
        text-align: center;
    }

    .calendar-body .calendar-dates {
        margin-bottom: 10px;    
        width: 100%;
    }

    .calendar-body li {
        width: calc(100% / 7);
        height: 30px;               
        line-height: 30px;          
        font-size: 0.9rem;          
        color: #414141;
        margin-top: 20px;           
        position: relative;
        z-index: 1;
        cursor: pointer;
        text-align: center;
        box-sizing: border-box;
    }

    .calendar-body .calendar-weekdays li {
        cursor: default;
        font-weight: 500;
        font-size: 0.85rem;         
    }

    .calendar-dates li.inactive {
        color: #aaa;
        cursor: default;
    }

    .calendar-dates li.active {
        color: #fff;
    }
    .calendar-dates li::before {
        position: absolute;
        content: "";
        z-index: -1;
        top: 50%;
        left: 50%;
        width: 30px;             
        height: 30px;
        border-radius: 50%;
        transform: translate(-50%, -50%);
    }

    .calendar-dates li.active::before {
        background: #6964ff;
    }

    .calendar-dates li:not(.active):not(.highlight):hover::before {
        background: #858484;
    }

    .calendar-dates li.highlight {
        background: transparent !important;          
        border: 2px dotted #38f3b1 !important;       
        border-radius: 50%;                           
        position: relative;
        z-index: 10;
        height: 30px;
        line-height: 30px;
        text-align: center;
        width: calc(100% / 7);
    }
</style>
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
            && year === new Date().getFullYear()) ? "active" : "";

            let dayString = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            let activityCount = activityMap[dayString] || 0;

            let intensity = activityCount / maxActivity;
            let highlightStyle = "";

            if (activityCount > 0) {
                let opacity = 0.2 + (0.8 * intensity);
                highlightStyle = `style="background-color: rgba(105, 255, 100, ${opacity}); border-radius:50%;"`;
            }

            lit += `<li class="${isToday}" data-day="${i}" ${highlightStyle}>${i}</li>`;
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

    get_Data();
</script>