<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!-- ✅ شريط التنقل -->
<style>
  .navbar {
    background-color: #6a1b9a;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: 'Cairo', sans-serif;
  }

  .navbar .logo {
    font-size: 22px;
    font-weight: 700;
    color:rgb(219, 219, 219);
    text-decoration: none;
  }

  .navbar .nav-links {
    display: flex;
    direction: ltr;
    gap: 20px;
    align-items: center;
  }

  .navbar .nav-links a {
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
    color:rgb(255, 255, 255);
    transition: 0.3s;
  }

  .navbar .nav-links a:hover {
    color:rgb(255, 255, 255);
  }

  @media (max-width: 600px) {
    .navbar {
      flex-direction: column;
      gap: 10px;
      text-align: center;
    }
    .navbar .nav-links {
      flex-direction: column;
      gap: 10px;
    }
  }
</style>

<div class="navbar">
  <a class="logo" href="home.php">  خطتي الدراسية في السفر</a>
  <div class="nav-links">
    <a href="home.php">الرئيسية</a>
    <a href="create_plan.php">إنشاء خطة</a>
    <a href="my_plans.php">خططي</a>
    <a href="edit_profile.php">الحساب</a>
    <a href="logout.php" style="color:#e53935;">تسجيل الخروج</a>
  </div>
</div>
