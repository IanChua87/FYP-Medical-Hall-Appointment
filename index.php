<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Main</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>


<!--navbar-->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">Logo</a>
    
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Booking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav">
                    <a class="btn sign-up-btn" href="forms/register.php" role="button">Sign Up</a>
                    <a class="btn login-btn" href="forms/login.php" role="button">Login</a>
                </ul>
            </div>
        </div>
    </nav>



<!--hero-->
<section class="hero" id="hero">
    <div class="container">
        <div class="hero-text">
            <h1>Providing quality <br>care and <br>convenience for all</h1>
            <p>Sin Nam Medical Hall is a Chinese Medical Hall with <br> more than 60 years of history. It specializes in <br> Traditional Chinese medicine and professional <br> consulation services.</p>
            <div class="mt-3">
                <a href="#about" class="btn learn-more-btn">Learn More</a>
            </div>
        </div>
    </div>
</section>




<!--about-->
<section class="about" id="about">
    <div class="about-box">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 left-col">
                <h2>About Us</h2>
                <p>At Sim Nam Medical Hall, we pride ourselves on <br> a rich history and legacy that spans over multiple <br> generations. Established with a vision to provide <br> exceptional and professional healthcare services, <br> we have been serving the community for <br> decades, earning the trust and respect <br> of our patients.</p>
            </div>
            <div class="col-12 col-md-6 col-lg-6 right-col">
                <img src="img/sin-nam-brand.png" alt="about-section">
            </div>
        </div>
    </div>
</section>

<section class="services" id="services">
    <div class="services-box">
        <h2 class="text-center">Our Services</h2>
        <div class="row row-md-2 g-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <img src="img/medical-herbs.png" class="card-img-top img-fluid" alt="consultation img">
                    <div class="card-body">
                      <h5 class="card-title">Personalized TCM Consultations</h5>
                      <p class="card-text">Our expert practitioners provide comprehensive health assessments and personalized treatment plans based on Traditional Chinese Medicine principles. Discover how TCM addresses health concerns and promote overall wellness.</p>
                      <a href="#" class="btn learn-more-btn mt-auto">Learn More</a>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <img src="img/accupuncture.png" class="card-img-top img-fluid" alt="acupuncture img">
                    <div class="card-body">
                      <h5 class="card-title">Effective Acupuncture Treatments </h5>
                      <p class="card-text">Experience the benefits of acupuncture for pain relief, stress reduction, and enhanced well-being. Our skilled acupuncturists use precise techniques to restore balance and improve your health naturally.</p>
                      <a href="#" class="btn learn-more-btn mt-auto">Learn More</a>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4">
                <div class="card h-100">
                    <img src="img/medical-herbs.png" class="card-img-top img-fluid" alt="chinese herbs img">
                    <div class="card-body">
                      <h5 class="card-title">Customized Chinese Herbal Prescriptions</h5>
                      <p class="card-text">Receive tailored herbal formulations designed to address your specific health needs. Our high-quality, natural herbal prescriptions support your body’s healing processes and promote holistic health.</p>
                      <a href="#" class="btn learn-more-btn mt-auto">Learn More</a>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</section>

<section class="operating-hours" id="operating-hours">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-5 col-lg-5">
                <h2>Opening Hours</h2>
                <h3>Tuesday - Friday</h3>
                <p class="mb-4">11AM - 4:30PM</p>
                <h3>Saturday</h3>
                <p class="mb-0">10:30AM - 4:30PM</p>
            </div>
            <div class="col-12 col-md-7 col-lg-7">
                <h2>Appointment Duration</h2>
                <h3>New Patients</h3>
                <p class="mb-4">30 mins</p>
                <h3>Registered Patients</h3>
                <p class="mb-0">15 mins</p>
            </div>
        </div>
    </div>
</section>

    <section class="contact" id="contact">
        <h2 class="text-center">Contact Us</h2>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-6">
                    <form action="forms/contact.php" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control-lg" name="name" placeholder="Name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control-lg" name="email" placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control feedback-field" name="message" rows="6" placeholder="Feedback"></textarea>
                        </div>
                        <button type="submit" class="btn submit-btn">Submit</button>
                    </form>
                </div>
    
                <div class="col-12 col-md-12 col-lg-6">
                    <img src="img/contact-img.png" alt="contact-img">
                </div>
            </div>
        </div>
    </section>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-3">
                <h2 class="logo">Logo</h2>
            </div>
            <div class="col-12 col-md-12 col-lg-6">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Booking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-12 col-lg-3">
                <div class="contact-details">
                    <div class="address">
                        <i class="bi bi-geo-alt-fill"></i>
                        <p>#01-101 Yishun Street 71, Block 729, Singapore 760729</p>
                    </div>
                    <div class="phone">
                        <i class="bi bi-telephone-fill"></i>
                        <p>6257 0881</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-separator"></div>
        <p class="copyright-text mb-0">&copy; 2024 My Web Page. All rights reserved.</p>
    </div>
</footer>

</body>
</html>