<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

require 'includes/db.php';

// جلب بيانات المستخدم
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $newPassword = $_POST['password'];

  // التحقق من كلمة المرور الجديدة
  if (!empty($newPassword)) {
    $password = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
    $stmt->execute([$name, $email, $password, $_SESSION['user_id']]);
  } else {
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $_SESSION['user_id']]);
  }

  $_SESSION['user_name'] = $name;
  $success = "تم تحديث البيانات بنجاح.";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تعديل الحساب</title>
  <link rel="stylesheet" href="CSS/style_edit_profile.css">
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  
</head>
<body>

<!--  Header -->
<?php include 'includes/header.php'?>

<div class="form-container">
  <h2><i class="fas fa-user-cog"></i> تعديل بيانات الحساب</h2>

  <?php if (isset($success)): ?>
    <div class="message"><?= $success ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="input-group">
      <label>الاسم الكامل</label>
      <div class="input-icon">
        <i class="fas fa-user"></i>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
      </div>
    </div>

    <div class="input-group">
      <label>البريد الإلكتروني</label>
      <div class="input-icon">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
      </div>
    </div>

    <div class="input-group">
      <label>كلمة المرور الجديدة (اختياري)</label>
      <div class="input-icon">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="اتركها فارغة إن لم ترغب بتغييرها">
      </div>
    </div>

    <button type="submit" class="submit-btn">تحديث الحساب</button>
  </form>
</div>


</body>
</html>
