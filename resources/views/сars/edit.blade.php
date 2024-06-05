
    <h2>Edit Car</h2>

    <form action="{{ route('cars.update', $car) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    <br>   
    <label for="company">Company:</label>
    <input type="text" name="company" value="{{ $car->company }}" required>
    <br>
    <label for="model">Model:</label>
    <input type="text" name="model" value="{{ $car->model }}" required>
    <br>

    <label for="year">Year:</label>
    <input type="text" name="year" value="{{ $car->year }}" required>
    <br>

    <label for="vin_code">VIN Code:</label>
    <input type="text" name="vin_code" value="{{ $car->vin_code }}" placeholder="Enter 17-digit VIN Code" required pattern="[a-zA-Z0-9]{17}" title="Please enter exactly 17 symbols of your VIN">
    
    <button type="submit">Update Car</button>
</form>

<a href="{{ route('cars.index') }}" class="btn btn-secondary">Back to Cars</a>

<style>
    body {
        font-family: 'Arial', sans-serif;
        padding: 20px;
    }

    form {
        max-width: 400px;
        margin: 0 auto;
        background-color: #f4f4f4;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        background-color: #4caf50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-secondary {
        display: inline-block;
        margin-top: 10px;
        text-decoration: none;
        color: #fff;
        background-color: #333;
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 16px;
    }

    .btn-secondary:hover {
        background-color: #555;
    }
</style>