<?php
require_once '../includes/config.php';

// Only allow logged-in patients
if (!isset($_SESSION['patient_id'])) {
    header('Location: patient_auth.php?mode=login');
    exit;
}
$patient_id = $_SESSION['patient_id'];

// Fetch upcoming appointments for this patient
$sql = 'SELECT a.*, d.full_name AS doctor_name, dept.name AS department_name
        FROM appointments a
        JOIN doctors d ON a.doctor_id = d.id
        JOIN departments dept ON a.department_id = dept.id
        WHERE a.patient_id = ? AND a.appointment_time >= NOW()
        ORDER BY a.appointment_time ASC';
$stmt = $pdo->prepare($sql);
$stmt->execute([$patient_id]);
$appointments = $stmt->fetchAll();

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
<style>
body, html {
  height: 100%;
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', Arial, sans-serif;
  background: url('assets/img/pic9.jpg.jpg') no-repeat center center fixed;
  background-size: cover;
}
.dashboard-glass {
  background: rgba(255, 255, 255, 0.18);
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.3);
  max-width: 900px;
  margin: 60px auto;
  padding: 32px 28px 24px 28px;
  color: #222;
  position: relative;
}
.dashboard-glass h2 {
  text-align: center;
  margin-bottom: 24px;
  font-weight: 700;
  color: #222;
  letter-spacing: 1px;
  text-shadow: 2px 2px 8px rgba(0,0,0,0.08);
}
.dashboard-glass table {
  background: rgba(255,255,255,0.7);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.dashboard-glass th {
  background: linear-gradient(90deg, #0052cc 0%, #0074d9 100%);
  color: #fff;
  font-weight: 600;
}
.dashboard-glass td {
  color: #222;
}
.dashboard-glass .btn {
  border-radius: 8px;
  font-weight: 500;
  margin-right: 4px;
}
.dashboard-glass .btn-success {
  background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
  border: none;
}
.dashboard-glass .btn-secondary {
  background: linear-gradient(90deg, #bdc3c7 0%, #2c3e50 100%);
  border: none;
}
.dashboard-glass .btn-primary {
  background: linear-gradient(90deg, #0052cc 0%, #0074d9 100%);
  border: none;
}
.dashboard-glass .btn-warning {
  background: linear-gradient(90deg, #f7971e 0%, #ffd200 100%);
  border: none;
  color: #222;
}
.dashboard-glass .btn-danger {
  background: linear-gradient(90deg, #e53935 0%, #e35d5b 100%);
  border: none;
}
.dashboard-glass .alert {
  border-radius: 8px;
  margin-bottom: 18px;
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
@media (max-width: 1000px) {
  .dashboard-glass {
    max-width: 98vw;
    padding: 18px 8px 16px 8px;
  }
}
</style>
<a href="../public/logout.php" class="btn btn-outline-danger position-fixed" style="top:24px;right:32px;z-index:1000;">Logout</a>
<div class="dashboard-glass mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Your Upcoming Appointments</h2>
    <div class="d-flex align-items-center">
      <a href="index.php" class="btn btn-secondary me-2">Back to Home</a>
  <a href="patient_new_appointment.php" class="btn btn-success me-2">New Appointment</a>
    </div>
  </div>
  <?php if ($appointments): ?>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Date</th>
          <th>Time</th>
          <th>Doctor</th>
          <th>Department</th>
          <th>Token</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($appointments as $a): ?>
        <tr>
          <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($a['appointment_time']))); ?></td>
          <td><?php echo htmlspecialchars(date('H:i', strtotime($a['appointment_time']))); ?></td>
          <td><?php echo htmlspecialchars($a['doctor_name']); ?></td>
          <td><?php echo htmlspecialchars($a['department_name']); ?></td>
          <td><span class="badge bg-info text-dark"><?php echo $a['token_number'] ? htmlspecialchars($a['token_number']) : '-'; ?></span></td>
          <td><?php echo htmlspecialchars($a['status']); ?></td>
          <td>
            <a href="../public/appointment_edit.php?id=<?php echo $a['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
            <a href="../public/appointment_delete.php?id=<?php echo $a['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Cancel this appointment?');">Cancel</a>
            <a href="../public/appointment_edit.php?id=<?php echo $a['id']; ?>&reschedule=1" class="btn btn-sm btn-warning">Reschedule</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No upcoming appointments found.</p>
  <?php endif; ?>
</div>
<?php require_once '../website/includes/footer.php'; ?>
