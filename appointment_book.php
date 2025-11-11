<?php
// appointment_book.php
require_once __DIR__ . '/../includes/config.php';
// Accept both user_id (staff/admin) and patient_id (patient)
if (!isset($_SESSION['user_id']) && !isset($_SESSION['patient_id'])) {
  header('Location: login.php');
  exit;
}

// Fetch doctors
$doctors = $pdo->query('SELECT id, full_name FROM doctors ORDER BY full_name')->fetchAll();
$selectedDoctor = '';
if (isset($_SESSION['patient_id'])) {
  // Fetch patient's doctor from DB
  $stmt = $pdo->prepare('SELECT doctor_id FROM patients WHERE id = ?');
  $stmt->execute([$_SESSION['patient_id']]);
  $selectedDoctor = $stmt->fetchColumn();
}

// Handle booking
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $doctor_id = $_POST['doctor_id'] ?? '';
  $slot_id   = $_POST['slot_id'] ?? '';
  $booked_by = $_SESSION['patient_id'] ?? $_SESSION['user_id'] ?? null;
  if ($doctor_id && $slot_id) {
    // Book the slot if not already booked
    $stmt = $pdo->prepare('UPDATE appointment_slots SET is_booked=1, booked_by=? WHERE id=? AND doctor_id=? AND is_booked=0');
    $stmt->execute([$booked_by, $slot_id, $doctor_id]);
    if ($stmt->rowCount()) {
      // Fetch slot time
      $slotStmt = $pdo->prepare('SELECT slot_time FROM appointment_slots WHERE id = ?');
      $slotStmt->execute([$slot_id]);
      $slot_time = $slotStmt->fetchColumn();
      // Fetch patient info
      $patient_id = $_SESSION['patient_id'] ?? null;
      $department_id = null;
      if ($patient_id) {
        $patStmt = $pdo->prepare('SELECT department_id FROM patients WHERE id = ?');
        $patStmt->execute([$patient_id]);
        $department_id = $patStmt->fetchColumn();
      }
      // Insert into appointments table
      // Calculate token number: count existing appointments for this doctor and date
      $dateOnly = date('Y-m-d', strtotime($slot_time));
      $tokenStmt = $pdo->prepare('SELECT COALESCE(MAX(token_number),0)+1 FROM appointments WHERE doctor_id = ? AND DATE(appointment_time) = ?');
      $tokenStmt->execute([$doctor_id, $dateOnly]);
      $token_number = $tokenStmt->fetchColumn();
      $insStmt = $pdo->prepare('INSERT INTO appointments (patient_id, doctor_id, department_id, appointment_time, status, token_number) VALUES (?, ?, ?, ?, ?, ?)');
      $insStmt->execute([
        $patient_id,
        $doctor_id,
        $department_id,
        $slot_time,
        'scheduled',
        $token_number
      ]);
      $message = 'Appointment booked successfully!';
    } else {
      $message = 'Slot already booked or invalid.';
    }
  } else {
    $message = 'Please select a doctor and slot.';
  }
}

// Fetch available slots for selected doctor (AJAX)
if (isset($_GET['doctor_id'])) {
  $doctor_id = (int)$_GET['doctor_id'];
  $slots = $pdo->prepare('SELECT id, slot_time FROM appointment_slots WHERE doctor_id=? AND is_booked=0 AND slot_time > NOW() ORDER BY slot_time');
  $slots->execute([$doctor_id]);
  echo json_encode($slots->fetchAll());
  exit;
}

include 'includes/header.php';
?>
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Book Appointment</h2>
    <a href="index.php" class="btn btn-secondary">Back to Home</a>
  </div>
  <?php if ($message): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
  <?php endif; ?>
  <form method="post" id="appointment-form">
    <div class="mb-3">
      <label class="form-label">Doctor</label>
      <select name="doctor_id" id="doctor-select" class="form-select" required <?php echo $selectedDoctor ? 'readonly disabled' : ''; ?>>
        <option value="">Choose doctor…</option>
        <?php foreach ($doctors as $doc): ?>
          <option value="<?php echo $doc['id']; ?>" <?php if ($selectedDoctor && $doc['id'] == $selectedDoctor) echo 'selected'; ?>><?php echo htmlspecialchars($doc['full_name']); ?></option>
        <?php endforeach; ?>
      </select>
      <?php if ($selectedDoctor): ?>
        <input type="hidden" name="doctor_id" value="<?php echo $selectedDoctor; ?>" />
      <?php endif; ?>
    </div>
    <div class="mb-3">
      <label class="form-label">Available Slots</label>
      <select name="slot_id" id="slot-select" class="form-select" required>
        <option value="">Select a doctor first…</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Book</button>
  </form>
</div>
<script>
var doctorSelect = document.getElementById('doctor-select');
var slotSelect = document.getElementById('slot-select');
function loadSlotsForDoctor(docId) {
  slotSelect.innerHTML = '<option>Loading…</option>';
  if (!docId) {
    slotSelect.innerHTML = '<option value="">Select a doctor first…</option>';
    return;
  }
  fetch('appointment_book.php?doctor_id=' + docId)
    .then(res => res.json())
    .then(data => {
      if (data.length === 0) {
        slotSelect.innerHTML = '<option value="">No slots available</option>';
      } else {
        slotSelect.innerHTML = '';
        data.forEach(slot => {
          var dt = new Date(slot.slot_time);
          var opt = document.createElement('option');
          opt.value = slot.id;
          opt.textContent = dt.toLocaleString();
          slotSelect.appendChild(opt);
        });
      }
    });
}
doctorSelect.onchange = function() {
  loadSlotsForDoctor(this.value);
};
// Auto-load slots if doctor is pre-selected
if (doctorSelect.value) {
  loadSlotsForDoctor(doctorSelect.value);
}
</script>

<style>
  .fixed-footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    z-index: 100;
  }
</style>
<?php include 'includes/footer.php'; ?>
<script>
  // Add the fixed-footer class to the shared footer
  document.addEventListener('DOMContentLoaded', function() {
    var footer = document.querySelector('footer');
    if (footer) {
      footer.classList.add('fixed-footer');
    }
  });
</script>
