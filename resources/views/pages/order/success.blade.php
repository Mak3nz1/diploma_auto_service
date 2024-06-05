<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content here -->
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        text-align: center;
    }

    h1 {
        color: #333;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin: 10px 0;
        color: #555;
    }

    a {
        text-decoration: none;
        color: #fff;
        background-color: #3498db;
        padding: 10px 20px;
        border-radius: 5px;
        display: inline-block;
        margin-top: 20px;
    }

    a:hover {
        background-color: #258cd1;
    }

    .back-to-home {
        background-color: #e74c3c;
    }

    .back-to-home:hover {
        background-color: #c0392b;
    }

    .image-container {
        max-width: 100%; /* Ensure the image container doesn't exceed its parent's width */
        margin-bottom: 20px; /* Add some bottom margin for spacing */
    }

    .image-container img {
        max-width: 30%; /* Set maximum width to maintain aspect ratio */
        height: auto; /* Allow the browser to adjust height accordingly */
        display: block; /* Make sure the image is displayed as a block element */
        margin: 0 auto; /* Center the image horizontally */
        border-radius: 75%; /* Make the image circular */
    }
</style>
<body>
<div class="container">
    <h1>Дякуємо, ваше замовлення прийнято!</h1>
    <div class="image-container">
        <img src="https://cdn.dribbble.com/users/480311/screenshots/11006552/soren-iverson-dribbble-040920-01_4x.png" alt="Success">
    </div>
    <p>Деталі вашого замовлення:</p>
    <ul>
        <li>Order ID: {{ $orderDetail['order_id'] }}</li>
        <li>Total Amount: ${{ $orderDetail['total_amount'] }}</li>
        <li>Payment Method: {{ $orderDetail['payment_method'] ?? 'Not specified' }}</li>
        <li>Address: {{ $orderDetail['address'] ?? 'Not specified' }}</li>
    </ul>
    <p>Дякуємо, що вибрали наш автосервіс!</p>
    <a href="/" class="back-to-home-button back-to-home">Повернутися на головну</a>
</div>
</body>
</html>
