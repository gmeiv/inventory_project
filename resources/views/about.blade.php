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

    <div class="about-wrapper">

    
        <div class="header">
        <h1><span class="highlight">Advanced Robotics and Control Center</span> (ARICC)</h1>
            <h3>Bulacan State University</h3>
        </div>

    
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

       
        <div class="grid-sections">
        <div class="section achievements card">
                <h2><i class="fas fa-cogs"></i> Services</h2>
                <ul class="services-list">
                    <li>
                        <i class="fas fa-microchip service-icon"></i>
                        <div>
                            <strong>PCB Fabrication</strong><br>
                            We design and manufacture custom Printed Circuit Boards (PCBs) for research, development, and prototyping.
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-robot service-icon"></i>
                        <div>
                            <strong>Robotics Training</strong><br>
                            Hands-on training and workshops on robotics and automation for students and professionals.
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-industry service-icon"></i>
                        <div>
                            <strong>Automation Solutions</strong><br>
                            Customized automation systems for industries, improving efficiency and reducing manual work.
                        </div>
                    </li>
                </ul>
            </div>

            <div class="section team card">
                <h2><i class="fas fa-users"></i> Team Members</h2>
                <ul class="team-list">
                    <li><i class="fas fa-user"></i> <strong>Dr. Bernardo Pangilinan</strong> – Center Manager</li>
                    <li><i class="fas fa-user"></i> <strong>Engr. John Michael Satiago</strong> – Software Developer</li>
                    <li><i class="fas fa-user"></i> <strong>Engr. Mark Soriano</strong> – Software Developer</li>
                    <li><i class="fas fa-user"></i> <strong>Engr. Lanfeal Martinez</strong> – Software Developer</li>
                    <li><i class="fas fa-user"></i> <strong>Engr. Jerome Bagsic</strong> – Software Developer</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
