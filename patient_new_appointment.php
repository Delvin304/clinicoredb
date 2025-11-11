<?php
require_once '../includes/config.php';

// Only allow logged-in patients
if (!isset($_SESSION['patient_id'])) {
    header('Location: patient_auth.php?mode=login');
    exit;
}
$patient_id = $_SESSION['patient_id'];

// Fetch patient info (if needed for display)
$stmt = $pdo->prepare('SELECT * FROM patients WHERE id = ?');
$stmt->execute([$patient_id]);
$patient = $stmt->fetch();

// Fetch departments and doctors
$departments = $pdo->query('SELECT id, name FROM departments ORDER BY name')->fetchAll();
$doctors = $pdo->query('SELECT id, full_name, department_id FROM doctors ORDER BY full_name')->fetchAll();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $department_id = $_POST['department_id'] ?? '';
    $doctor_id = $_POST['doctor_id'] ?? '';
    $slot_id = $_POST['slot_id'] ?? '';
    if (!$department_id || !$doctor_id || !$slot_id) {
        $error = 'Please select department, doctor, and slot.';
    } else {
        // Fetch slot time
        $slotStmt = $pdo->prepare('SELECT slot_time FROM appointment_slots WHERE id = ? AND doctor_id = ? AND is_booked = 0');
        $slotStmt->execute([$slot_id, $doctor_id]);
        $slot_time = $slotStmt->fetchColumn();
        if ($slot_time) {
            // Book slot
            $pdo->beginTransaction();
            $updStmt = $pdo->prepare('UPDATE appointment_slots SET is_booked = 1, booked_by = ? WHERE id = ? AND doctor_id = ? AND is_booked = 0');
            $updStmt->execute([$patient_id, $slot_id, $doctor_id]);
            // Calculate token number: count existing appointments for this doctor and date
            $dateOnly = date('Y-m-d', strtotime($slot_time));
            $tokenStmt = $pdo->prepare('SELECT COALESCE(MAX(token_number),0)+1 FROM appointments WHERE doctor_id = ? AND DATE(appointment_time) = ?');
            $tokenStmt->execute([$doctor_id, $dateOnly]);
            $token_number = $tokenStmt->fetchColumn();
            $insStmt = $pdo->prepare('INSERT INTO appointments (patient_id, doctor_id, department_id, appointment_time, status, token_number) VALUES (?, ?, ?, ?, ?, ?)');
            $insStmt->execute([$patient_id, $doctor_id, $department_id, $slot_time, 'scheduled', $token_number]);
            $pdo->commit();
            header('Location: patient_dashboard.php');
            exit;
        } else {
            $error = 'Selected slot is not available.';
        }
    }
}
require_once '../website/includes/header.php';

?>
<style>
body, html {
  height: 100%;
  margin: 0;
  padding: 0;
}
.container {
  min-height: calc(100vh - 120px); /* adjust if header/footer height changes */
}
.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background: #f8f9fa;
  text-align: center;
  padding: 12px 0;
  box-shadow: 0 -2px 8px rgba(0,0,0,0.04);
}
</style>
<div class="container mt-5">
  <h2>Book New Appointment</h2>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>
  <form method="post" id="new-appointment-form">
    <div class="mb-3">
      <label class="form-label">Department</label>
      <select name="department_id" id="department-select" class="form-select" required>
        <option value="">Choose department…</option>
        <?php foreach ($departments as $dept): ?>
          <option value="<?php echo $dept['id']; ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Doctor</label>
      <select name="doctor_id" id="doctor-select" class="form-select" required>
        <option value="">Choose doctor…</option>
        <?php foreach ($doctors as $doc): ?>
          <option value="<?php echo $doc['id']; ?>" data-dept="<?php echo $doc['department_id']; ?>"><?php echo htmlspecialchars($doc['full_name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Available Slots</label>
      <select name="slot_id" id="slot-select" class="form-select" required>
        <option value="">Select a doctor first…</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Book Appointment</button>
    <a href="patient_dashboard.php" class="btn btn-secondary ms-2">Cancel</a>
  </form>
</div>
<script>
// Filter doctors by department
const deptSelect = document.getElementById('department-select');
const docSelect = document.getElementById('doctor-select');
const slotSelect = document.getElementById('slot-select');

deptSelect.addEventListener('change', function() {
  const deptId = this.value;
  for (const option of docSelect.options) {
    if (!option.value) continue;
    option.style.display = option.getAttribute('data-dept') === deptId ? '' : 'none';
  }
  docSelect.value = '';
  slotSelect.innerHTML = '<option value="">Select a doctor first…</option>';
});

docSelect.addEventListener('change', function() {
  const doctorId = this.value;
  slotSelect.innerHTML = '<option value="">Loading…</option>';
  fetch(`../website/appointment_book.php?doctor_id=${doctorId}`)
    .then(res => res.json())
    .then(slots => {
      let html = '<option value="">Choose slot…</option>';
      for (const slot of slots) {
        html += `<option value="${slot.id}">${slot.slot_time}</option>`;
      }
      slotSelect.innerHTML = html;
    });
});
</script>
<?php require_once '../website/includes/footer.php'; ?>
