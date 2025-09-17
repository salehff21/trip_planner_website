<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

require 'includes/db.php';

// جلب خطط المستخدم
$stmt = $pdo->prepare("SELECT * FROM plans WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$plans = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>خططي السابقة</title>
  <link rel="stylesheet" href="CSS/style_my_plans.css">
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

 
</head>
<body>
<?php include 'includes/header.php'?>
<div class="plans-container">
  <h2><i class="fas fa-clipboard-list"></i> خططي السابقة</h2>

  <?php if (count($plans) === 0): ?>
    <p style="text-align:center;">ليس لديك خطط محفوظة حتى الآن.</p>
  <?php else: ?>
    <?php foreach ($plans as $plan): ?>
      <div class="plan-card">
        <div class="plan-info">
          <i class="fas fa-city"></i> <strong><?= htmlspecialchars($plan['city']) ?></strong><br>
          <i class="fas fa-calendar-alt"></i> <?= $plan['days_count'] ?> يوم<br>
          <i class="fas fa-clock"></i> تم إنشاؤها في: <?= date("Y-m-d", strtotime($plan['created_at'])) ?>
        </div>

        <div class="plan-actions">
          <a href="view_plan.php?plan_id=<?= $plan['id'] ?>" class="btn primary">
            <i class="fas fa-eye"></i> عرض الخطة
          </a>
          <a href="edit_plan.php?id=<?= $plan['id'] ?>" class="btn warning">
            <i class="fas fa-edit"></i> تعديل
          </a>
          <a href="print_plan.php?plan_id=<?= $plan['id'] ?>" class="btn print" target="_blank">
            <i class="fas fa-print"></i> طباعة
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>


</body>
</html>
<style> 


.plan-actions .btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: bold;
  text-decoration: none;
  color: #fff;
  transition: 0.3s ease;
}

.btn i {
  font-size: 15px;
}

.btn.primary {
  background-color: #2196f3;
}
.btn.primary:hover {
  background-color: #1976d2;
}

.btn.warning {
  background-color: #ff9800;
}
.btn.warning:hover {
  background-color: #f57c00;
}

.btn.print {
  background-color: #4caf50;
}
.btn.print:hover {
  background-color: #388e3c;
}

@media (max-width: 600px) {
  .plan-actions {
    flex-direction: column;
  }
}
</style>