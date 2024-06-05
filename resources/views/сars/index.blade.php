<h2>Cars</h2>
<a href="{{ route('cars.create.form') }}" class="btn btn-primary">Додати автомобіль</a>

<div class="card-container">
    @if ($cars->isEmpty())
        <p>Не знайдено жодного автомобіля. Будь ласка, <a href="{{ route('cars.create.form') }}">створіть автомобіль</a>.</p>
    @else
        @foreach ($cars as $car)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $car->company }} {{ $car->model }}</h5>
                <p class="card-text"><strong>VIN Code:</strong> {{ $car->vin_code }}</p>
                <p class="card-text"><strong>Рік:</strong> {{ $car->year }}</p>
                @if ($car->is_active)
                    <span class="badge badge-success">Активний</span>
                @else 
                    <form action="{{ route('cars.setActive', ['car' => $car->car_id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm">Встановити активним</button>
                    </form>
                @endif
                <a href="{{ route('cars.edit', ['car' => $car->car_id]) }}" class="btn btn-warning btn-sm">Редагувати</a>
                <form action="{{ route('cars.destroy', $car->car_id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Ви впевнені?')">Видалити</button>
                </form>
            </div>
        </div>
        @endforeach
    @endif
</div>
<!-- Buttons to return to order and home pages -->
<div class="button-container">
    <a href="/services" class="btn btn-secondary">Повернутись до замовлення</a>
    <a href="/" class="back-to-home-button back-to-home">Повернутися на головну</a>
</div>

<style>
    /* Основні стилі карток */
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* Відцентровує по горизонталі */
        align-items: center; /* Відцентровує по вертикалі */
        gap: 20px;
        margin-top: 20px;
    }

    .card {
        width: 250px;
        border: 1px solid #ccc;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Тінь */
        transition: box-shadow 0.3s ease; /* Анімація */
    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Збільшення тіні при наведенні */
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .card-text {
        margin-bottom: 15px;
    }

    /* Стилі бейджів */
    .badge-success {
        background-color: #4caf50;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
    }

    /* Загальні стилі кнопок */
    .btn {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    /* Стилі для кнопки "Додати автомобіль" */
    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
    }

    /* Стилі для кнопок дій */
    .btn-success,
    .btn-warning,
    .btn-danger,
    .btn-secondary {
        padding: 8px 16px;
        border-radius: 5px;
    }

    .btn-success {
        background-color: #20c997; /* Зелений колір */
        color: white;
        border: none;
    }

    .btn-warning {
        background-color: #ffc107; /* Жовтий колір */
        color: black;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545; /* Червоний колір */
        color: white;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d; /* Сірий колір */
        color: white;
        border: none;
    }

    /* Стилі для кнопок при наведенні */
    .btn:hover {
        opacity: 0.8;
    }

    /* Стилі для контейнера кнопок */
    .button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    /* Стилі для кнопки "Повернутись до замовлення" */
    .btn-secondary {
        margin-right: 10px;
    }

    /* Стилі для кнопки "Повернутися на головну" */
    .back-to-home-button {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
    }

    /* Стилі для кнопок при наведенні */
    .back-to-home-button:hover {
        opacity: 0.8;
    }

    /* Зміна кольору посилань */
    a {
        color: #007bff; /* Колір посилань */
    }

    a:hover {
        color: #0056b3; /* Колір посилань при наведенні */
    }
</style>
