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
                The <strong>Advanced Robotics and Control Center (ARICC)</strong> is a pioneering hub dedicated to the research,
                innovation, and application of robotics and intelligent systems. Established to serve both academic
                and practical needs, ARICC offers state-of-the-art facilities for developing robotic solutions in
                automation, control systems, and artificial intelligence.
            </p>
            <p>
                Our mission is to empower students and professionals with the tools and knowledge to solve
                real-world problems using cutting-edge technology. At ARICC, we believe in hands-on learning,
                collaborative research, and making robotics accessible to everyone.
            </p>
        </div>

        <table style="width: 100%; border-spacing: 40px;">
    <tr>
        <td style="vertical-align: top; width: 50%;">
            <div class="section achievements">
                <h2> Achievements</h2>
                <ul>
                    <li>Champion – National Robotics Olympiad 2023</li>
                    <li>Published 20+ research papers in international AI journals</li>
                    <li>Built the first autonomous drone navigation system in the region</li>
                    <li>Trained 500+ students in AI, IoT, and Control Systems</li>
                </ul>
            </div>
        </td>
        <td style="vertical-align: top; width: 50%;">
            <div class="section team">
                <h2> Team Members</h2>
                <ul class="team-list">
                    <li><i class="fas fa-user"></i> <strong>Dr. Arvin Santos</strong> – Director & Robotics Lead</li>
                    <li><i class="fas fa-user"></i> <strong>Engr. Jhenelle Carpio</strong> – Control Systems Specialist</li>
                    <li><i class="fas fa-user"></i> <strong>Prof. Rica Morales</strong> – AI & ML Advisor</li>
                    <li><i class="fas fa-user"></i> <strong>Mark Dela Cruz</strong> – Software Developer</li>
                    <li><i class="fas fa-user"></i> <strong>Angela Torres</strong> – Research Coordinator</li>
                </ul>
            </div>
        </td>
    </tr>
</table>

        
    </div>
</body>
</html>
