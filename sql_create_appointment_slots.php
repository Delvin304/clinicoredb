<?php
// SQL for appointment slots table
// Run this in your MySQL client to create the slots table
/*
CREATE TABLE appointment_slots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  doctor_id INT NOT NULL,
  slot_time DATETIME NOT NULL,
  is_booked TINYINT(1) DEFAULT 0,
  booked_by INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (doctor_id) REFERENCES doctors(id),
  FOREIGN KEY (booked_by) REFERENCES users(id)
);
*/
?>
