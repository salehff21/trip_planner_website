 <?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$plan_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// جلب الخطة من قاعدة البيانات
$stmt = $pdo->prepare("SELECT * FROM plans WHERE id = ? AND user_id = ?");
$stmt->execute([$plan_id, $_SESSION['user_id']]);
$plan = $stmt->fetch();

// إذا لم يتم العثور على الخطة
if (!$plan) {
  echo "❌ الخطة غير موجودة أو لا تملك صلاحية تعديلها.";
  exit;
}

// عند حفظ التعديلات
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $city = trim($_POST['city']);
  $days_count = intval($_POST['days_count']);
  $preferences = trim($_POST['preferences']);

  // تحويل التفضيلات إلى مصفوفة ثم ترميزها إلى JSON
  $preferencesArray = array_map('trim', explode('،', $preferences));
  $preferencesJson = json_encode($preferencesArray, JSON_UNESCAPED_UNICODE);

  $stmt = $pdo->prepare("UPDATE plans SET city = ?, days_count = ?, preferences = ? WHERE id = ? AND user_id = ?");
  $stmt->execute([$city, $days_count, $preferencesJson, $plan_id, $_SESSION['user_id']]);

  $success = "✅ تم تحديث الخطة بنجاح!";
}

// تجهيز البيانات للعرض في الفورم
$city = isset($plan['city']) ? htmlspecialchars($plan['city']) : '';
$days_count = isset($plan['days_count']) ? htmlspecialchars($plan['days_count']) : 1;

$preferencesArray = json_decode($plan['preferences'], true);
$preferences = is_array($preferencesArray) ? implode('، ', $preferencesArray) : htmlspecialchars($plan['preferences']);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تعديل الخطة</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="CSS/style_edit_plan.css">
  <link rel="stylesheet" href="CSS/style.css">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background-color: #f5f6fa;
      margin: 0;
      padding: 0;
      direction: rtl;
    }

    .form-container {
      max-width: 550px;
      margin: 80px auto;
      background: white;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    h2 {
      text-align: center;
      color: #6a1b9a;
      margin-bottom: 30px;
    }

    .message {
      background-color: #e0f7e9;
      color: #388e3c;
      padding: 12px;
      border-radius: 8px;
      text-align: center;
      margin-bottom: 25px;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group i {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #888;
    }

    input, textarea {
      width: 100%;
      padding: 12px 40px 12px 12px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 15px;
      background-color: #fefefe;
    }

    textarea {
      resize: vertical;
    }

    input:focus, textarea:focus {
      border-color: #6a1b9a;
      outline: none;
    }

    label {
      margin-bottom: 5px;
      display: block;
      font-weight: 500;
      color: #444;
    }

    .submit-btn {
      width: 100%;
      background-color: #6a1b9a;
      color: white;
      padding: 14px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    .submit-btn:hover {
      background-color: #4a148c;
    }
  </style>
</head>
<body>
<?php include 'includes/header.php'?>
<div class="form-container">
  <h2><i class="fas fa-pen-to-square"></i> تعديل الخطة</h2>

  <?php if (isset($success)): ?>
    <div class="message"><?= $success ?></div>
  <?php endif; ?>

  <form method="POST">
    <label>المدينة</label>
    <div class="input-group">
      <i class="fas fa-city"></i>
      <input type="text" name="city" value="<?= $city ?>" required>
    </div>

    <label>عدد الأيام</label>
    <div class="input-group">
      <i class="fas fa-calendar-day"></i>
      <input type="number" name="days_count" value="<?= $days_count ?>" min="1" required>
    </div>

    <label>الاهتمامات</label>
    <div class="input-group">
      <i class="fas fa-heart"></i>
      <textarea name="preferences" rows="4" placeholder="مثلاً: طبيعة، تسوق، متاحف"><?= $preferences ?></textarea>
    </div>

    <button type="submit" class="submit-btn"><i class="fas fa-save"></i> تحديث الخطة</button>
  </form>
</div>

</body>
</html>
