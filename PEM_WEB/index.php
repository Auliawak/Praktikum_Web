<?php
session_start();

// Cek apakah user sudah login
$is_logged_in = isset($_SESSION['username']);
$username = $is_logged_in ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Top up game online terpercaya dan terlengkap untuk semua game favorit Anda">
    <title>Lamurah Store - Top Up Game Online Terpercaya</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            color: white;
            overflow-x: hidden;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,106.7C1248,96,1344,96,1392,96L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.3;
            animation: wave 10s ease-in-out infinite;
        }

        @keyframes wave {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
        }

        .logo {
            font-size: 4rem;
            font-weight: bold;
            background: linear-gradient(45deg, #ff6b6b, #ffa500, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            animation: glow 2s ease-in-out infinite;
        }

        @keyframes glow {
            0%, 100% { text-shadow: 0 0 20px rgba(255, 107, 107, 0.5); }
            50% { text-shadow: 0 0 40px rgba(255, 165, 0, 0.8); }
        }

        .tagline {
            font-size: 1.5rem;
            margin-bottom: 30px;
            opacity: 0.9;
            animation: fadeInUp 1s ease-out;
        }

        .description {
            font-size: 1.1rem;
            margin-bottom: 40px;
            line-height: 1.6;
            opacity: 0.8;
            animation: fadeInUp 1.2s ease-out;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1.4s ease-out;
        }

        .btn {
            padding: 15px 40px;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            color: white;
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(255, 107, 107, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        /* Features Section */
        .features {
            padding: 80px 20px;
            background: rgba(0, 0, 0, 0.2);
        }

        .features h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease-out;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.15);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .feature-card p {
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Games Preview */
        .games-preview {
            padding: 80px 20px;
        }

        .games-preview h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
        }

        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .game-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .game-item:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .game-item h3 {
            font-size: 1.3rem;
            margin-top: 15px;
        }

        /* User Status Bar */
        .user-status {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            padding: 15px 25px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .logo {
                font-size: 3rem;
            }

            .tagline {
                font-size: 1.2rem;
            }

            .description {
                font-size: 1rem;
            }

            .cta-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
            }

            .features h2, .games-preview h2 {
                font-size: 2rem;
            }

            .user-status {
                top: 10px;
                right: 10px;
                padding: 10px 15px;
            }
        }

        /* Floating Animation */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body>
    <!-- User Status (jika sudah login) -->
    <?php if ($is_logged_in): ?>
    <div class="user-status">
        <div class="user-avatar"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
        <span><?php echo htmlspecialchars($username); ?></span>
    </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="logo floating">LAMURAH STORE</h1>
            <p class="tagline">Top Up Game Online Terpercaya</p>
            <p class="description">
                Platform top up game online terpercaya dengan proses yang cepat, aman, dan harga terjangkau. 
                Dapatkan diamond, UC, dan Genesis Crystal untuk game favoritmu dengan mudah!
            </p>
            <div class="cta-buttons">
                <?php if ($is_logged_in): ?>
                    <a href="dashboard.php" class="btn btn-primary">Mulai Top Up</a>
                    <a href="logout.php" class="btn btn-secondary">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">Login Sekarang</a>
                    <a href="#features" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2>Mengapa Memilih Kami?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Proses Instan</h3>
                <p>Top up akan diproses dalam hitungan menit setelah pembayaran berhasil</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <h3>Harga Terjangkau</h3>
                <p>Dapatkan harga terbaik dan kompetitif untuk semua kebutuhan top up game Anda</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>Transaksi Aman</h3>
                <p>Sistem keamanan berlapis untuk melindungi data dan transaksi Anda</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Customer Support 24/7</h3>
                <p>Tim customer service siap membantu Anda kapan saja</p>
            </div>
        </div>
    </section>

    <!-- Games Preview -->
    <section class="games-preview">
        <h2>Game Yang Tersedia</h2>
        <div class="games-grid">
            <div class="game-item">
                <div class="feature-icon">🎮</div>
                <h3>Mobile Legends</h3>
                <p>Diamond ML</p>
            </div>
            <div class="game-item">
                <div class="feature-icon">🔥</div>
                <h3>Free Fire</h3>
                <p>Diamond FF</p>
            </div>
            <div class="game-item">
                <div class="feature-icon">🎯</div>
                <h3>PUBG Mobile</h3>
                <p>UC PUBG</p>
            </div>
            <div class="game-item">
                <div class="feature-icon">⭐</div>
                <h3>Genshin Impact</h3>
                <p>Genesis Crystal</p>
            </div>
        </div>
    </section>

    <!-- Footer CTA -->
    <section class="hero" style="min-height: 50vh;">
        <div class="hero-content">
            <h2 style="font-size: 2.5rem; margin-bottom: 20px;">Siap Untuk Top Up?</h2>
            <p style="margin-bottom: 30px;">Bergabunglah dengan ribuan gamers yang sudah mempercayai kami</p>
            <?php if ($is_logged_in): ?>
                <a href="dashboard.php" class="btn btn-primary">Ke Dashboard</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary">Login Sekarang</a>
            <?php endif; ?>
        </div>
    </section>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for fade-in animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.feature-card, .game-item').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>