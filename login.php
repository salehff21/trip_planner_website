<?php
require 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    header("Location: home.php");
    exit;
  } else {
    $error = "بيانات الدخول غير صحيحة.";
  }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تسجيل الدخول</title>
  <link rel="stylesheet" href="CSS/stylelogin.css">

<link rel="stylesheet" href="CSS/style.css">

  
</head>
<body>
<!--  Header -->
<header>
  <div class="logo">  خطتي السياحية في السفر</div>
  <nav>
    <a href="index.html">الرئيسية</a>
    <a href="register.php">تسجيل حساب جديد</a>
  </nav>
</header>

<div class="form-container">
  <h2>تسجيل الدخول</h2>
  <?php if (isset($error)): ?>
    <div class="error-msg"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="form-group">
      <label>البريد الإلكتروني</label>
      <input type="email" name="email" required>
    </div>
    <div class="form-group">
      <label>كلمة المرور</label>
      <input type="password" name="password" required>
    </div>
    <button type="submit" class="submit-btn">دخول</button>
  </form>

  <div class="register-link">
    لا تملك حسابًا؟ <a href="register.php">أنشئ حساب جديد</a>
  </div>
</div>

</body>
</html>
