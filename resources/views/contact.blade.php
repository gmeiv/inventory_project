<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - ARICC</title>
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

     @include('layouts.header')

    <div class="contact-wrapper">
    <table style="width: 100%;" >
        <tr>
            <td style="vertical-align: top; width: 50%; padding-right: 20px;">
                <div class="section contact-info">
                    <h2>Get in Touch</h2>
                    <p>If you have any questions, inquiries, or suggestions, feel free to reach out to us using the contact details below:</p>
                    <ul class="contact-details">
                        <li><i class="fas fa-envelope"></i> <a href="mailto:ariccenter.dio.rde@bulsu.edu.ph" target="_blank"> ariccenter.dio.rde@bulsu.edu.ph</a></li>
                        <li><i class="fas fa-phone"></i> 09256768867</li>
                        <li><i class="fab fa-facebook"></i> <a href="https://www.facebook.com/DIOARICCenter" target="_blank"> DIOARICCenter</a></li>
                        <li><i class="fas fa-map-marker-alt"></i> <a href="https://maps.app.goo.gl/DWMK7vHfXNqx6NG67" target="_blank"> Bulacan State University, Malolos, Philippines</a></li>
                        <li><i class="fas fa-clock"></i> Tuesday - Friday, 8:00 AM to 5:00 PM</li>
                    </ul>
                </div>
            </td>
            <td style="vertical-align: top; width: 50%;">
                <div class="section feedback-form">
                    <h2>Send Us a Message</h2>
                   <form action="{{ route('contact.send') }}" method="POST">

                        @csrf
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Your name..." required>

                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Your email..." required>

                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" placeholder="Your message..." required></textarea>

                        <button type="submit">Send Message</button>
                    </form>
                </div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
