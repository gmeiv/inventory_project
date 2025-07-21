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
    <br>
    @include('layouts.error-pop')
     <a href="{{ route('admins.index') }}" class="back-button">&larr; Back to Admins</a>

    <div class="form-container" id="register-form">
    <form action="{{ route('admin.register') }}" method="POST">
        @csrf
        
        <table class="form-table">
            <tr>
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

                <td colspan="2">
                   <fieldset>
                        <legend>Professional Information</legend>

                        <div class="form-group">
                            <label for="department">Assigned Department</label>
                            <select name="department" id="department" required>
                                <option value="" disabled selected>Select Department</option>
                                <option value="CIT">College of Information Technology</option>
                                <option value="COE">College of Engineering</option>
                                <option value="CAS">College of Arts and Sciences</option>
                                <option value="CBA">College of Business Administration</option>
                                <option value="ADMIN">Administrative Office</option>
                                <option value="REG">Registrar's Office</option>
                                <option value="HR">Human Resources</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="position">Position / Title</label>
                            <input type="text" name="position" id="position" placeholder="e.g. Professor, Department Head, Registrar" required>
                        </div>

                        <div class="form-group">
                            <label for="employment_type">Employment Type</label>
                            <select name="employment_type" id="employment_type" required>
                                <option value="" disabled selected>Select Type</option>
                                <option value="full_time">Full-Time</option>
                                <option value="part_time">Part-Time</option>
                                <option value="contractual">Contractual</option>
                            </select>
                        </div>

                        
                    </fieldset>

                </td>

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