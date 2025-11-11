<?php
// patient_auth.php
require_once '../includes/config.php';

$error = '';
$mode = $_GET['mode'] ?? 'login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Login logic
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $stmt = $pdo->prepare('SELECT id, password, first_name, last_name FROM patients WHERE email = ?');
        $stmt->execute([$email]);
        $patient = $stmt->fetch();
        if ($patient && password_verify($password, $patient['password'])) {
            $_SESSION['patient_id'] = $patient['id'];
            $_SESSION['patient_name'] = $patient['first_name'] . ' ' . $patient['last_name'];
            header('Location: patient_dashboard.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    } elseif (isset($_POST['signup'])) {
        // Signup logic
        $first = trim($_POST['first_name']);
        $last  = trim($_POST['last_name']);
        $dob   = $_POST['dob'];
        $gender= $_POST['gender'];
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $addr  = trim($_POST['address']);
        $department_id = $_POST['department_id'] ?? '';
        $doctor_id = $_POST['doctor_id'] ?? '';
        $password = $_POST['password'] ?? '';
        if ($first === '' || !$department_id || !$doctor_id || $password === '') {
            $error = 'All fields are required.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = 'INSERT INTO patients (first_name, last_name, dob, gender, phone, email, password, address, department_id, doctor_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([$first, $last, $dob, $gender, $phone, $email, $hash, $addr, $department_id, $doctor_id]);
                $_SESSION['patient_id'] = $pdo->lastInsertId();
                $_SESSION['patient_name'] = $first . ' ' . $last;
                header('Location: patient_dashboard.php');
                exit;
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') {
                    $error = 'Email already exists.';
                } else {
                    $error = 'Error: ' . $e->getMessage();
                }
            }
        }
    }
}

$departments = $pdo->query('SELECT id, name FROM departments ORDER BY name')->fetchAll();
$doctors = $pdo->query('SELECT d.id, d.full_name, d.department_id FROM doctors d ORDER BY d.full_name')->fetchAll();
require_once 'includes/header.php';
?>
<style>
.auth-container {
    min-height: 100vh;
    background: url('assets/img/pic6.jpg.jpg') no-repeat center center fixed;
    background-size: cover;
    padding: 40px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.glass-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    padding: 40px;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    width: 100%;
    max-width: 800px;
}

.auth-title {
    color: white;
    text-align: center;
    margin-bottom: 30px;
    font-size: 2.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}


.form-control, .form-select {
  background: rgba(255, 255, 255, 0.2) !important;
  border: 1px solid rgba(255, 255, 255, 0.3) !important;
  color: white !important;
  backdrop-filter: blur(5px);
}

/* Make dropdown options readable */
select.form-select, select {
  color: #222 !important;
  background: rgba(255,255,255,0.95) !important;
}

select.form-select option, select option {
  color: #222 !important;
  background: #fff !important;
}

.form-control:focus, .form-select:focus {
    background: rgba(255, 255, 255, 0.25) !important;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.2) !important;
}

.form-control::placeholder, .form-label {
    color: rgba(255, 255, 255, 0.8) !important;
}

.btn-auth {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 30px;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.btn-auth:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.auth-switch {
    color: white;
    text-align: center;
    margin-top: 20px;
}

.auth-switch a {
    color: #fff;
    text-decoration: underline;
}
</style>

<div class="auth-container">
    <div class="glass-card">
        <h2 class="auth-title"><?= $mode === 'signup' ? 'Create Your Account' : 'Welcome Back' ?></h2>
        <?php if ($error): ?>
            <div class="alert alert-danger bg-danger text-white" style="background: rgba(220, 53, 69, 0.8) !important;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if ($mode === 'signup'): ?>
      <form method="post">
        <div class="row g-4">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">First Name</label>
              <input name="first_name" class="form-control" required placeholder="Enter your first name" />
            </div>
            <div class="mb-3">
              <label class="form-label">Last Name</label>
              <input name="last_name" class="form-control" placeholder="Enter your last name" />
            </div>
            <div class="mb-3">
              <label class="form-label">Date of Birth</label>
              <input type="date" name="dob" class="form-control" />
            </div>
            <div class="mb-3">
              <label class="form-label">Gender</label>
              <select name="gender" class="form-select">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input name="phone" class="form-control" placeholder="Enter your phone number" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Email Address</label>
              <input type="email" name="email" class="form-control" required placeholder="Enter your email address" />
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required placeholder="Choose a secure password" />
            </div>
            <div class="mb-3">
              <label class="form-label">Address</label>
              <textarea name="address" class="form-control" rows="3" placeholder="Enter your full address"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Department</label>
              <select name="department_id" id="department-select" class="form-select" required onchange="filterDoctors()">
                <option value="">Select Department</option>
                <?php foreach ($departments as $d): ?>
                  <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Doctor</label>
              <select name="doctor_id" id="doctor-select" class="form-select" required>
                <option value="">Select Doctor</option>
                <?php foreach ($doctors as $doc): ?>
                  <option value="<?= $doc['id'] ?>" data-dept="<?= $doc['department_id'] ?>">
                    <?= htmlspecialchars($doc['full_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="text-center mt-4">
          <button type="submit" name="signup" class="btn btn-auth btn-lg">Create Account</button>
          <div class="auth-switch">
            Already have an account? <a href="?mode=login">Login here</a>
          </div>
        </div>
      </form>
  <?php else: ?>
    <form method="post">
      <div class="mb-4">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" required placeholder="Enter your email address" />
      </div>
      <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required placeholder="Enter your password" />
      </div>
      <div class="text-center mt-4">
        <button type="submit" name="login" class="btn btn-auth btn-lg">Sign In</button>
        <div class="auth-switch">
          Don't have an account? <a href="?mode=signup">Sign up here</a>
        </div>
      </div>
    </form>
  <?php endif; ?>
  </div>
</div>

<script>
function filterDoctors() {
    const deptSelect = document.getElementById('department-select');
    const doctorSelect = document.getElementById('doctor-select');
    const selectedDept = deptSelect.value;
    
    Array.from(doctorSelect.options).forEach(option => {
        if (option.value === '') return; // Skip the placeholder option
        const deptId = option.getAttribute('data-dept');
        option.style.display = deptId === selectedDept ? '' : 'none';
    });

    doctorSelect.value = '';
}

document.addEventListener('DOMContentLoaded', () => {
    filterDoctors();
    
    // Add smooth fade-in animation to the glass card
    const glassCard = document.querySelector('.glass-card');
    if (glassCard) {
        glassCard.style.opacity = '0';
        glassCard.style.transform = 'translateY(20px)';
        glassCard.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
        
        setTimeout(() => {
            glassCard.style.opacity = '1';
            glassCard.style.transform = 'translateY(0)';
        }, 100);
    }
});</script>

<?php require_once 'includes/footer.php'; ?>
