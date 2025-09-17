<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

require 'includes/db.php';

$user_id = $_SESSION['user_id'];
$city = $_POST['city'];
$days_count = (int)$_POST['days'];
$interests = $_POST['interests'] ?? [];

 
$preferences_json = json_encode($interests);
$stmt = $pdo->prepare("INSERT INTO plans (user_id, city, days_count, preferences) VALUES (?, ?, ?, ?)");
$stmt->execute([$user_id, $city, $days_count, $preferences_json]);
$plan_id = $pdo->lastInsertId();

$activity_bank = [
  "طبيعة" => [
    "زيارة حديقة عامة", 
    "نزهة بجانب البحيرة", 
    "جولة جبلية",
    "زيارة شلال", 
    "الاسترخاء في منتزه", 
    "مشاهدة غروب الشمس"
  ],
  "تسوق" => [
    "زيارة السوق الشعبي", 
    "التسوق في مول", 
    "شراء هدايا", 
    "زيارة محلات التحف", 
    "سوق المنتجات المحلية", 
    "تجربة المفاوضة في الأسواق"
  ],
  "متاحف" => [
    "متحف المدينة", 
    "معرض فني", 
    "متحف تاريخي", 
    "زيارة متحف العلوم", 
    "متحف الثقافة المحلية", 
    "متحف الأطفال"
  ],
  "أكل" => [
    "مطعم محلي", 
    "تجربة أطباق شعبية", 
    "كافيه مميز", 
    "مطعم فاخر", 
    "وجبة سريعة تقليدية", 
    "زيارة سوق الطعام"
  ],
  "تاريخ" => [
    "زيارة قلعة أثرية", 
    "جولة في حي قديم", 
    "مسجد أو كنيسة تاريخية", 
    "بوابة المدينة القديمة", 
    "موقع أثري مفتوح"
  ]
];


// توليد الأيام والأنشطة
for ($day = 1; $day <= $days_count; $day++) {
  $stmt = $pdo->prepare("INSERT INTO plan_days (plan_id, day_number) VALUES (?, ?)");
  $stmt->execute([$plan_id, $day]);
  $day_id = $pdo->lastInsertId();

  foreach ($interests as $interest) {
    $options = $activity_bank[$interest];
    shuffle($options);
    $title = $options[0];
    $time = rand(9, 16) . ":00";

    $stmt = $pdo->prepare("INSERT INTO activities (plan_day_id, title, category, suggested_time) VALUES (?, ?, ?, ?)");
    $stmt->execute([$day_id, $title, $interest, $time]);
  }
}

// بعد التوليد: الانتقال إلى صفحة عرض الخطة
header("Location: view_plan.php?plan_id=$plan_id");
exit;
?>
