 <?php 
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
include 'includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>الصفحة الرئيسية</title>

  <!-- ✅ Google Font: Cairo Medium -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="CSS/style_home.css">

</head>

<body>

<div class="home-container">
  <h2>مرحبًا <?= htmlspecialchars($_SESSION['user_name']) ?> 👋</h2>
  <p>ماذا ترغب أن تفعل اليوم؟</p>

  <div class="home-buttons">

  <a href="create_plan.php">
    <i class="fas fa-plus-circle"></i> إنشاء خطة جديدة
  </a>

  <a href="my_plans.php">
    <i class="fas fa-folder-open"></i> عرض خططي السابقة
  </a>

  <a href="edit_profile.php">
    <i class="fas fa-user-cog"></i> تعديل الحساب
  </a>

  <a href="logout.php" class="logout">
    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
  </a>

</div>


</body>
</html>
