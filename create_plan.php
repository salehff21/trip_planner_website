<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إنشاء خطة جديدة</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/style_create_plane.css">
  
</head>
<body>
<!--  Header -->
<?php include 'includes/header.php'?>

<div class="form-container">
  <h2>📝 إنشاء خطة سفر جديدة</h2>
  <form action="generate_plan.php" method="POST">
    <label for="city">المدينة</label>
    <input type="text" id="city" name="city" required>

    <label for="days">عدد الأيام</label>
    <input type="number" id="days" name="days" min="1" max="30" required>

    <label>اختر اهتماماتك</label>
    <div class="checkbox-group">
      <label><input type="checkbox" name="interests[]" value="طبيعة"> طبيعة</label>
      <label><input type="checkbox" name="interests[]" value="تسوق"> تسوق</label>
      <label><input type="checkbox" name="interests[]" value="متاحف"> متاحف</label>
      <label><input type="checkbox" name="interests[]" value="أكل"> أكل</label>
    </div>

    <button type="submit" class="submit-btn">توليد الخطة</button>
  </form>
</div>

</body>
</html>
