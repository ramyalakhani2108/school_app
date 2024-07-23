<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/public/img/favicon.png" rel="icon">
    <link href="assets/public/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/public/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/public/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/public/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/public/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <!-- <script src="/public\assets\public\js\indexeddb.js"></script> -->
    <link href="/assets/public/css/main.css" rel="stylesheet">
    <script src="/assets/public/js/verify_token.js">
    </script>
    <script src="/assets/public/js/indexeddb.js"></script>


</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="/" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/public/img/logo.png" alt=""> -->
                <h1 class="sitename">Mentor</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="/" onclick="makeActive('home')" id="home">Home<br></a></li>
                    <li><a href="/about" onclick="makeActive('about')" id="about">About</a></li>
                    <li><a href="/courses" onclick="makeActive('subjects')" id="subjects">Subjects</a></li>
                    <li><a href="/trainers" onclick="makeActive('trainers')" id="trainers">Trainers</a></li>
                    <li><a href="/evenets" onclick="makeActive('events')" id="events">Events</a></li>
                    <li><a href="/pricing" onclick="makeActive('pricing')" id="pricing">Pricing</a></li>
                    <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Dropdown 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="#">Deep Dropdown 1</a></li>
                                    <li><a href="#">Deep Dropdown 2</a></li>
                                    <li><a href="#">Deep Dropdown 3</a></li>
                                    <li><a href="#">Deep Dropdown 4</a></li>
                                    <li><a href="#">Deep Dropdown 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Dropdown 2</a></li>
                            <li><a href="#">Dropdown 3</a></li>
                            <li><a href="#">Dropdown 4</a></li>
                        </ul>
                    </li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="/login">Get Started</a>

        </div>
        <script>
            function makeActive(id) {

                // Remove the 'active' class from any element that currently has it
                const currentActive = document.querySelector('.active');
                if (currentActive) {
                    currentActive.classList.remove('active');
                }

                // Add the 'active' class to the clicked element
                const newActive = document.getElementById(id);
                newActive.classList.add('active');
            }
        </script>
    </header>