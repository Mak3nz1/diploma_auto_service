<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Підключення Leaflet.js та стилів -->
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>

<form id="paymentForm" action="{{ route('payment.calculateTotal') }}" method="post">
    @csrf
    <h2>Order Details</h2>

    <p>Order ID: <strong>{{ $orderId }}</strong></p>
    <p>Total Amount: $<span id="totalAmount" data-total-amount="{{ $service ? $service->getPrice() : 'N/A' }}">{{ $service ? $service->getPrice() : 'N/A' }}</span></p>
    <p>Total Amount with promo: $<span id="discounted-amount"></span></p>

    <!-- Додавання блоку для мапи (по замовчуванню схований) -->
    <div id="map" style="height: 300px; display: none;"></div>

    <!-- Додавання кнопок для промокоду та вибору адреси -->
    <label for="promo_code">Promo Code:</label>
    <input type="text" name="promo_code" id="promo_code" />
    <button type="button" onclick="calculateTotal()" style="margin-left: 10px; background-color: #007bff; color: #fff; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">Apply Promo Code</button>

    <label for="address">Select Address:</label>
    <button type="button" onclick="toggleMap()" style="margin-left: 10px; background-color: #007bff; color: #fff; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">Select Address on Map</button>
    <input type="hidden" name="selected_address" id="address" />
    <select name="payment_method" id="payment_method" style="width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;">
        @foreach($paymentMethods as $paymentMethod)
            <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->method_name }}</option>
        @endforeach
    </select>

    <!-- Adjust the order_id field to match the ID used in JavaScript -->
    @if($orderId)
        <input type="hidden" name="order_id" id="order_id" value="{{ $orderId }}">
    @endif

    <!-- Додавання блоку для мапи (по замовчуванню схований) -->
    <div id="map" style="height: 300px; display: none;"></div>
    <button type="button" onclick="placeOrder()" style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; margin-top: 20px;">Place Order</button>
</form>

<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 20px;
    }

    form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
    }

    p {
        margin: 10px 0;
    }

    label {
        display: block;
        margin-top: 10px;
    }

    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        box-sizing: border-box;
    }

    button {
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }

    select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        box-sizing: border-box;
    }

    #map {
        height: 300px;
        display: none;
        margin-top: 20px;
    }
</style>
<?php
// Початок сесії
session_start();

// Ініціалізуємо змінні сесії за замовчуванням
$_SESSION['selectedMarker'] = null;
$_SESSION['selectedAddress'] = null;

// Встановлюємо вибраний маркер при кліку на мапі
if (isset($_POST['marker_lat']) && isset($_POST['marker_lng'])) {
    // Зберігаємо координати маркера в змінній сесії
    $_SESSION['selectedMarker'] = [
        'lat' => $_POST['marker_lat'],
        'lng' => $_POST['marker_lng']
    ];
}

// Встановлюємо обрану адресу при кліку на маркер
if (isset($_POST['marker_address'])) {
    // Зберігаємо обрану адресу в змінній сесії
    $_SESSION['selectedAddress'] = $_POST['marker_address'];
}

// Перевіряємо, чи обраний маркер перед виконанням замовлення
if (isset($_POST['place_order'])) {
    // Створюємо унікальний ідентифікатор сесії для цього замовлення
    $orderId = uniqid();

    // Перевіряємо, чи є обраний маркер для цього конкретного замовлення
    if ($_SESSION['selectedMarker']) {
        // Виконуємо дії для замовлення
        // Включаючи відправку даних про адресу і т.д.

        // Знімаємо обрану марку і адресу після виконання замовлення
        $_SESSION['selectedMarker'] = null;
        $_SESSION['selectedAddress'] = null;

        // Перенаправляємо користувача на сторінку успішного замовлення
        header("Location: /success.php?order_id=$orderId");
        exit();
    } else {
        // Виводимо повідомлення про помилку, якщо маркер не обраний
        echo "<script>alert('Please select a marker before placing an order.');</script>";
    }
}
?>
<script>
var promoCode = '';
var totalAmount = 0;
var discountAmount = 0;
var selectedAddress = null;
var selectedMarker = null; // Define selectedMarker in the global scope
var map;   // Define map in the global scope

