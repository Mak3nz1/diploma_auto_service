<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoService🚗</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <style>
        /* General styles */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            color: #333;
        }
/* Header links */


        /* Header styles */
        header {
            background-color: #2ecc71;
            color: white;
            padding: 10px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-container img {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }

        h1 {
            font-size: 22px;
            margin: 15px;
        }

      /* Navigation styles */
      nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    align-items: center; /* Це центрує елементи вертикально */
}

nav li {
    margin-right: 10px; /* Додає простір між елементами */
}

nav a {
    text-decoration: none;
    color: #333;
    font-size: 18px;
    transition: color 0.3s;
    font-family: "Times New Roman", Times, serif; /* Змінює шрифт */
    padding: 10px 20px; /* Додає відступи */
    border-radius: 6px;
    display: flex; /* Додаємо властивість flex для додаткового керування елементами */
    align-items: center; /* Центруємо вертикально текст і зображення */
}

nav a:hover {
    color: #2ecc71;
    background-color: #e0e0e0;
}

nav {
    background-color: #2ecc71;
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 20px;
}



        /* Main Content styles */
        .main-content {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        /* Tabs styles */
        .tab-content {
            margin-bottom: 30px;
            text-align: center;
        }

        .tab-content h2 {
            position: relative;
            margin-bottom: 20px;
        }

        .tab-content h2::before {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: #2ecc71;
        }

      .tab-content img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

        .tab-content a:hover {
            background-color: #27ae60;
        }

        /* Testimonials Carousel styles */
        .carousel {
            margin-top: 30px;
        }

        .carousel h2 {
            color: #3498db;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .carousel-container {
            margin-top: 20px;
        }
       
.btn-container {
    text-align: center;
    margin-top: 10px;
}

.btn-container a {
    display: inline-block;
    padding: 15px 30px;
    background-color: #2ecc71;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    transition: background-color 0.3s;
}

.btn-container a:hover {
    background-color: #27ae60;
}
/* Tab styles */
.tab-content {
    background: linear-gradient(to bottom, #2ecc71, #000000);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
}
.avatar-container {
    width: 84px; /* Розмір + 2 * товщина рамки */
    height: 84px; /* Розмір + 2 * товщина рамки */
    overflow: hidden;
    border-radius: 50%; /* Заокруглення контейнера */
    background: linear-gradient(45deg, #000, #fff); /* Градієнт від чорного до білого */
    display: flex;
    justify-content: center;
    align-items: center;
}


.avatar {
    width: 100px; /* Розмір фото */
    height: 80px; /* Розмір фото */
    border-radius: 70%; /* Заокруглення зображення */
    box-sizing: border-box; /* Урахування товщини рамки */
}



/* Testimonials Carousel item styles */
.carousel-item {
    background-color: #3498db;
    color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease;
}
        .carousel-item {
            background-color: #2ecc71;
            color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .slick-dots {
            display: none !important;
        }

        /* Hover effects */
        .tab-content img:hover,
        .carousel-item:hover {
            transform: scale(1.05);
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            nav ul {
                display: none;
            }

            header {
                padding: 10px;
                text-align: center;
                flex-direction: column;
            }

            .logo-container img {
                margin-right: 0;
                margin-bottom: 10px;
            }

            h1 {
                margin: 10px 0;
            }

            .dropdown {
                display: block;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="logo-container">
        <img src="https://welovebrands.com.ua/wp-content/uploads/2023/06/avto.png" alt="Logo">
    </div>
    <h1>AutoService</h1>
    <nav>
        <ul class="dropdown">
            <li><a href="/services">Наші Послуги</a></li>
            <li><a href="/orders">Ваші Замовлення</a></li>
            <li><a href="/cars">Транспорт</a></li>
            <li>
    <a href="/profile"> <!-- Посилання на профіль -->
        <div class="avatar-container"> <!-- Переміщуємо фото сюди -->
            @csrf
            @if($socials && $socials->photo_url)
                <img src="{{ $socials->photo_url }}" alt="User Photo" class="avatar">
            @else
            <div style="text-align: center;"> <!-- Обгортка для вирівнювання по центру -->
    <img src="placeholder.jpg" alt="Add Photo*" class="avatar"> <!-- Додайте власний шлях до фото за умовчанням -->
</div>
            @endif
        </div>
        <p>
    Профіль<br>
    @if(Auth::check()) <!-- Перевірка чи користувач авторизований -->
        Вітаємо, {{ Auth::user()->name }}!
    @else
        Вітаємо, Гість!
    @endif
</p>
    </a>
</li>

            </ul>
        
    </nav>

</header>

    <!-- Main Content -->
    <div class="main-content">
   
        <!-- Services Tab -->
<div id="services" class="tab-content">
    <h2>Послуги для вашого транспорту</h2>
    <img src="https://scene7.toyota.eu/is/image/toyotaeurope/mot-check-cta-1920x1080tcm-3154-1447656:Small-Landscape?ts=0&resMode=sharp2&op_usm=1.75,0.3,2,0" alt="Автомобіль">
    <div class="btn-container">
        <a href="/services">Дізнатися більше</a>
    </div>
</div>

<!-- Orders Tab -->
<div id="orders" class="tab-content">
    <h2>Ваші Замовлення</h2>
    <img src="https://cdn-icons-png.flaticon.com/512/2649/2649223.png" alt="Замовлення">
    <div class="btn-container">
        <a href="/orders">Переглянути Замовлення</a>
    </div>
</div>

<!-- Vehicles Tab -->
<div id="cars" class="tab-content">
    <h2>Транспорт</h2>  
    <img src="https://live.staticflickr.com/8755/16526506823_7bd80bd9c6_b.jpg" alt="Транспорт">
    <div class="btn-container">
        <a href="/cars">Переглянути Транспорт</a>
    </div>
</div>

<!-- Profile Tab -->
<div id="profile" class="tab-content">
    <h2>Ваш Профіль</h2>
    <img src="https://cdn-icons-png.flaticon.com/512/8602/8602351.png" alt="Профіль">
    <div class="btn-container">
        <a href="/profile">Перейти до Профілю</a>
    </div>
</div>
        <!-- Testimonials Carousel -->
        <div class="carousel">
            <h2>Відгуки Користувачів</h2>
            <div class="carousel-container">
                <div class="carousel-item">
                    <p>Дуже задоволений сервісом! Все вчасно та професійно.</p>
                </div>
                <div class="carousel-item">
                    <p>Рекомендую всім, відмінна робота!</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Посилання на Slick Carousel JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        // Ініціалізація каруселі після завантаження сторінки
        $(document).ready(function(){
            $('.carousel-container').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: false,
                dots: true
            });
        });
    </script>
</body>
</html>