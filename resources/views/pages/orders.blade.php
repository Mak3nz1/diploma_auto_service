<style>
    #orders {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f8f8;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        overflow: auto; /* Додаємо прокрутку при необхідності */
    }

    .tab-title {
        color: #3498db;
    }

    a {
        color: #3498db;
        text-decoration: none;
    }
    #empty-orders {
        text-align: center;
        margin-top: 20px;
    }

    #empty-orders p {
        font-size: 18px;
        margin-bottom: 20px;
    }

    #empty-orders .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    #empty-orders .btn-primary:hover {
        opacity: 0.8;
    }
    a:hover {
        text-decoration: underline;
    }

    #date-carousel-container {
        display: flex;
        flex-wrap: wrap; /* Додаємо перенос на новий рядок при необхідності */
        justify-content: space-between;
        margin-top: 20px;
    }

    button {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-bottom: 10px; /* Додаємо відступ між кнопками */
    }

    button:hover {
        background-color: #2980b9;
    }

    .carousel-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
    }

    .carousel-item {
        text-align: center;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        opacity: 0.8;
        transition: opacity 0.3s;
        width: calc(100% - 40px); /* Змінюємо ширину відповідно до контейнера */
    }

    .carousel-item:hover {
        opacity: 1;
    }

    .back-to-home-button {
        background-color: #2ecc71;
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .back-to-home-button:hover {
        background-color: #27ae60;
    }
</style>
<div id="orders" class="tab-content">
@if ($orders->isEmpty())
    <p>Ваші замовлення пусті. Створіть перше замовлення зараз!</p>
    <a href="/services" class="btn btn-secondary">Повернутись до замовлення</a>
    @else
   
        <h2 class="tab-title">Ваші замовлення</h2>

        <div id="date-carousel-container">
            <!-- Date elements will be dynamically added here -->
        </div>

        <div id="order-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <!-- Order details will be dynamically added here -->
            </div>
        </div>

        <a href="/services" class="btn btn-secondary">Повернутись до замовлення</a>
    </div>
    <a href="/" class="back-to-home-button back-to-home">Повернутися на головну</a>
</div>
@endif
    <script>
const ordersData = {!! json_encode($orders) !!};

function updateCarousel(date) {
    const ordersForDate = ordersData[date] || [];
    const carouselInner = document.querySelector('#order-carousel .carousel-inner');

    carouselInner.innerHTML = '';

    ordersForDate.forEach((order, index) => {
        const isActive = index === 0 ? 'active' : '';

        const carouselItem = `
            <div class="carousel-item ${isActive}">
                <p>Замовлення №${order.order_id}</p>
                <p>Car Name: ${order.car ? `${order.car.company} ${order.car.model}` : 'Not specified'}</p>
                <p>Car Date: ${order ? order.car_date : 'Not specified'}</p>
                <p>Car Time: ${order ? order.car_time : 'Not specified'}</p>
                <p>Address: ${order.order_details.address ? order.order_details.address : 'Not specified'}</p>
                <p>Price: ${order.order_details.total_amount ? order.order_details.total_amount : 'Not specified'}</p>

                <ul>
                    ${order.service ?
                        `
                        <li>
                            Service: ${order.service.service ?? 'Not specified'}
                            Description: ${order.service.description ?? 'Not specified'}
                        </li>
                        ` :
                        '<li>No details available</li>'
                    }
                </ul>
            </div>
        `;
        carouselInner.innerHTML += carouselItem;
    });
}

function addDateElement(date) {
    const dateContainer = document.querySelector('#date-carousel-container');
    const dateElement = document.createElement('button');
    dateElement.textContent = date;
    dateElement.addEventListener('click', () => updateCarousel(date));
    dateContainer.appendChild(dateElement);
}

Object.keys(ordersData).forEach(date => {
    addDateElement(date);
});

const latestDate = Object.keys(ordersData)[0];
updateCarousel(latestDate);
    </script>
    <script>
   function cancelOrder(date, orderId) {
            // For now, let's assume the cancellation is successful
            document.getElementById('orderCancelledMessage').style.display = 'block';
            document.getElementById('cancelOrderBtn').style.display = 'none';
            // You may want to update the UI or redirect the user after cancellation
        }

        document.getElementById('cancelOrderBtn').addEventListener('click', () => {
            const activeDateButton = document.querySelector('#date-carousel-container button.active');
            const orderId = activeDateButton.getAttribute('data-order-id');
            cancelOrder(activeDateButton.textContent, orderId);
        });
        </script>
</div>