<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Admin</title>
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admins.css') }}">
    <style>
        .admin-register-form {
            max-width: 1100px;
            margin: 0 auto;
            background: rgba(0, 41, 102, 0.7);
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.18);
            padding: 2.5rem 2rem 2rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .form-row {
            display: flex;
            flex-direction: row;
            gap: 2rem;
            width: 100%;
        }
        .form-section {
            flex: 1;
            min-width: 0;
            background: none;
            border-radius: 0;
            box-shadow: none;
            padding: 0;
            margin-bottom: 0;
            display: flex;
            flex-direction: column;
        }
        .form-section legend {
            font-weight: bold;
            color: #66ccff;
            font-size: 1.1rem;
            margin-bottom: 0.7rem;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 1rem;
        }
        .form-group label {
            margin-bottom: 0.3rem;
            font-size: 1rem;
            color: #cce6ff;
            display: block;
            padding-left: 10%; /* indent to align with input box */
            text-align: left;
        }
        .form-group input,
        .form-group select {
            width: 80%;
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding: 12px 20px;
            border-radius: 5px;
            border: 1.5px solid #fff;
            background: #0a2c4d;
            color: #cce6ff;
            font-size: 0.97rem;
            margin-top: 2px;
            margin-bottom: 2px;
            box-sizing: border-box;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: 2px solid #66ccff;
        }
        .checkbox-group {
            margin: 0.5rem 0 0.5rem 0;
            padding: 1rem 1.2rem;
            background: rgba(0, 41, 102, 0.7);
            border-radius: 10px;
            color: #cce6ff;
            font-size: 0.98rem;
        }
        .add-button#btn_sign {
            width: 160px;
            padding: 10px 0;
            font-size: 1rem;
            margin: 0.5rem auto 0 auto;
            display: block;
            float: none;
            background-color: #0056b3;
            color: #fff;
            border-radius: 6px;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            border: none;
            transition: background 0.3s, box-shadow 0.2s, transform 0.2s;
        }
        .add-button#btn_sign:hover, .add-button#btn_sign:focus {
            background-color: #3399ff;
            color: #fff;
            box-shadow: 0 0 10px #3399ff;
            transform: scale(1.04);
        }
        @media (max-width: 1100px) {
            .admin-register-form {
                max-width: 98vw;
                padding: 1rem 0.5rem;
            }
        }
        @media (max-width: 900px) {
            .form-row {
                flex-direction: column;
                gap: 1.5rem;
            }
            .form-section {
                padding-bottom: 1.5rem;
            }
            .add-button#btn_sign {
                float: none;
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
        }
    </style>
</head>
<body>
    <br>
    @include('layouts.error-pop')
     <a href="{{ route('admins.index') }}" class="back-button">&larr; Back to Admins</a>
    <div class="items-wrapper">
        <h1 class="title">Register New Admin</h1>
        <form action="{{ route('admin.register') }}" method="POST" class="admin-register-form">
        @csrf
            <div class="form-row">
                <fieldset class="form-section">
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
                <fieldset class="form-section">
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
                <fieldset class="form-section">
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
            </div>
        <div class="checkbox-group">
                <input type="checkbox" required> Agree to <a href="#" id="termsLink">Terms and Conditions</a><br>
                <input type="checkbox" required> Give consent to <a href="#" id="privacyPolicyLink">Data Privacy Policy</a>
            </div>

