
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let selectedDay = null;
        let events = JSON.parse(localStorage.getItem('events')) || {};

        function generateCalendar(month, year) {
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            document.getElementById("monthName").textContent = monthNames[month];
            document.getElementById("yearDisplay").textContent = year;

            const daysContainer = document.getElementById("daysContainer");
            daysContainer.innerHTML = '';
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement("div");
                emptyCell.classList.add("empty");
                daysContainer.appendChild(emptyCell);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayCell = document.createElement("div");
                dayCell.classList.add("day");
                dayCell.textContent = day;

                const today = new Date();
                if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    dayCell.classList.add("today");
                }

                if (events[`${day}-${month}-${year}`]) {
                    const eventMarker = document.createElement('span');
                    eventMarker.classList.add('event-marker');
                    eventMarker.textContent = ' *';
                    dayCell.appendChild(eventMarker);
                }

                dayCell.addEventListener('click', function() {
                    selectDay(day, month, year, dayCell);
                });

                daysContainer.appendChild(dayCell);
            }
        }

        function selectDay(day, month, year, dayCell) {
            if (dayCell.classList.contains("selected")) {
                dayCell.classList.remove("selected");
                selectedDay = null;
                document.getElementById("createEventBtn").disabled = true;
                document.getElementById("viewEventBtn").style.display = "none";
                document.getElementById("deleteEventBtn").disabled = true;
            } else {
                const previouslySelected = document.querySelector(".selected");
                if (previouslySelected) {
                    previouslySelected.classList.remove("selected");
                }
                dayCell.classList.add("selected");
                selectedDay = day;

                document.getElementById("createEventBtn").disabled = false;
                document.getElementById("selectedDate").textContent = `${day}/${month + 1}/${year}`;

                // Check if there's an event on the selected date
                if (events[`${day}-${month}-${year}`]) {
                    document.getElementById("viewEventBtn").style.display = "inline-block";
                    document.getElementById("deleteEventBtn").disabled = false;
                } else {
                    document.getElementById("viewEventBtn").style.display = "none";
                    document.getElementById("deleteEventBtn").disabled = true;
                }
            }
        }

        function openEventForm() {
            document.getElementById("eventForm").style.display = "block";
            document.getElementById("eventName").value = '';
            document.getElementById("eventDescription").value = '';
        }

        function closeEventForm() {
            document.getElementById("eventForm").style.display = "none";
        }

        function saveEvent() {
            const eventName = document.getElementById("eventName").value;
            const eventDescription = document.getElementById("eventDescription").value;

            if (selectedDay !== null) {
                events[`${selectedDay}-${currentMonth}-${currentYear}`] = {
                    name: eventName,
                    description: eventDescription
                };
                localStorage.setItem('events', JSON.stringify(events));
                generateCalendar(currentMonth, currentYear);
                closeEventForm();
            }
        }

        function viewEventDetails() {
            const event = events[`${selectedDay}-${currentMonth}-${currentYear}`];
            alert(`Event: ${event.name}\nDescription: ${event.description}`);
        }

        function deleteEvent() {
            if (selectedDay !== null) {
                delete events[`${selectedDay}-${currentMonth}-${currentYear}`];
                localStorage.setItem('events', JSON.stringify(events));
                generateCalendar(currentMonth, currentYear);
            }
        }

        function prevMonth() {
            if (currentMonth === 0) {
                currentMonth = 11;
                currentYear--;
            } else {
                currentMonth--;
            }
            generateCalendar(currentMonth, currentYear);
        }

        function nextMonth() {
            if (currentMonth === 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }
            generateCalendar(currentMonth, currentYear);
        }

        function openYearSelector() {
            const dateInput = document.getElementById('yearInput');
            const today = new Date();
            dateInput.value = today.toISOString().split('T')[0]; // ตั้งค่าวันที่เป็นวันนี้
            document.getElementById('yearSelectorModal').style.display = 'block'; // เปิด modal
        }

        function closeYearSelector() {
            document.getElementById('yearSelectorModal').style.display = 'none';
        }

        function selectYearFromInput() {
            const dateInput = document.getElementById('yearInput');
            const selectedDate = new Date(dateInput.value);
            currentYear = selectedDate.getFullYear();
            currentMonth = selectedDate.getMonth();
            generateCalendar(currentMonth, currentYear);
            closeYearSelector();
        }

        // เริ่มต้นปฏิทิน
        generateCalendar(currentMonth, currentYear);