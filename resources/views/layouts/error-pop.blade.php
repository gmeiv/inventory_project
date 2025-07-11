@if(session('error') || $errors->any())
    <div id="errorPopup" class="popup-overlay">
        <div class="popup-box">
            <div id="errorMessage">
                @if(session('error'))
                    <p>{{ session('error') }}</p>
                @elseif($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                           {{ $error }}<br>
                        @endforeach
                    </ul>
                @endif
            </div>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>

    <script>
        function closePopup() {
            document.getElementById('errorPopup').style.display = 'none';
        }
    </script>

    <style>
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-box {
            background: #003366;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            text-align: center;
            width: 30%;
            height: auto;
            max-width: 600px;
            color: #cce6ff;
            font-size: 1.1rem;
            font-family: 'Segoe UI', sans-serif;
            border: 1px solid #0059b3;
        }

        .popup-box ul {
            padding: 15px
            list-style: disc;
            justify-content: center;
            align-items: center;
            
            text-align: center;
        }

        .popup-box p,
        .popup-box li {
            color: #cce6ff;
        }

        .popup-box button {
            margin-top: 20px;
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            background: linear-gradient(to right, #0059b3, #003366);
            color: white;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .popup-box button:hover {
            background: linear-gradient(to right, #003366, #0059b3);
            transform: scale(1.05);
        }
    </style>
@endif
