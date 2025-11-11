<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cardiology Department | MyHospital</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .doctor-card {
      border-radius: 1rem;
      box-shadow: 0 2px 12px rgba(0,0,0,0.08);
      margin-bottom: 2rem;
      transition: box-shadow 0.2s;
    }
    .doctor-card:hover {
      box-shadow: 0 4px 24px rgba(0,0,0,0.15);
    }
    .doctor-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 1rem;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="text-center mb-5">
      <h1 class="display-4 fw-bold text-primary">Cardiology Department</h1>
      <p class="lead text-secondary">Expert heart care from leading cardiologists. Our Cardiology Department offers advanced diagnostics, treatments, and compassionate support for all heart conditions.</p>
    </div>
    <h2 class="mb-4 text-success">Available Cardiologists</h2>
    <div id="cardiology-doctors" class="row justify-content-center">
      <!-- Doctor profiles will be loaded here -->
    </div>
  </div>
  <script>
    // Fetch and display cardiology doctors
    fetch('api_doctors.php')
      .then(response => response.json())
      .then(result => {
        if (result.success && result.data) {
          const doctors = result.data.filter(doc => doc.department === 'Cardiology');
          const container = document.getElementById('cardiology-doctors');
          if (doctors.length === 0) {
            container.innerHTML = '<div class="col-12 text-center text-muted">No cardiologists available at the moment.</div>';
          } else {
            doctors.forEach(doc => {
              container.innerHTML += `
                <div class="col-md-6 col-lg-4">
                  <div class="doctor-card p-4 d-flex align-items-center bg-white">
                    <img src="assets/img/pic1.jpg.jpg" class="doctor-img" alt="${doc.full_name}">
                    <div>
                      <h5 class="mb-1">${doc.full_name}</h5>
                      <p class="mb-2 text-muted">${doc.qualifications || 'Cardiologist'}</p>
                      <button class="btn btn-outline-success btn-sm" onclick="window.location.href='appointment_book.php?doctor_id=${doc.id}'">Book Appointment</button>
                    </div>
                  </div>
                </div>
              `;
            });
          }
        }
      });
  </script>
</body>
</html>
<?php include 'includes/footer.php'; ?>