function initMap() {
    var markers = [];
    // Remove the local declaration of selectedMarker here
    // var selectedMarker = null;
    
    // Initialize the map
    map = L.map('map').setView([50.4701, 30.4734], 12);

    // Add a tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add markers for KNUE and Stepana Bandery 21
    addMarker(50.460809282295685, 30.43209329343354, 'KNEU', 'Корпус №3 КНЕУ, вулиця Дегтярівська, 49Г, Київ');
    addMarker(50.49025912574964, 30.49558123936901, 'Stepana Bandery 21', 'вулиця Степана Бандери, 21, Київ');

    function addMarker(lat, lng, title, address) {
        var marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup( title + address);
        selectedAddress = { lat: lat, lng: lng };
        marker.on('click', function () {
            // Deselect the previously selected marker
            if (selectedMarker) {
                selectedMarker.setIcon(L.Icon.Default());
            }

            // Select the clicked marker
            selectedMarker = marker;

            // Set the selected address
            selectedAddress = { lat: lat, lng: lng };
        });

        markers.push(marker);
    }

    map.on('click', function (e) {
    // Check if the click is on any existing marker
    var clickedOnMarker = false;
    markers.forEach(function (marker) {
        var markerLatLng = marker.getLatLng();
        var distance = markerLatLng.distanceTo(e.latlng);
        if (distance < 100) {  // Adjust the distance threshold as needed
            clickedOnMarker = true;
            return;  // Exit the forEach loop early if the click is on a marker
        }
    });

    if (clickedOnMarker) {
        // Create a marker and bind a popup with the address
        var marker = L.marker(e.latlng).addTo(map);
        marker.bindPopup('Selected Address: ' + e.latlng.toString());

        // Store the selected marker
        selectedMarker = marker;

        // Set the selected address
        selectedAddress = { lat: e.latlng.lat, lng: e.latlng.lng };
    } else {
        alert('You can only place markers on existing locations.');
    }
});
    // Hide the map by default
    map.invalidateSize();
    map.getContainer().style.display = 'none';
}

function toggleMap() {
    // Toggle the map's visibility
    var mapContainer = map.getContainer();
    mapContainer.style.display = mapContainer.style.display === 'none' ? 'block' : 'none';
    map.invalidateSize();
}
function placeOrder() {
    // Check if a marker is selected
    if (selectedMarker) {
        // Assuming 'totalAmount' is an input field
        var totalAmountRaw = $('#totalAmount').data('total-amount');
        var totalAmount = parseFloat(totalAmountRaw);
        var orderId = $('#order_id').val();
        var promoCode = $('#promo_code').val();
        var discountedAmount = $('#discounted-amount').text();
        var paymentMethod = $('#payment_method').val();

        // Extract the name of the location from the popup content
        var address = selectedMarker.getPopup().getContent();

        // Send the data to /payment/placeOrder
        $.ajax({
            type: 'POST',
            url: '/payment/placeOrder',
            data: {
                orderId: orderId,
                promo_code: promoCode,
                totalAmount: totalAmount,
                discountedAmount: discountedAmount,
                payment_method: paymentMethod,
                address: address  // Send the address field
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                alert(response.message);
                // Add other actions or redirect to another page after placing the order
                window.location.href = '/success';
                selectedMarker.setIcon(L.Icon.Default());
                selectedMarker = null;
            },
            error: function (error) {
                console.log(error);
                alert('Error placing the order. Please try again.');
            }
        });
    } else {
        alert('Please select a marker before placing an order.');
    }
}

// Виклик ініціалізації карти
initMap();

</script>
<script>
var promoCode = '';
var totalAmount = 0;
var discountAmount = 0;

function calculateTotal() {
    var promoCode = $('#promo_code').val();
    var totalAmountRaw = $('#totalAmount').data('total-amount');
    var totalAmount = parseFloat(totalAmountRaw);

    $.ajax({
        type: 'POST',
        url: '/payment/calculateTotal',
        data: { promo_code: promoCode, totalAmount: totalAmount },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log('Total Amount:', totalAmount.toFixed(2));
            console.log('Discounted Amount:', response.discountedAmount);
            
            if (response.error) {
                alert('Invalid promo code. Pay full price.');
            } else {
                // Update the displayed New Total Amount
                $('#discounted-amount').text(response.discountedAmount);
                $('#totalAmount').text(totalAmount);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}
function displayErrorMessage(elementId, errorMessage) {
    // You can customize how you want to display the error message
    alert(errorMessage);
    // Here, you can update the UI to indicate the error, for example, by adding a class to the element.
    $('#' + elementId).addClass('error');
}
// Додавання маркера
function addMarker(latitude, longitude) {
    $.ajax({
        type: 'POST',
        url: '/addMarkerToSession',
        data: { latitude: latitude, longitude: longitude },
        dataType: 'json',
        success: function (response) {
            // Обробка успішного додавання маркера
            console.log(response.message);
        },
        error: function (error) {
            // Обробка помилки
            console.error('Failed to add marker:', error);
        }
    });
}

// Оновлення маркера
function updateMarker(index, latitude, longitude) {
    $.ajax({
        type: 'POST',
        url: '/updateMarkerInSession',
        data: { index: index, latitude: latitude, longitude: longitude },
        dataType: 'json',
        success: function (response) {
            // Обробка успішного оновлення маркера
            console.log(response.message);
        },
        error: function (error) {
            // Обробка помилки
            console.error('Failed to update marker:', error);
        }
    });
}

// Видалення маркера
function deleteMarker(index) {
    $.ajax({
        type: 'POST',
        url: '/deleteMarkerFromSession',
        data: { index: index },
        dataType: 'json',
        success: function (response) {
            // Обробка успішного видалення маркера
            console.log(response.message);
        },
        error: function (error) {
            // Обробка помилки
            console.error('Failed to delete marker:', error);
        }
    });
}

</script>
