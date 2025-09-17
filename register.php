<?php
// معالجة التسجيل عند الإرسال
require 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name     = trim($_POST['name']);
  $email    = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
  try {
    $stmt->execute([$name, $email, $password]);
    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['user_name'] = $name;
    header("Location: login.php");
    exit;
  } catch (PDOException $e) {
    $error = "البريد الإلكتروني مستخدم مسبقًا.";
  }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تسجيل مستخدم جديد</title>
  <link rel="stylesheet" href="CSS/styleRegister.css">
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
  <h2>تسجيل مستخدم جديد</h2>
  <?php if (isset($error)): ?>
    <div class="error-msg"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="form-group">
      <label>الاسم الكامل</label>
      <input type="text" name="name" required>
    </div>
    <div class="form-group">
      <label>البريد الإلكتروني</label>
      <input type="email" name="email" required>
    </div>
    <div class="form-group">
      <label>كلمة المرور</label>
      <input type="password" name="password" required>
    </div>
    <button type="submit" class="submit-btn">إنشاء الحساب</button>
  </form>
</div>

</body>
</html>
