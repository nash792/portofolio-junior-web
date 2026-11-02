<?php

declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../templates/header.php';
?>

<style>
    .user-page {
        min-height: 75vh;
        padding: 50px 20px;
        border-radius: 18px;
        background: linear-gradient(135deg, #667eea, #764ba2, #f093fb);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .user-card {
        width: 100%;
        max-width: 650px;
        padding: 45px 30px;
        text-align: center;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 25px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .user-card:hover {
        transform: translateY(-8px);
    }

    .user-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 45px;
        color: white;
        background: linear-gradient(135deg, #667eea, #764ba2);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .user-card h2 {
        font-size: 32px;
        font-weight: 800;
        color: #4f46e5;
        margin-bottom: 12px;
    }

    .user-card p {
        color: #64748b;
        font-size: 16px;
        margin-bottom: 25px;
    }

    .user-badge {
        display: inline-block;
        padding: 10px 22px;
        color: white;
        background: linear-gradient(90deg, #f59e0b, #ef4444);
        border-radius: 30px;
        font-weight: bold;
        font-size: 14px;
    }

    .user-decoration {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 30px;
    }

    .color-dot {
        width: 13px;
        height: 13px;
        border-radius: 50%;
    }

    @media (max-width: 576px) {
        .user-card h2 {
            font-size: 25px;
        }

        .user-card {
            padding: 35px 20px;
        }
    }
</style>

<div class="user-page">
    <div class="user-card">

        <div class="user-icon">
            👨‍💻
        </div>

        <h2>Halo, <?php echo e($_SESSION['username']); ?>! 👋</h2>

        <p>
            Selamat datang di halaman user.
            Senang melihat kamu kembali!
        </p>

        <span class="user-badge">
            ✨ USER DASHBOARD
        </span>

        <div class="user-decoration">
            <span class="color-dot" style="background:#667eea"></span>
            <span class="color-dot" style="background:#764ba2"></span>
            <span class="color-dot" style="background:#f093fb"></span>
            <span class="color-dot" style="background:#f59e0b"></span>
            <span class="color-dot" style="background:#10b981"></span>
        </div>

    </div>
</div>

<?php
require __DIR__ . '/../templates/footer.php';
?>