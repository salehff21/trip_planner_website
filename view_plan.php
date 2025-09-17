 <?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
require 'includes/db.php';

$plan_id = $_GET['plan_id'] ?? null;
if (!$plan_id) {
  die("خطة غير موجودة.");
}

// جلب بيانات الخطة
$stmt = $pdo->prepare("SELECT * FROM plans WHERE id = ? AND user_id = ?");
$stmt->execute([$plan_id, $_SESSION['user_id']]);
$plan = $stmt->fetch();

if (!$plan) {
  die("الخطة غير موجودة أو لا تملك صلاحية الوصول.");
}

// جلب الأيام
$stmt = $pdo->prepare("SELECT * FROM plan_days WHERE plan_id = ? ORDER BY day_number");
$stmt->execute([$plan_id]);
$days = $stmt->fetchAll();

// جلب الأنشطة لكل يوم
$day_activities = [];
foreach ($days as $day) {
  $stmt = $pdo->prepare("SELECT * FROM activities WHERE plan_day_id = ?");
  $stmt->execute([$day['id']]);
  $day_activities[$day['day_number']] = $stmt->fetchAll();
}

// مصفوفة الصور لكل نوع
$category_images = [
  'جبلية'     => 'mountain.jpg',
  'بحيرة'     => 'beach.jpg',
    'متاحف'     => 'MM.jpg',
  'مطاعم'     => 'restaurant.jpg',
  'منتزهات'   => 'park.jpg',
  'تسوق'      => 'shopping.jpg',
  'ثقافية'    => 'culture.jpg',
  'عامة'      => 'public.jpg',
  'شلال'        => 'waterfull.jpg',
  'طبيعة'        => 'waterfull.jpg',
  'أخرى'      => 'default.jpg'
];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>عرض الخطة</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/style_view_plan.css">
  <style>
    .plan-container {
      max-width: 900px;
      margin: 60px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .plan-container h2 {
      color: #6a1b9a;
      text-align: center;
      margin-bottom: 30px;
    }

    .day-section {
      margin-bottom: 40px;
    }

    .day-section h3 {
      background-color: #6a1b9a;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
    }

    ul.activities {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .activity-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      background-color: #f4f1fb;
      border-radius: 10px;
      margin-top: 10px;
      position: relative;
      cursor: pointer;
    }

    .activity-img {
      width: 80px;
      height: 50px;
      border-radius: 8px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .activity-img:hover {
      transform: scale(1.05);
    }

    .activity-img.zoomed {
      position: fixed;
      top: 50%;
      left: 50%;
      width: 80%;
      height: auto;
      max-height: 80%;
      transform: translate(-50%, -50%) scale(1);
      z-index: 9999;
      border-radius: 12px;
      box-shadow: 0 0 30px rgba(0,0,0,0.6);
    }

    .activity-details {
      flex-grow: 1;
    }

    .label {
      color: #999;
      font-size: 13px;
    }
  </style>
</head>
<body>

<?php include 'includes/header.php' ?>

<div class="plan-container">
  <h2>خطتك إلى <?= htmlspecialchars($plan['city']) ?> - لمدة <?= $plan['days_count'] ?> يوم</h2>

  <?php foreach ($day_activities as $day => $activities): ?>
    <div class="day-section">
      <h3>اليوم <?= $day ?></h3>
      <ul class="activities">
        <?php foreach ($activities as $activity): ?>
          <?php
            // اختيار اسم الصورة حسب نوع النشاط
            $category = $activity['category'];
            $image_name = $category_images[$category] ?? 'default.jpg';
          ?>
          <li class="activity-item">
            <img src="image/categories/<?= $image_name ?>" alt="صورة النشاط" class="activity-img" onclick="zoomImage(this)">
            <div class="activity-details">
              <strong><?= htmlspecialchars($activity['title']) ?></strong><br>
              <span class="label"><?= $activity['category'] ?> - الساعة <?= $activity['suggested_time'] ?></span>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endforeach; ?>
</div>

<script>
  function zoomImage(img) {
    if (img.classList.contains('zoomed')) {
      img.classList.remove('zoomed');
    } else {
      document.querySelectorAll('.activity-img.zoomed').forEach(e => e.classList.remove('zoomed'));
      img.classList.add('zoomed');
    }
  }

  document.addEventListener('click', function(e) {
    if (!e.target.classList.contains('activity-img')) {
      document.querySelectorAll('.activity-img.zoomed').forEach(img => img.classList.remove('zoomed'));
    }
  });
</script>

</body>
</html>
