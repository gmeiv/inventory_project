<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About ARICC</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    @include('layouts.header')

    <div class="about-wrapper" >
        

        <div class="section description">
            <p>
                The <strong>Advanced Robotics and Control Center (ARICC)</strong> is established with other 
                Regional Development Centers in Bulacan State University to serve as a hub for innovations or 
                Research and Development of intelligent systems and robotics. It is envisioned that through the Center, 
                innovative technologies, relevant support services, technical expertise, necessary infrastructure, and 
                facilities will be more accessible for communities, establishments, and institutions in the urban centers 
                and countryside for a more effective technology application, deployment (technology transfer), and 
                commercialization for sustained economic growth and productivity.


            </p>
            <p>
                Our mission is to to provide innovative technologies, trainings, and relevant support services 
                to contribute to inclusive, empowerment, and sustained development of the academes, communities, and industries. 
                The center aims to design, develop, and innovate advanced robotics and intelligent systems for the communities and 
                industries of Region III, obtain patents and publish research recognized locally and internationally, and facilitate 
                technology transfer to clients and beneficiaries—ultimately enhancing the work and environment across sectors such as academia, 
                business, manufacturing, healthcare, military, and disaster-risk management.


            </p>
        </div>

        <table style="width: 100%; border-spacing: 40px;">
    <tr>
        <td style="vertical-align: top; width: 50%;">
            <div class="section achievements">
                <h2> Services</h2>
                <ul>
                    <li>PCB Fabrication</li>
                    <li>Robotics Training</li>
                    <li>Automation Solutions</li>
                    <li></li>
                </ul>
            </div>
        </td>
        <td style="vertical-align: top; width: 50%;">
            <div class="section team">
                <h2> Team Members</h2>
                <ul class="team-list">
                    <li><i class="fas fa-user"></i> <strong>Dr. Bernardo Pangilinan </strong> – Center Manager</li>
                    <li><i class="fas fa-user"></i> <strong>Engr. John Michael Satiago</strong> – Software Developer</li>
                    <li><i class="fas fa-user"></i> <strong>Engr. Mark Soriano</strong> – Software Developer</li>
                    <li><i class="fas fa-user"></i> <strong>Engr. Lanfeal Martinez</strong> – Software Developer</li>
                    <li><i class="fas fa-user"></i> <strong>Engr. Jerome Bagsic</strong> – Software Developer</li>
                </ul>
            </div>
        </td>
    </tr>
</table>

        
    </div>
</body>
</html>
