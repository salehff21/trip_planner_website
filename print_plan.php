<?php
session_start();
require 'includes/db.php';

if (!isset($_GET['plan_id']) || !is_numeric($_GET['plan_id'])) {
    die("معرف الخطة غير صالح.");
}

$plan_id = intval($_GET['plan_id']);

// جلب تفاصيل الخطة الأساسية
$stmt = $pdo->prepare("SELECT * FROM plans WHERE id = ?");
$stmt->execute([$plan_id]);
$plan = $stmt->fetch();

if (!$plan) {
    die("الخطة غير موجودة.");
}

// جلب الأيام المرتبطة بالخطة
$days_stmt = $pdo->prepare("SELECT * FROM plan_days WHERE plan_id = ? ORDER BY day_number");
$days_stmt->execute([$plan_id]);
$plan_days = $days_stmt->fetchAll();

// جلب الأنشطة لكل يوم
$activities_by_day = [];
foreach ($plan_days as $day) {
    $day_id = $day['id'];
    $activities_stmt = $pdo->prepare("SELECT * FROM activities WHERE plan_day_id = ? ORDER BY suggested_time");
    $activities_stmt->execute([$day_id]);
    $activities_by_day[$day['day_number']] = $activities_stmt->fetchAll();
}

function getIcon($category) {
    return match($category) {
        'طبيعة' => '<i class="fas fa-tree"></i>',
        'تسوق' => '<i class="fas fa-shopping-bag"></i>',
        'متاحف' => '<i class="fas fa-landmark"></i>',
        'أكل' => '<i class="fas fa-utensils"></i>',
        'تاريخ' => '<i class="fas fa-monument"></i>',
        default => '<i class="fas fa-map-marker-alt"></i>',
    };
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>طباعة الخطة</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="CSS/style_print_plane.css">
  <link rel="stylesheet" href="CSS/style.css">
  <?php include 'includes/header.php'?>
</head>
<body>

<div class="report">
  <h2><i class="fas fa-map-marked-alt"></i> خطتي السياحية</h2>

  <div class="info-row">
    <div class="info-box"><i class="fas fa-city"></i> المدينة: <?= htmlspecialchars($plan['city']) ?></div>
    <div class="info-box"><i class="fas fa-calendar-day"></i> عدد الأيام: <?= htmlspecialchars($plan['days_count']) ?> يوم</div>
    <div class="info-box"><i class="fas fa-heart"></i> الاهتمامات: <?= htmlspecialchars(implode('، ', json_decode($plan['preferences'], true))) ?></div>
    <div class="info-box"><i class="fas fa-clock"></i> تاريخ الإنشاء: <?= date('Y-m-d', strtotime($plan['created_at'])) ?></div>
  </div>

  <div class="section">
    <strong>📍 خطتك إلى <?= htmlspecialchars($plan['city']) ?> - لمدة <?= htmlspecialchars($plan['days_count']) ?> أيام</strong>
  </div>

  <?php foreach ($activities_by_day as $day_number => $activities): ?>
    <div class="day-title">اليوم <?= $day_number ?>:</div>
    <?php foreach ($activities as $activity): ?>
      <div class="activity">
        • <?= getIcon($activity['category']) ?> <?= htmlspecialchars($activity['title']) ?> (<?= htmlspecialchars($activity['category']) ?>) - الساعة <?= htmlspecialchars($activity['suggested_time']) ?>
      </div>
    <?php endforeach; ?>
  <?php endforeach; ?>
</div>

<script>
  window.print();
</script>
</body>
</html>
