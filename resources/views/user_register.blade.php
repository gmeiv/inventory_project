<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
</head>
<body>
    @include('layouts.header')
    @include('layouts.error-pop')

    <div class="form-container" id="register-form">
        <form action="{{ route('user.register') }}" method="POST">
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
                            <legend>Additional Information</legend>
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" name="phone_number" id="phone_number"
                                       pattern="[0-9]*"
                                       inputmode="numeric"
                                       maxlength="11"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="role">Position/Role</label>
                                <select name="role" id="role" required>
                                    <option value="" disabled selected>Select Role</option>
                                    <option value="Student">Student</option>
                                    <option value="Faculty Member">Faculty Member</option>
                                    <option value="Staff">Staff</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
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
                <input type="checkbox" required> Agree to <a href="#">Terms and Conditions</a><br>
                <input type="checkbox" required> Give consent to <a href="#">Data Privacy Policy</a>
            </div>

            <button class="btn_out" id="btn_sign" type="submit">Register</button>
        </form>
    </div>
</body>
</html>
