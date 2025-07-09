<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{asset('css/about.css') }}">

</head>
<body>
    @include('layouts.header')
   <div class="container" id="register-form">
    <form action="{{route('user.register')}}" method="POST">
        @csrf
        <table class="form-table">
            <tr>
                <!-- Personal Information -->
                <td colspan="2">
                    <fieldset>
                        <legend>Personal Information</legend>
                        <div class="form-group">
                            <label for="surname">Surname</label>
                            <input type="text" name="surname" id="surname" required>
                        </div>
                        <div class="form-group">
                            <label for="middlename">Middle Name</label>
                            <input type="text" name="middlename" id="middlename">
                        </div>
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" id="firstname" required>
                        </div>
                        
                    </fieldset>
                </td>

                <!-- Address Information -->
                <td colspan="2">
                   <fieldset>
                    <legend>Department / Course</legend>

                        <div class="form-group">
                            <label for="department">Department</label>
                            <select name="department" id="department" required>
                                <option value="" disabled selected>Select Department</option>
                                <option value="CIT">College of Information Technology</option>
                                <option value="COE">College of Engineering</option>
                                <option value="CAS">College of Arts and Sciences</option>
                                <option value="CBA">College of Business Administration</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="course">Course</label>
                            <select name="course" id="course" required>
                                <option value="" disabled selected>Select Course</option>
                                <option value="BSIT">BS in Information Technology</option>
                                <option value="BSCS">BS in Computer Science</option>
                                <option value="BSECE">BS in Electronics Engineering</option>
                                <option value="BSBA">BS in Business Administration</option>
                                <option value="BAENG">BA in English</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="year_level">Year Level</label>
                            <select name="year_level" id="year_level" required>
                                <option value="" disabled selected>Select Year</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                    </fieldset> 

                </td>

             <!-- Account Information (spanning both columns) -->   
                <td colspan="1">
                    <fieldset>
                        <legend>Account Information</legend>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required>
                        </div>
                    </fieldset>
                </td>

            </tr>
           
        </table>

        <div class="checkbox-group">
                <input type="checkbox" required> Agree to <a href="">Terms and Conditions</a><br>
                <input type="checkbox" required> Give consent to <a href="">Data Privacy Policy</a>
                </div>


                @if($errors->any())
                    <div class="form-group error-box" style="color: red; margin-bottom: 10px;">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

        <button class="btn_out" id="btn_sign" type="submit">Register</button>
    </form>
</div>



</body>
</html>