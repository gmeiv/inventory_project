<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">    
           <link rel="stylesheet" href="{{asset('css/about.css') }}">

</head>
<body>

    @include('layouts.header')
    <div class="popup-content">
        <h2>Registration Type</h2>
        <p>Choose between the two options</p><br>
        <form action=""  class="register-type">  
            <label class="radio-label"><input type="radio" name="type" value="student"> Student</label>
            <label class="radio-label"><input type="radio" name="type" value="admin"> Admin</label>

           <button type="submit" class="btn_out" id="pop_btn">Submit</button>
        </form>
    </div>

    <script>
    const pop_btn = document.getElementById('pop_btn');
    pop_btn.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default form submission
        const selectedType = document.querySelector('input[name="type"]:checked');
        
        if (selectedType) {
            const typeValue = selectedType.value;
            // Redirect based on the selected type
            if (typeValue === 'student') {
                window.location.href = "{{ url('/user_register') }}"; // Redirect to student registration
            } else if (typeValue === 'admin') {
                window.location.href = "{{ url('/admin_register') }}"; // Redirect to admin registration
            }
        } else {
            alert('Please select a registration type.');
        }
    });
</script>
</body>
</html>


