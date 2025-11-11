
<?php include 'includes/header.php'; ?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MyHospital</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .carousel-item img {
      height: 100vh;
      object-fit: cover;
    }
    .carousel-overlay {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.45);
      z-index: 2;
    }
    .carousel-caption {
      z-index: 3;
      text-shadow: 0 2px 8px #000;
    }
  </style>
</head>
<body>

  <!-- Emergency Banner -->
  <div class="bg-danger text-white text-center py-2 fw-bold" style="font-size:1.2rem; letter-spacing:1px;">
    🚨 Emergency? Call <span class="fw-bolder">1800-123-456</span> 24/7
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">🏥 MyHospital</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="departmentsDropdown" role="button" data-bs-toggle="dropdown">Departments</a>
            <ul class="dropdown-menu" id="departments-menu">
              <li><span class="dropdown-item text-muted">Loading...</span></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="doctorsDropdown" role="button" data-bs-toggle="dropdown">Doctors</a>
            <ul class="dropdown-menu" id="doctors-menu">
              <li><span class="dropdown-item text-muted">Loading...</span></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="#" id="appointment-link">Appointment</a></li>
          <li class="nav-item">
            <a class="btn btn-outline-primary ms-3" href="patient_auth.php" style="font-weight:600;">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Carousel -->
  <div id="hospitalCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/img/slide1.jpg.jpg" class="d-block w-100" alt="Hospital 1">
      </div>
      <div class="carousel-item">
        <img src="assets/img/slide2.jpg.jpg" class="d-block w-100" alt="Hospital 2">
      </div>
      <div class="carousel-item">
        <img src="assets/img/slide3.jpg.jpg" class="d-block w-100" alt="Hospital 3">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#hospitalCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#hospitalCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
    <div class="carousel-overlay"></div>
    <div class="carousel-caption position-absolute top-50 start-50 translate-middle text-center">
      <h1 class="display-3 fw-bold text-white mb-3">Your Health, Our Priority</h1>
      <p class="lead text-white mb-4">Book appointments with trusted doctors in just a few clicks.</p>
      <a href="#" class="btn btn-lg btn-success shadow-lg px-5 py-3 fs-3" id="carousel-appointment-btn">Book Appointment</a>
  <!-- ...existing code... -->
    </div>
  </div>

  <!-- About Section -->
  <section id="about" class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h2 class="card-title mb-3 text-primary">About Us</h2>
            <p class="card-text">
              MyHospital is a leading healthcare provider, offering world-class medical services with compassion and care. Our team of expert doctors and modern facilities ensure you receive the best treatment possible.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-light text-center py-4 mt-5 shadow-sm">
    <p class="mb-0">&copy; 2025 MyHospital. All rights reserved.</p>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Set carousel interval to 4000ms (4 seconds) and enable slide animation
      var carouselElement = document.getElementById('hospitalCarousel');
      if (carouselElement) {
        var carousel = new bootstrap.Carousel(carouselElement, {
          interval: 4000,
          ride: 'carousel',
          pause: false,
          wrap: true
        });
      }
      // Fix appointment button to go to appointment page without blink
      const carouselBtn = document.getElementById('carousel-appointment-btn');
      if (carouselBtn) {
        carouselBtn.onclick = function(e) {
          e.preventDefault();
          window.location.assign('patient_auth.php');
        };
      }

      // Dropdown population logic (moved from footer.php)
      function loadDepartments() {
        const menu = document.getElementById('departments-menu');
        fetch('/hospital_project/website/api_departments.php')
          .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
          })
          .then(result => {
            if (result.success && result.data) {
              menu.innerHTML = '';
              if (result.data.length === 0) {
                menu.innerHTML = '<li><span class="dropdown-item">No departments available</span></li>';
              } else {
                result.data.forEach(dept => {
                    if (dept.name === 'Cardiology') {
                      menu.innerHTML += `<li><a class="dropdown-item" href="cardiology.php">${dept.name}</a></li>`;
                    } else {
                      menu.innerHTML += `<li><a class="dropdown-item" href="#">${dept.name}</a></li>`;
                    }
                });
              }
            } else {
              throw new Error(result.error || 'Failed to load departments');
            }
          })
          .catch(error => {
            console.error('Error loading departments:', error);
            menu.innerHTML = '<li><span class="dropdown-item text-danger">Error loading departments</span></li>';
          });
      }
      function loadDoctors() {
        const menu = document.getElementById('doctors-menu');
        fetch('/hospital_project/website/api_doctors.php')
          .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
          })
          .then(result => {
            if (result.success && result.data) {
              menu.innerHTML = '';
              if (result.data.length === 0) {
                menu.innerHTML = '<li><span class="dropdown-item">No doctors available</span></li>';
              } else {
                result.data.forEach(doctor => {
                  menu.innerHTML += `<li><a class="dropdown-item" href="#">${doctor.full_name}</a></li>`;
                });
              }
            } else {
              throw new Error(result.error || 'Failed to load doctors');
            }
          })
          .catch(error => {
            console.error('Error loading doctors:', error);
            menu.innerHTML = '<li><span class="dropdown-item text-danger">Error loading doctors</span></li>';
          });
      }
      document.getElementById('departmentsDropdown').addEventListener('click', function() {
        if (document.getElementById('departments-menu').innerHTML.includes('Loading')) {
          loadDepartments();
        }
      });
      document.getElementById('doctorsDropdown').addEventListener('click', function() {
        if (document.getElementById('doctors-menu').innerHTML.includes('Loading')) {
          loadDoctors();
        }
      });
    });
  </script>
</body>
</html>