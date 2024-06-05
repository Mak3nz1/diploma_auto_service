
    <h2>Create Car</h2>

    <form action="{{ route('cars.store') }}" method="POST">
        @csrf
        <label for="user_id">User:</label>
        <input type="text" name="user" value="{{ auth()->user()->name }}" disabled>
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <br>
       
    <label for="company">Company:</label>
    <input type="text" name="company" value="{{ old('company') }}" required>
    <br>
    <label for="model">Model:</label>
    <input type="text" name="model" value="{{ old('model') }}" placeholder="Enter model" required>
    <br>

    <label for="year">Year:</label>
    <input type="text" name="year" value="{{ old('year') }}" placeholder="Enter year" required>
    <br>

    <label for="vin_code">VIN Code:</label>
    <input type="text" name="vin_code" value="{{ old('vin_code') }}" placeholder="Enter 17-digit VIN Code" required pattern="[a-zA-Z0-9]{17}" title="Please enter exactly 17 symbols of your VIN">
    <br>
        <button type="submit">Create Car</button>
    </form>

    <a href="{{ route('cars.index') }}" class="btn btn-secondary">Back to Cars</a>
    @if ($errors->any())
   <div class="alert alert-danger">
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
@endif

@if(session('success'))
   <div class="alert alert-success">
       {{ session('success') }}
   </div>
@endif

@if(session('error'))
   <div class="alert alert-danger">
       {{ session('error') }}
   </div>
@endif
    <style>
    body {
        font-family: 'Arial', sans-serif;
        padding: 20px;
    }

    h2 {
        color: #333;
    }

    .btn {
        display: inline-block;
        margin: 10px 0;
        padding: 10px 20px;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .table th, .table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .btn-warning,
    .btn-danger {
        margin-right: 5px;
    }

    .back-to-home-button {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        padding: 10px 20px;
        border-radius: 5px;
    }
    form {
        max-width: 400px;
        margin: 0 auto;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
    }

    button {
        background-color: #4caf50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .back-to-home-button:hover {
        background-color: #0056b3;
    }
    .alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

</style>