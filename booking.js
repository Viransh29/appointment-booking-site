document.addEventListener('DOMContentLoaded', () => {
    const bookingForm = document.getElementById('booking-form');
    const bookingStatus = document.getElementById('booking-status');
    const timeSelect = document.getElementById('time');
    const dateInput = document.getElementById('date');

    // Populate time slots between 10 AM and 8 PM in 12-hour format
    function populateTimeSlots() {
        timeSelect.innerHTML = '';
        const openingHour = 10;
        const closingHour = 20;

        for (let hour = openingHour; hour < closingHour; hour++) {
            const timeOption1 = document.createElement('option');
            timeOption1.value = `${hour}:00`;
            timeOption1.textContent = formatTime(hour, 0);

            const timeOption2 = document.createElement('option');
            timeOption2.value = `${hour}:30`;
            timeOption2.textContent = formatTime(hour, 30);

            timeSelect.appendChild(timeOption1);
            timeSelect.appendChild(timeOption2);
        }
    }

    // Format time into 12-hour format with AM/PM
    function formatTime(hour, minutes) {
        const period = hour >= 12 ? 'PM' : 'AM';
        const adjustedHour = hour % 12 || 12;
        const formattedMinutes = minutes.toString().padStart(2, '0');
        return `${adjustedHour}:${formattedMinutes} ${period}`;
    }

    // Prevent bookings on Mondays
    function isMonday(date) {
        const selectedDate = new Date(date);
        return selectedDate.getDay() === 1;
    }

    // Check if selected date is in the past
    function isPastDate(date) {
        const selectedDate = new Date(date);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        return selectedDate < today;
    }

    // Check for Monday and past date when date is selected
    dateInput.addEventListener('change', () => {
        const selectedDate = dateInput.value;

        if (isMonday(selectedDate)) {
            alert("The salon is closed on Mondays. Please select a different date.");
            dateInput.value = '';
        } else if (isPastDate(selectedDate)) {
            alert("You cannot book an appointment in the past. Please select a future date.");
            dateInput.value = '';
        }
    });

    // Handle booking submission
    bookingForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const selectedDate = dateInput.value;

        if (isMonday(selectedDate)) {
            bookingStatus.textContent = "Sorry, bookings are not available on Mondays.";
            bookingStatus.style.color = "red";
            return;
        } else if (isPastDate(selectedDate)) {
            bookingStatus.textContent = "You cannot book an appointment in the past.";
            bookingStatus.style.color = "red";
            return;
        }

        // Prepare booking details
        const formData = new FormData(bookingForm);

        fetch('send_email.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            bookingStatus.textContent = result;
            bookingStatus.style.color = "green";
            bookingForm.reset();
        })
        .catch(error => {
            console.error('Error:', error);
            bookingStatus.textContent = "There was an error processing your request.";
            bookingStatus.style.color = "red";
        });
    });

    // Populate time slots when the page loads
    populateTimeSlots();
});