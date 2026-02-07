<?php session_start(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VillageBook</title>

    <link rel="stylesheet" href="style.css">

    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-app">


<nav class="topbar">
    <div class="topbar-inner">
        <a href="index.php" class="brand">
            <span class="brand-dot"></span>
            <span class="brand-name">VillageBook</span>
        </a>

        <div class="menu">
            <a href="index.php" class="active">หน้าแรก</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="booking.php">จองสถานที่</a>
                <a href="my_bookings.php">การจองของฉัน</a>
                <a href="contact.php">ติดต่อเรา</a>
            <?php else: ?>
                <a href="register.php">ลงทะเบียน</a>
                <a href="login.php">เข้าสู่ระบบ</a>
            <?php endif; ?>
        </div>

        <div class="topbar-right">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php" class="user-pill">
                <div class="user-avatar">👤</div>
                <div class="user-name"><?= htmlspecialchars($_SESSION['username'] ?? 'ผู้ใช้งาน') ?></div>
            </a>

                <a href="logout.php" class="btn-sm danger">ออกจากระบบ</a>
            <?php else: ?>
                <a href="login.php" class="btn-sm primary">เข้าสู่ระบบ</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="page">

    <section class="hero2">
        <div class="hero2-left">
            <div class="badge">
                <span class="badge-dot"></span>
                ระบบจองสถานที่ส่วนกลางหมู่บ้าน
            </div>

            <h1 class="hero2-title">
                ยกระดับความเป็นอยู่ที่ดี<br>
                ใน <span class="hero2-highlight">หมู่บ้านของเรา</span>
            </h1>

            <p class="hero2-desc">
                จองสถานที่ส่วนกลางได้ง่าย ๆ ตรวจสอบเวลาว่าง และจัดการการจองของคุณได้ตลอด 24 ชั่วโมง
            </p>

            <div class="hero2-actions">
                <a href="booking.php" class="btn-lg primary">เริ่มจองสถานที่</a>
                <a href="my_bookings.php" class="btn-lg dark">ดูการจองของฉัน</a>
            </div>

            <div class="search-card">
                <div class="search-title">🔎 ค้นหาสถานที่</div>
                <form class="search-form" action="booking.php" method="GET">
                    <input type="text" name="q" placeholder="พิมพ์ชื่อสถานที่ เช่น ศาลา, สนามกีฬา...">
                    <button type="submit">ค้นหา</button>
                </form>
                <div class="search-hint">* ระบบจะพาไปหน้าจองและกรองสถานที่ให้</div>
            </div>
        </div>

        <div class="hero2-right">
            <div class="glass-card">
                <div class="glass-title">📌 สถานะระบบ</div>

                <div class="stat-grid">
                    <div class="stat">
                        <div class="stat-label">สถานะ</div>
                        <div class="stat-value ok">ออนไลน์</div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">เปิดบริการ</div>
                        <div class="stat-value">24 ชม.</div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">รองรับ</div>
                        <div class="stat-value">ลูกบ้าน</div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">ระบบ</div>
                        <div class="stat-value">จองทันที</div>
                    </div>
                </div>

                <div class="notice">
                    <div class="notice-title">📣 ประกาศจากส่วนกลาง</div>
                    <div class="notice-text">
                        เพิ่มสถานที่ใหม่: <b>สระว่ายน้ำ</b> และ <b>ห้องฟิตเนส</b><br>
                        สามารถเช็คตารางว่างได้ที่หน้าจอง
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-head">
            <h2>สถานที่ยอดนิยม</h2>
            <p>เลือกสถานที่ที่ต้องการ แล้วเริ่มจองได้ทันที</p>
        </div>

        <div class="place-grid">
            <a href="booking.php" class="place-card">
                <div class="place-icon">🏢</div>
                <div class="place-name">ศาลาและที่ประชุม</div>
                <div class="place-desc">เหมาะสำหรับงานจัดเลี้ยง ประชุมชุมชน และกิจกรรมต่าง ๆ</div>
                <div class="place-cta">จองเลย →</div>
            </a>

            <a href="booking.php" class="place-card">
                <div class="place-icon">🏊</div>
                <div class="place-name">สระว่ายน้ำและฟิตเนส</div>
                <div class="place-desc">ดูแลสุขภาพได้ทุกวัน พร้อมจำกัดจำนวนผู้เข้าใช้</div>
                <div class="place-cta">จองเลย →</div>
            </a>

            <a href="booking.php" class="place-card">
                <div class="place-icon">⚽</div>
                <div class="place-name">สนามกีฬา</div>
                <div class="place-desc">รองรับฟุตซอล บาสเกตบอล แบดมินตัน สำหรับลูกบ้านทุกท่าน</div>
                <div class="place-cta">จองเลย →</div>
            </a>
        </div>
    </section>

    <section class="section">
        <div class="callout">
            <div>
                <h3>พร้อมเริ่มจองแล้วใช่ไหม?</h3>
                <p>เช็คตารางว่างและยืนยันการจองได้ภายในไม่กี่วินาที</p>
            </div>
            <a href="booking.php" class="btn-lg primary">ไปหน้าจอง</a>
        </div>
    </section>

    <footer class="footer2">
        <div>&copy; 2025 Village Facility Booking System</div>
        <div class="footer-links">
            <a href="contact.php">ติดต่อเรา</a>
            <span class="dot">•</span>
            <a href="booking.php">จองสถานที่</a>
        </div>
    </footer>

</main>

</body>
</html>
