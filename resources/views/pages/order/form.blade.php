<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<h2>Оформлення замовлення</h2>
<meta name="csrf-token" content="{{ csrf_token() }}">

<form id="orderForm">   

    <!-- Car information -->
    @if ($activeCar)
        <p style="margin-bottom: 15px;">Авто: {{ $activeCar->company }} {{ $activeCar->model }}   <a href="{{ route('cars.index') }}" style="color: #008CBA;">Оберіть інше авто</a>.</p>
    @else
        <!-- Якщо немає активного автомобіля, виведіть повідомлення із посиланням на вибір автомобіля -->
        <p>Немає активного автомобіля. <a href="{{ route('cars.index') }}" style="color: #008CBA;">Оберіть авто тут</a>.</p>
    @endif

    @if (session()->has('activeServiceId'))
        @php
            // Отримайте ідентифікатор послуги з сесії
            $serviceId = session('activeServiceId');
            
            // Знайдіть відповідний запис сервісу в базі даних
            $service = \App\Models\Service::find($serviceId);
        @endphp
        @if ($service)
            <p style="margin-bottom: 15px;">Вибрана послуга: {{ $service->service }}   <a href="{{ route('services') }}" style="color: #008CBA;">Передумали?</a></p>
        @else
            <!-- Якщо послуга не знайдена, виведіть повідомлення про помилку -->
            <p>Помилка: Не вдалося знайти інформацію про послугу.</p>
        @endif
    @else
        <!-- Якщо послуга не вибрана, виводимо повідомлення з посиланням на вибір послуги -->
        <p>Послуга не вибрана. <a href="{{ route('services') }}" style="color: #008CBA;">Оберіть послугу тут</a>.</p>
    @endif

    <input type="hidden" id="selectedCarId" name="selected_car_id">
    @csrf

    <!-- Date input -->
    <label for="car_date">Оберіть дату для замовлення:</label>
    <img src="https://img.freepik.com/premium-vector/calendar-icon-hand-circles-a-date-on-a-calendar-logo-template-deadline-concept-illustration_168129-210.jpg" class="data-image">
    <input type="date" id="car_date" name="car_date" required>

    <!-- Time input -->
    <label for="car_time">Оберіть час для замовлення:</label>
    <img src="https://img.freepik.com/premium-vector/wrist-watch-logo-icon-design-simple-stock-vector_677591-9.jpg" class="time-image">
    <input type="time" id="car_time" name="car_time" required>
    

    <!-- Type "button" to prevent default form submission -->
    <button type="button" id="submitCarDateTime">Оформити замовлення</button>
</form>


 
<style>
    /* Оберіть потрібний фон */
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Заголовок форми */
    h2 {
        color: #1e434c;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Стилі для форми */
    form {
        max-width: 400px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Стилі для міток */
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

    /* Стилі для введення дати і часу */
    input[type="date"],
    input[type="time"] {
        width: calc(100% - 40px); /* Віднімаємо ширину іконки */
        padding: 10px;
        margin-bottom: 16px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    /* Стилі для кнопки */
    button {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        font-size: 18px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        transition: background-color 0.3s;
        width: 100%;
    }

    /* Стилі для кнопки при наведенні */
    button:hover {
        background-color: #45a049;
    }

    /* Стилі для посилань */
    a {
        color: #008CBA;
        text-decoration: none;
    }

    /* Стилі для зображень */
    .icon {
        width: 50px;
        height: auto;
        margin-right: 10px;
        vertical-align: middle;
    }

    /* Контейнер для зображень */
    .icon-container {
        display: inline-block;
        vertical-align: middle;
    }

    /* Стилі для малюнків дати та часу */
    .data-image,
    .time-image {
        width: 50px; /* Змініть розмір за потребою */
        height: auto; /* Автоматично налаштовує висоту відповідно до пропорцій */
    }

    /* Стилі для вмісту навколо зображень */
    .text-around-icon {
        display: inline-block;
        vertical-align: middle;
    }
</style>

<!-- Include jQuery before your script -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    let carDate, carTime;

    $(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const submitCarDateTimeBtn = $('#submitCarDateTime');
    const orderForm = $('#orderForm');

    // Use the 'change' event to capture changes in date and time inputs
    $('#car_date, #car_time').on('change', function () {
        // Remove previous error messages
        removeErrorMessages();

        // Validate or process the values as needed
        validateDateTimeInputs();
    });

    submitCarDateTimeBtn.on('click', function () {
        // Remove previous error messages
        removeErrorMessages();

        // Validate date and time inputs
        if (!validateDateTimeInputs()) {
            return;
        }

        // Create a FormData object and append the necessary fields
        const formData = new FormData();
        formData.append('car_date', $('#car_date').val());
        formData.append('car_time', $('#car_time').val());

        // Send an AJAX request to save the data
        fetch("{{ route('order.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        })
        .then(response => {
            // Check if the request was successful
            if (response.ok) {
                // Redirect to the payment page
                
    window.location.href = `{{ route('payment.show') }}`;
;
            } else {
                // Handle errors or display a message
                console.error('Error:', response.statusText);
                // You may want to handle errors accordingly, e.g., display an error message
            }
        })
        
        .catch(error => {
            console.error('Error:', error.message);
            // Handle errors or display a message
        });
    });

    function validateDateTimeInputs() {
    let isValid = true;

    const carDate = $('#car_date').val();
    const carTime = $('#car_time').val();

    // Validate date and time inputs
    removeErrorMessages(); // Очищаємо попередні помилки

    if (!carDate) {
        displayErrorMessage('car_date', 'Please select a date.');
        isValid = false;
    }

    if (!carTime) {
        displayErrorMessage('car_time', 'Please select a time.');
        isValid = false;
    }

    const selectedTime = moment(carTime, 'HH:mm:ss');
    const startTime = moment('09:00:00', 'HH:mm:ss');
    const endTime = moment('20:00:00', 'HH:mm:ss');
    const currentDateTime = moment(); // Отримуємо поточний час на боці клієнта

    if (selectedTime.isBefore(startTime) || selectedTime.isSameOrAfter(endTime)) {
        displayErrorMessage('car_time', 'Selected time is not available. Please choose a time between 09:00 and 20:00.');
        isValid = false;
    }

    if (currentDateTime.isSameOrAfter(moment(carDate))) {
        displayErrorMessage('car_date', 'Invalid date. Please choose a future date.');
        isValid = false;
    }

    return isValid;
}

function displayErrorMessage(inputId, message) {
    const inputElement = $(`#${inputId}`);
    const errorMessage = `<p class="error-message">${message}</p>`;
    inputElement.after(errorMessage);
}

function removeErrorMessages() {
    $('.error-message').remove();
}
});
</script>