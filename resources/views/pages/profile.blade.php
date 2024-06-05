<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мій профіль</title>
    <style>
body {
    font-family: 'Times New Roman', sans-serif;
    padding: 20px;
    background: linear-gradient(45deg, #3498db, #9b59b6);
    color: white;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

/* Profile container styles */
.profile-container {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    max-width: 600px;
    width: 100%;
}

/* Profile photo styles */
/* Profile text styles */
.profile-text {
    font-size: 22px; /* Збільшено розмір шрифту */
    margin-bottom: 10px;
    color: #fff;
}

/* Individual profile text lines */
.profile-text p {
    margin: 10px 0; /* Збільшено відступ між рядками */
}

.profile-photo {
    width: 150px;
    height: 150px;
    overflow: hidden;
    border-radius: 50%;
    margin: 0 auto 30px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    position: relative;
}

.profile-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    transition: transform 0.3s ease-in-out;
}

/* Hover effect */
.profile-photo:hover img {
    transform: scale(1.05);
}

/* Add a border overlay on hover */
.profile-photo::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 2px solid rgba(255, 255, 255, 0);
    transition: border-color 0.3s;
}

/* Change border color on hover */
.profile-photo:hover::before {
    border-color: rgba(255, 255, 255, 0.5);
}

/* Form styles */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 12px;
    font-weight: bold;
    font-size: 22px;
    margin: 12px 0;
    color: #fff;
}

input[type="file"],
input[type="text"] {
    width: calc(100% - 22px);
    padding: 10px;
    margin-bottom: 16px;
    border: none;
    border-radius: 4px;
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
    transition: background-color 0.3s;
}

input[type="file"]:focus,
input[type="text"]:focus {
    background-color: rgba(255, 255, 255, 0.3);
}

/* Submit button styles */
button {
    background-color: #9b59b6;
    color: white;
    padding: 12px 30px;
    font-size: 18px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    transition: background-color 0.3s;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 20px;
}

button:hover {
    background-color: #8e44ad;
}

/* Logout link styles */
a {
    color: #7057ff; /* Changed color */
    text-decoration: underline;
    font-size: 20px; /* Increased font size */
    transition: color 0.3s;
}

a:hover {
    color: #f39c12; /* Changed hover color */
}

/* Back to home button styles */
.back-to-home-button {
    background-color: #7057ff; /* Changed color */
    padding: 10px 20px;
    text-decoration: none;
    color: white;
    border-radius: 5px;
    display: inline-block;
    transition: background-color 0.3s;
    margin-top: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 20px; /* Increased font size */
}

.back-to-home-button:hover {
    background-color: #c0392b; /* Changed hover color */
}
.empty-photo {
    width: 100px; /* Ширина контейнера */
    height: 100px; /* Висота контейнера */
    background-color: #f0f0f0; /* Колір фону для пустого контейнера */
    border: 1px solid #ccc; /* Границя для пустого контейнера */
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #888; /* Колір тексту */
    font-size: 14px; /* Розмір тексту */
}

    </style>
</head>
<body>
    <div class="profile-container">
    <label for="photo">Фото:</label>
    <div class="profile-photo">
    @if(!empty($socials->photo_url))
        <img src="{{ $socials->photo_url }}" alt="User Photo">
    @else
        <div class="empty-photo">No Photo Available</div>
    @endif
</div>

        <h1>Мій профіль</h1>
        
        <div class="profile-text">
        <p>Ім'я: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>
    </div>
        <form action="{{ route('update-profile') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if (optional($socials)->photo_url)
                <input type="file" name="photo" accept="image/*" style="display: none;">
            @else
                <input type="file" name="photo" accept="image/*">
            @endif
            <label for="instagram">Instagram:</label>
            @if (optional($socials)->instagram)
                <a href="{{ $socials->instagram }}" target="_blank">Відвідати Instagram профіль</a>
            @else
                <input type="text" name="instagram" placeholder="Введіть посилання на Instagram">
            @endif
            <button type="submit">Оновити профіль</button>
        </form>
        <p><a href="/logout" style="text-decoration: underline;">Вийти</a></p>
        <!-- Back to home button -->
        <a href="/" class="back-to-home-button">На головну</a>
    </div>
</body>
</html>