<!-- Data Privacy Policy Modal -->
<div id="privacyPolicyModal" style="display:none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6); z-index: 100200;">
    <div id="privacyPolicyContent" style="
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        color: #222;
        max-width: 600px;
        width: 90vw;
        max-height: 80vh;
        overflow-y: auto;
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        padding: 2rem 2.2rem 1.5rem 2.2rem;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    ">
        <button onclick="closePrivacyPolicyModal()" style="
            position: absolute;
            top: 16px;
            right: 18px;
            background: none;
            border: none;
            color: #0056b3;
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
            z-index: 10;
        " aria-label="Close">&times;</button>
        <h2 style="margin-top:0; color:#0056b3;">ARICC Inventory System – Data Privacy Policy</h2>
        <p><strong>Effective Date:</strong> July 25, 2025</p>
        <p>The Advanced Robotics and Intelligent Control Center (ARICC) at Bulacan State University is committed to protecting the privacy and security of personal information collected through the ARICC Inventory System. This Data Privacy Policy outlines how we collect, use, store, and protect your personal data in compliance with the Republic Act No. 10173 or the Data Privacy Act of 2012.</p>
        <h3>1. Scope</h3>
        <p>This policy applies to all users of the ARICC Inventory System, including students, faculty, staff, administrators, and other authorized users who access or interact with the system.</p>
        <h3>2. Data We Collect</h3>
        <p>When you register for or use the ARICC Inventory System, we collect the following personal and usage data:</p>
        <ul>
            <li>Full Name</li>
            <li>Student or Employee ID Number</li>
            <li>BulSU Email Address</li>
            <li>Course/Department</li>
            <li>Contact Number (if applicable)</li>
            <li>Borrowing and Transaction History</li>
            <li>Login Records and Activity Logs</li>
            <li>Uploaded Files (e.g., proof of receipt, item images)</li>
        </ul>
        <h3>3. Purpose of Data Collection</h3>
        <p>We collect your data to:</p>
        <ul>
            <li>Verify your identity and authorize access to the system</li>
            <li>Track and manage item borrowing and return transactions</li>
            <li>Maintain accurate inventory and user logs</li>
            <li>Generate reports for internal use and compliance</li>
            <li>Communicate with users regarding item status or policy updates</li>
            <li>Improve the performance, functionality, and security of the system</li>
        </ul>
        <h3>4. Data Storage and Protection</h3>
        <ul>
            <li>All personal data is stored securely on university-managed servers with appropriate safeguards in place.</li>
            <li>Access to data is restricted to authorized ARICC personnel and system administrators only.</li>
            <li>We use industry-standard security measures such as encryption, access control, and secure authentication.</li>
            <li>Activity logs are regularly monitored to prevent unauthorized access or misuse.</li>
        </ul>
        <h3>5. Data Retention</h3>
        <p>We retain personal data only for as long as it is necessary for the purpose for which it was collected, or as required by university policy and applicable law.</p>
        <h3>6. Data Sharing and Disclosure</h3>
        <p>We do not sell, rent, or share your personal data with third parties. However, your data may be disclosed:</p>
        <ul>
            <li>To authorized BulSU administrators for academic or disciplinary processes</li>
            <li>To comply with legal obligations or government requests</li>
            <li>In emergencies where the safety or rights of an individual or the institution are at risk</li>
        </ul>
        <h3>7. Your Rights Under the Data Privacy Act</h3>
        <p>As a data subject, you have the right to:</p>
        <ul>
            <li>Be informed about how your data is collected and processed</li>
            <li>Access your personal data</li>
            <li>Correct any inaccurate or outdated information</li>
            <li>Object to processing under certain circumstances</li>
            <li>Request deletion of data no longer necessary</li>
            <li>File a complaint with the National Privacy Commission if your data privacy rights are violated</li>
        </ul>
        <p>To exercise any of these rights, please contact us (see Section 9).</p>
        <h3>8. Cookies and Analytics</h3>
        <p>The system may use cookies for session management, security, and system optimization. These cookies do not collect personal information and are used solely to improve your experience on the system.</p>
        <h3>9. Contact Us</h3>
        <p>If you have any questions, requests, or concerns about this Data Privacy Policy or how your data is handled, you may contact:</p>
        <p>
            <strong>ARICC Privacy Officer</strong><br>
            Advanced Robotics and Intelligent Control Center (ARICC)<br>
            Bulacan State University, Malolos City<br>
            Email: aricc@bulsu.edu.ph<br>
            Office Hours: 8:00 AM – 5:00 PM, Monday to Friday
        </p>
        <h3>10. Updates to This Policy</h3>
        <p>This policy may be revised from time to time to reflect changes in the law or university policy. Users will be notified of any significant updates via the system dashboard or email.</p>
        <p><strong>By using the ARICC Inventory System, you acknowledge that you have read and understood this Data Privacy Policy and consent to the collection and use of your data in accordance with it.</strong></p>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div id="termsModal" style="display:none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6); z-index: 100200;">
    <div id="termsContent" style="
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        color: #222;
        max-width: 600px;
        width: 90vw;
        max-height: 80vh;
        overflow-y: auto;
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        padding: 2rem 2.2rem 1.5rem 2.2rem;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    ">
        <button onclick="closeTermsModal()" style="
            position: absolute;
            top: 16px;
            right: 18px;
            background: none;
            border: none;
            color: #0056b3;
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
            z-index: 10;
        " aria-label="Close">&times;</button>
        <h2 style="margin-top:0; color:#0056b3;">ARICC Inventory System – Terms and Conditions</h2>
        <p><strong>Last Updated:</strong> July 25, 2025</p>
        <p>Welcome to the ARICC Inventory System ("System"), developed and managed by the Advanced Robotics and Intelligent Control Center (ARICC), Bulacan State University. By accessing, registering, or using this System, you agree to be bound by the following Terms and Conditions.</p>
        <p>If you do not agree with any part of these terms, please refrain from using the System.</p>
        <h3>1. User Eligibility</h3>
        <ul>
            <li>1.1 Only authorized personnel, students, faculty, and administrative staff of Bulacan State University with assigned login credentials are allowed to use the ARICC Inventory System.</li>
            <li>1.2 Users must provide accurate, complete, and current information during registration.</li>
            <li>1.3 Accounts are non-transferable and may not be shared between individuals.</li>
        </ul>
        <h3>2. Access and Usage</h3>
        <ul>
            <li>2.1 The System is provided for the purpose of inventory management, item borrowing, return logging, and asset monitoring within ARICC.</li>
            <li>2.2 Users agree not to misuse the system for activities including but not limited to:
                <ul>
                    <li>Tampering with inventory records</li>
                    <li>Unauthorized data access or modification</li>
                    <li>Uploading malicious files or harmful content</li>
                </ul>
            </li>
            <li>2.3 Any attempt to breach or bypass security measures will result in immediate suspension and disciplinary action.</li>
        </ul>
        <h3>3. Item Borrowing and Return</h3>
        <ul>
            <li>3.1 All borrowed items must be recorded in the system before physical retrieval.</li>
            <li>3.2 Borrowers are fully responsible for items checked out under their account and agree to:
                <ul>
                    <li>Return items on or before the due date</li>
                    <li>Maintain proper condition of items during the borrow period</li>
                    <li>Report any damage or malfunction immediately</li>
                </ul>
            </li>
            <li>3.3 Late returns may be subject to warnings, restricted borrowing privileges, or other administrative penalties.</li>
            <li>3.4 Failure to return borrowed items may lead to replacement charges, academic holds, or disciplinary sanctions.</li>
        </ul>
        <h3>4. Item Condition and Loss</h3>
        <ul>
            <li>4.1 All items are inspected and verified before lending.</li>
            <li>4.2 Users are liable for any damage, theft, or loss of items while under their responsibility.</li>
            <li>4.3 ARICC reserves the right to:
                <ul>
                    <li>Impose a repair or replacement cost</li>
                    <li>Initiate further investigation or administrative action</li>
                </ul>
            </li>
        </ul>
        <h3>5. Data Collection and Privacy</h3>
        <ul>
            <li>5.1 The system collects the following user data:
                <ul>
                    <li>Full name, email address, student/staff ID</li>
                    <li>Borrowing history and transaction logs</li>
                    <li>Uploaded files (e.g., digital receipts, item images)</li>
                </ul>
            </li>
            <li>5.2 All data collected will be stored securely and will only be accessible to authorized personnel.</li>
            <li>5.3 ARICC will not share your personal data with external entities unless required by law or with your explicit consent.</li>
            <li>5.4 Users may request to access, correct, or delete their data through formal written requests.</li>
        </ul>
        <h3>6. Account Suspension or Termination</h3>
        <ul>
            <li>6.1 ARICC reserves the right to suspend or permanently revoke access to users who:
                <ul>
                    <li>Repeatedly violate borrowing terms</li>
                    <li>Are found guilty of misuse, abuse, or system tampering</li>
                    <li>Engage in fraudulent activity or misrepresentation</li>
                </ul>
            </li>
            <li>6.2 Appeals for account suspension must be submitted in writing to the ARICC coordinator or designated admin.</li>
        </ul>
        <h3>7. System Availability and Maintenance</h3>
        <ul>
            <li>7.1 While ARICC strives to ensure uninterrupted service, there may be periodic downtime due to maintenance, updates, or unforeseen issues.</li>
            <li>7.2 Users will be notified of scheduled maintenance through email or dashboard alerts whenever possible.</li>
            <li>7.3 ARICC is not liable for any data loss or inconvenience caused by system outages.</li>
        </ul>
        <h3>8. Intellectual Property</h3>
        <ul>
            <li>8.1 All content, software, design, and databases within the ARICC Inventory System are the intellectual property of ARICC and/or Bulacan State University.</li>
            <li>8.2 Unauthorized reproduction, duplication, or redistribution of any part of the system is strictly prohibited.</li>
        </ul>
        <h3>9. Amendments to Terms</h3>
        <ul>
            <li>9.1 ARICC reserves the right to amend these Terms and Conditions at any time.</li>
            <li>9.2 Users will be notified via system alerts or email for any significant changes. Continued use of the system after such changes implies acceptance.</li>
        </ul>
        <h3>10. Limitation of Liability</h3>
        <ul>
            <li>10.1 ARICC shall not be liable for any direct or indirect damages resulting from:
                <ul>
                    <li>Misuse of the system</li>
                    <li>Unauthorized access</li>
                    <li>System downtime or data corruption</li>
                </ul>
            </li>
            <li>10.2 Users are encouraged to regularly monitor their transactions and report discrepancies immediately.</li>
        </ul>
        <h3>11. Governing Law</h3>
        <p>These terms are governed by the applicable policies of Bulacan State University and, where appropriate, by Philippine law.</p>
        <h3>12. Contact Information</h3>
        <p>For any concerns, questions, or feedback related to these Terms and Conditions, please contact:</p>
        <p>
            <strong>ARICC Admin Office</strong><br>
            Bulacan State University<br>
            Email: aricc@bulsu.edu.ph<br>
            Phone: 09256768867<br>
            Office Hours: 8:00 AM – 5:00 PM, Monday to Friday
        </p>
        <p><strong>By continuing to use the ARICC Inventory System, you acknowledge that you have read, understood, and agree to these Terms and Conditions.</strong></p>
    </div>
</div>
<script>
    document.getElementById('privacyPolicyLink').onclick = function(e) {
        e.preventDefault();
        document.getElementById('privacyPolicyModal').style.display = 'block';
    };
    function closePrivacyPolicyModal() {
        document.getElementById('privacyPolicyModal').style.display = 'none';
    }
    // Optional: close modal when clicking outside the content
    document.getElementById('privacyPolicyModal').onclick = function(e) {
        if (e.target === this) closePrivacyPolicyModal();
    };

    document.getElementById('termsLink').onclick = function(e) {
        e.preventDefault();
        document.getElementById('termsModal').style.display = 'block';
    };
    function closeTermsModal() {
        document.getElementById('termsModal').style.display = 'none';
    }
    document.getElementById('termsModal').onclick = function(e) {
        if (e.target === this) closeTermsModal();
    };
</script>
                @if($errors->any())
                    <div class="form-group error-box" style="color: red; margin-bottom: 10px;">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            <button class="add-button" id="btn_sign" type="submit">Register</button>
    </form>
</div>
</body>
</html>