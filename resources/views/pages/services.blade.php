<!-- Services Tab -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="services" class="tab-content">
    <h2 class="tab-title">Послуги для вашого авто</h2>
    <!-- Фото -->
    <div class="service-image-container">
        <img src="https://png.pngtree.com/thumb_back/fw800/background/20230411/pngtree-car-repair-service-image_2364299.jpg" class="service-image">
    </div>
    <!-- Перелік послуг -->
    <div class="service-selection">

        <!-- Ваші послуги з можливістю вибору -->
        @foreach($services as $service)
        <div class="service-block">
            <h3 class="service-title">{{ $service->service }}</h3>
            <p class="service-description">{{ $service->description }}</p>
            <p class="service-price">Ціна: {{ $service->price }} грн</p>
            <a href="javascript:void(0);" onclick="setServiceIdAndSubmit({{ $service->id }})" class="order-button">Замовити</a>
        </div>
        <input type="hidden" name="serviceId" id="serviceIdInput">
        @endforeach
    </div>
</div>
<style>
    #services {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: flex-start;
        gap: 20px;
        padding: 20px;
        background-color: #f4f4f4;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .tab-title {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    .service-selection {
        width: 100%;
        text-align: center;
        margin-bottom: 20px;
    }

    .service-block {
        width: 300px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #fff;
        transition: transform 0.3s ease-in-out;
        margin-bottom: 20px;
    }

    .service-block:hover {
        transform: scale(1.05);
    }

    .service-block h3 {
        font-size: 20px;
        color: #1e434c;
        margin-bottom: 10px;
    }

    .service-block p {
        font-size: 16px;
        color: #555;
        margin-bottom: 10px;
    }

    .service-block p.price {
        font-size: 18px;
        font-weight: bold;
        color: #4CAF50;
        margin-bottom: 10px;
    }

    .order-button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: #4CAF50;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .order-button:hover {
        background-color: #45a049;
    }

    /* Стилі для кнопки повернення на головну */
/* Розміщення "Вибір послуги" та фото */
.service-selection {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

/* Стилі для збільшення розміру контейнерів з функціями */
.service-block {
    flex: 0 0 calc(33.33% - 20px); /* Set width for three columns with some spacing */
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #fff;
    transition: transform 0.3s ease-in-out;
    margin-bottom: 20px;
    box-sizing: border-box; /* Ensure padding is included in width calculation */
}

/* Позиціонування кнопки */
.back-to-home-button {
    display: block;
    width: fit-content;
    margin: 20px auto; /* Center the button horizontally */
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #3498db;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.back-to-home-button:hover {
    background-color: #2980b9;
}
/* Підкреслення "Послуги для вашого авто" */
.tab-title {
    text-decoration: underline;
}

/* Розташування "Вибір послуги" та фото */
.service-selection {
    width: 100%;
    text-align: center;
    margin-bottom: 20px;
}

/* Стилі для нового подання фото та центрування */
.service-image-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
    width: 100%; /* Ensure the container takes the full width */
}

.service-image {
    max-width: 100%; /* Ensure the image does not exceed its container */
    max-height: 350px; /* Change height as needed */
    border-radius: 50px;
    object-fit: cover; /* Stretch the image to cover the container */
}

/* Стилі для підкреслення назв послуг */
.service-title {
    font-size: 20px;
    color: #1e434c;
    margin-bottom: 10px;
    text-decoration: underline; /* Додаємо підкреслення */
}

.service-description {
    font-size: 16px;
    color: #555;
    margin-bottom: 10px;
}

.service-price {
    font-size: 18px;
    font-weight: bold;
    color: #4CAF50;
    margin-bottom: 10px;
}
</style>
<script>
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function setServiceIdAndSubmit(serviceId) {
    // Set the serviceId in the hidden input field
    var serviceIdInput = document.getElementById('serviceIdInput');
    if (serviceIdInput) {
        serviceIdInput.value = serviceId;

        // Send an AJAX request to the server to save the serviceId in the session
        fetch("{{ route('save-serviceId') }}", {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
            body: JSON.stringify({ serviceId: serviceId })
        })
        .then(response => {
            if (!response.ok) {store
                throw new Error('Failed to save serviceId');
            }
            // Optionally, you can handle the response
            console.log('ServiceId saved successfully');
            window.location.href = "{{ route('order/form') }}";
        })
        .catch(error => {
            console.error('Error saving serviceId:', error);
        });
    } else {
        console.error('Element with ID "serviceIdInput" not found.');
    }
}
</script>
</div>
    <!-- Кнопка повернення на головну сторінку -->
    <a href="/" class="back-to-home-button back-to-home">Повернутися на головну</a>
</div>
<style>{
    background-color: #ecf0f1; /* Світлий сірий фон */
    padding: 20px;
    margin-top: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.service-block h3 {
    color: #3498db; /* Синій колір для заголовку */
}

.service-block p {
    color: #555; /* Темно-сірий колір для тексту */
    margin-top: 10px;
}

/* Стилі для ефекту при наведенні на кнопку */

.back-to-home-button:hover {
    background-color: #27ae60; /* Темніший зелений колір при наведенні */
}</style>