<?php
session_start();

// Redirect ke login jika belum login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Ambil parameter game dari URL menggunakan $_GET
$selected_game = $_GET['game'] ?? '';
$username = $_SESSION['username'];
$login_time = $_SESSION['login_time'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Top up game online terpercaya dan terlengkap untuk semua game favorit Anda">
    <title>Dashboard - Lamurah Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .user-info {
            background: rgba(78, 205, 196, 0.2);
            border-left: 4px solid #4ecdc4;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .user-info .welcome {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .user-info .login-time {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .btn-logout {
            background: linear-gradient(45deg, #ff6b6b, #ff5252);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: all 0.3s ease;
            margin-left: 10px;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.5);
        }

        .game-filter {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .game-filter h3 {
            margin-bottom: 15px;
        }

        .game-filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-btn:hover, .filter-btn.active {
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            border-color: #4ecdc4;
            transform: translateY(-2px);
        }

        .game-card.hidden {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div id="loader" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.5s ease;
    ">
        <div style="text-align: center; color: white;">
            <div style="
                width: 60px;
                height: 60px;
                border: 4px solid rgba(255,255,255,0.3);
                border-top: 4px solid white;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 20px;
            "></div>
            <h2>Lamurah Store</h2>
            <p>Loading...</p>
        </div>
    </div>

    <header>
        <nav>
            <h1>Lamurah Store</h1>
            <ul>
                <li><a href="#home">Beranda</a></li>
                <li><a href="#games">Game</a></li>
                <li><a href="#cara-topup">Cara Top Up</a></li>
                <li><a href="#referensi">Referensi</a></li>
                <li><a href="logout.php" class="btn-logout">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- User Info -->
        <div class="user-info">
            <div>
                <div class="welcome">👋 Selamat datang, <strong><?php echo htmlspecialchars($username); ?></strong>!</div>
                <?php if ($login_time): ?>
                    <div class="login-time">Login: <?php echo htmlspecialchars($login_time); ?></div>
                <?php endif; ?>
            </div>
            <div>
                <a href="logout.php" class="btn-logout">🚪 Logout</a>
            </div>
        </div>

        <section id="home">
            <img src="lamurah_banner.png" alt="Lamurah Store Banner" class="banner-image">
            <h2>Selamat Datang di Lamurah Store</h2>
            <p>Platform top up game online terpercaya dengan proses yang cepat dan aman</p>
            <a href="#games" class="btn btn-primary">Mulai Top Up</a>
            
            <article class="card card-featured">
                <h3>Mengapa Memilih Kami?</h3>
                <ul>
                    <li>✨ Proses top up instan</li>
                    <li>💰 Harga terjangkau</li>
                    <li>🎯 Customer service 24/7</li>
                    <li>🔒 Pembayaran lengkap dan aman</li>
                </ul>
            </article>
        </section>

        <!-- Game Filter -->
        <section class="game-filter">
            <h3>🎮 Filter Game</h3>
            <div class="game-filter-buttons">
                <a href="?game=" class="filter-btn <?php echo ($selected_game === '') ? 'active' : ''; ?>">Semua Game</a>
                <a href="?game=ml" class="filter-btn <?php echo ($selected_game === 'ml') ? 'active' : ''; ?>">Mobile Legends</a>
                <a href="?game=ff" class="filter-btn <?php echo ($selected_game === 'ff') ? 'active' : ''; ?>">Free Fire</a>
                <a href="?game=pubg" class="filter-btn <?php echo ($selected_game === 'pubg') ? 'active' : ''; ?>">PUBG Mobile</a>
                <a href="?game=genshin" class="filter-btn <?php echo ($selected_game === 'genshin') ? 'active' : ''; ?>">Genshin Impact</a>
            </div>
        </section>

        <section id="games">
            <h2>Game Populer</h2>
            <div class="games-grid">
                <!-- Mobile Legends -->
                <article class="game-card <?php echo ($selected_game !== '' && $selected_game !== 'ml') ? 'hidden' : ''; ?>" data-game="ml">
                    <div class="game-header">
                        <div class="game-icon ml-icon"></div>
                        <h3>Mobile Legends: Bang Bang</h3>
                        <p>Top up diamond Mobile Legends dengan harga terbaik</p>
                    </div>
                    <div class="game-body">
                        <ul class="price-list">
                            <li class="price-item" data-game="Mobile Legends" data-item="86 Diamond" data-price="Rp 20.000">
                                <span>86 Diamond</span>
                                <span class="price-amount">Rp 20.000</span>
                            </li>
                            <li class="price-item" data-game="Mobile Legends" data-item="172 Diamond" data-price="Rp 40.000">
                                <span>172 Diamond</span>
                                <span class="price-amount">Rp 40.000</span>
                            </li>
                            <li class="price-item" data-game="Mobile Legends" data-item="257 Diamond" data-price="Rp 60.000">
                                <span>257 Diamond</span>
                                <span class="price-amount">Rp 60.000</span>
                            </li>
                            <li class="price-item" data-game="Mobile Legends" data-item="344 Diamond" data-price="Rp 80.000">
                                <span>344 Diamond</span>
                                <span class="price-amount">Rp 80.000</span>
                            </li>
                        </ul>
                        <button class="btn btn-secondary" disabled>Pilih Item Dulu</button>
                    </div>
                </article>

                <!-- Free Fire -->
                <article class="game-card <?php echo ($selected_game !== '' && $selected_game !== 'ff') ? 'hidden' : ''; ?>" data-game="ff">
                    <div class="game-header">
                        <div class="game-icon ff-icon"></div>
                        <h3>Free Fire</h3>
                        <p>Top up diamond Free Fire murah dan cepat</p>
                    </div>
                    <div class="game-body">
                        <ul class="price-list">
                            <li class="price-item" data-game="Free Fire" data-item="70 Diamond" data-price="Rp 10.000">
                                <span>70 Diamond</span>
                                <span class="price-amount">Rp 10.000</span>
                            </li>
                            <li class="price-item" data-game="Free Fire" data-item="140 Diamond" data-price="Rp 20.000">
                                <span>140 Diamond</span>
                                <span class="price-amount">Rp 20.000</span>
                            </li>
                            <li class="price-item" data-game="Free Fire" data-item="355 Diamond" data-price="Rp 50.000">
                                <span>355 Diamond</span>
                                <span class="price-amount">Rp 50.000</span>
                            </li>
                            <li class="price-item" data-game="Free Fire" data-item="720 Diamond" data-price="Rp 100.000">
                                <span>720 Diamond</span>
                                <span class="price-amount">Rp 100.000</span>
                            </li>
                        </ul>
                        <button class="btn btn-secondary" disabled>Pilih Item Dulu</button>
                    </div>
                </article>

                <!-- PUBG Mobile -->
                <article class="game-card <?php echo ($selected_game !== '' && $selected_game !== 'pubg') ? 'hidden' : ''; ?>" data-game="pubg">
                    <div class="game-header">
                        <div class="game-icon pubg-icon"></div>
                        <h3>PUBG Mobile</h3>
                        <p>Top up UC PUBG Mobile dengan berbagai nominal</p>
                    </div>
                    <div class="game-body">
                        <ul class="price-list">
                            <li class="price-item" data-game="PUBG Mobile" data-item="60 UC" data-price="Rp 15.000">
                                <span>60 UC</span>
                                <span class="price-amount">Rp 15.000</span>
                            </li>
                            <li class="price-item" data-game="PUBG Mobile" data-item="325 UC" data-price="Rp 75.000">
                                <span>325 UC</span>
                                <span class="price-amount">Rp 75.000</span>
                            </li>
                            <li class="price-item" data-game="PUBG Mobile" data-item="660 UC" data-price="Rp 150.000">
                                <span>660 UC</span>
                                <span class="price-amount">Rp 150.000</span>
                            </li>
                            <li class="price-item" data-game="PUBG Mobile" data-item="1800 UC" data-price="Rp 400.000">
                                <span>1800 UC</span>
                                <span class="price-amount">Rp 400.000</span>
                            </li>
                        </ul>
                        <button class="btn btn-secondary" disabled>Pilih Item Dulu</button>
                    </div>
                </article>

                <!-- Genshin Impact -->
                <article class="game-card <?php echo ($selected_game !== '' && $selected_game !== 'genshin') ? 'hidden' : ''; ?>" data-game="genshin">
                    <div class="game-header">
                        <div class="game-icon genshin-icon"></div>
                        <h3>Genshin Impact</h3>
                        <p>Top up Genesis Crystal untuk Genshin Impact</p>
                    </div>
                    <div class="game-body">
                        <ul class="price-list">
                            <li class="price-item" data-game="Genshin Impact" data-item="60 Genesis Crystal" data-price="Rp 16.000">
                                <span>60 Genesis Crystal</span>
                                <span class="price-amount">Rp 16.000</span>
                            </li>
                            <li class="price-item" data-game="Genshin Impact" data-item="330 Genesis Crystal" data-price="Rp 79.000">
                                <span>330 Genesis Crystal</span>
                                <span class="price-amount">Rp 79.000</span>
                            </li>
                            <li class="price-item" data-game="Genshin Impact" data-item="1090 Genesis Crystal" data-price="Rp 249.000">
                                <span>1090 Genesis Crystal</span>
                                <span class="price-amount">Rp 249.000</span>
                            </li>
                            <li class="price-item" data-game="Genshin Impact" data-item="2240 Genesis Crystal" data-price="Rp 499.000">
                                <span>2240 Genesis Crystal</span>
                                <span class="price-amount">Rp 499.000</span>
                            </li>
                        </ul>
                        <button class="btn btn-secondary" disabled>Pilih Item Dulu</button>
                    </div>
                </article>
            </div>
        </section>

        <section id="cara-topup">
            <h2>Cara Top Up</h2>
            <div class="steps-container">
                <article>
                    <h3>Langkah-langkah Top Up</h3>
                    <ol class="steps-list">
                        <li class="step-item">Pilih game yang ingin di top up</li>
                        <li class="step-item">Masukkan User ID atau Player ID</li>
                        <li class="step-item">Pilih nominal diamond/UC yang diinginkan</li>
                        <li class="step-item">Pilih metode pembayaran</li>
                        <li class="step-item">Lakukan pembayaran sesuai instruksi</li>
                        <li class="step-item">Diamond/UC akan masuk otomatis ke akun game Anda</li>
                    </ol>
                </article>

                <article class="card">
                    <h3>Metode Pembayaran</h3>
                    <ul>
                        <li>🏦 Transfer Bank (BCA, BRI, BNI, Mandiri)</li>
                        <li>💳 E-Wallet (OVO, DANA, GoPay, LinkAja)</li>
                        <li>📱 Pulsa (Telkomsel, XL, Indosat, Tri)</li>
                        <li>🏪 Minimarket (Indomaret, Alfamart)</li>
                    </ul>
                </article>
            </div>
        </section>

        <section id="keunggulan">
            <h2>Keunggulan Layanan Kami</h2>
            <div class="features-grid">
                <article class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Transaksi Aman</h3>
                    <p>Sistem keamanan berlapis untuk melindungi data dan transaksi Anda</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Proses Cepat</h3>
                    <p>Top up akan diproses dalam hitungan menit setelah pembayaran berhasil</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Customer Support</h3>
                    <p>Tim customer service siap membantu Anda 24 jam sehari, 7 hari seminggu</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Harga Kompetitif</h3>
                    <p>Dapatkan harga terbaik untuk semua kebutuhan top up game Anda</p>
                </article>
            </div>
        </section>

        <section id="testimoni">
            <h2>Testimoni Pelanggan</h2>
            <div class="testimonial-grid">
                <article class="testimonial-card">
                    <blockquote>
                        <p>"Pelayanan sangat cepat dan memuaskan! Diamond masuk langsung ke akun ML saya."</p>
                        <cite>- Bima Cengkareng</cite>
                    </blockquote>
                </article>

                <article class="testimonial-card">
                    <blockquote>
                        <p>"Harga murah dan terpercaya. Sudah langganan top up disini sejak lama."</p>
                        <cite>- Raka Cemani</cite>
                    </blockquote>
                </article>

                <article class="testimonial-card">
                    <blockquote>
                        <p>"Customer service ramah dan responsif. Recommended banget!"</p>
                        <cite>- Asep Tenggara</cite>
                    </blockquote>
                </article>
            </div>
        </section>
    </main>

    <aside>
        <section class="promo-card">
            <h3>Promo Bulan Ini</h3>
            <h4>Diskon 10% untuk Top Up Pertama</h4>
            <p>Dapatkan diskon 10% untuk transaksi top up pertama Anda.</p>
            <div class="promo-code">WELCOME10</div>
            <small style="display: block; margin-top: 10px; opacity: 0.8;">*Klik kode untuk menyalin</small>
        </section>

        <section class="card">
            <h3>Tips Gaming</h3>
            <h4>Cara Bermain Mobile Legends Efektif</h4>
            <p>Pelajari hero roles dan strategi team fight untuk meningkatkan winrate Anda</p>
            <a href="#" class="btn btn-secondary">Baca Tips</a>
        </section>
    </aside>

    <!-- Tambahkan di dashboard.php sebelum footer -->
<section id="admin-crud" style="margin: 60px 0; background: rgba(255,255,255,0.05); padding: 30px; border-radius: 15px;">
    <h2>📊 Admin Panel - Kelola Produk</h2>
    
    <?php
    // Include koneksi database
    include 'koneksi.php';
    
    // Proses CRUD
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_product'])) {
            // Tambah produk
            $game_name = $conn->real_escape_string($_POST['game_name']);
            $item_name = $conn->real_escape_string($_POST['item_name']);
            $price = $conn->real_escape_string($_POST['price']);
            
            $sql = "INSERT INTO products (game_name, item_name, price) VALUES ('$game_name', '$item_name', '$price')";
            if ($conn->query($sql)) {
                echo "<div class='notification success' style='background: rgba(78,205,196,0.3); padding: 10px; border-radius: 5px; margin: 10px 0;'>Produk berhasil ditambahkan!</div>";
            } else {
                echo "<div class='notification error' style='background: rgba(255,107,107,0.3); padding: 10px; border-radius: 5px; margin: 10px 0;'>Error: " . $conn->error . "</div>";
            }
        }
        
        if (isset($_POST['update_product'])) {
            // Update produk
            $id = $conn->real_escape_string($_POST['product_id']);
            $game_name = $conn->real_escape_string($_POST['game_name']);
            $item_name = $conn->real_escape_string($_POST['item_name']);
            $price = $conn->real_escape_string($_POST['price']);
            
            $sql = "UPDATE products SET game_name='$game_name', item_name='$item_name', price='$price' WHERE id='$id'";
            if ($conn->query($sql)) {
                echo "<div class='notification success' style='background: rgba(78,205,196,0.3); padding: 10px; border-radius: 5px; margin: 10px 0;'>Produk berhasil diupdate!</div>";
            } else {
                echo "<div class='notification error' style='background: rgba(255,107,107,0.3); padding: 10px; border-radius: 5px; margin: 10px 0;'>Error: " . $conn->error . "</div>";
            }
        }
        
        if (isset($_POST['delete_product'])) {
            // Hapus produk
            $id = $conn->real_escape_string($_POST['product_id']);
            
            $sql = "DELETE FROM products WHERE id='$id'";
            if ($conn->query($sql)) {
                echo "<div class='notification success' style='background: rgba(78,205,196,0.3); padding: 10px; border-radius: 5px; margin: 10px 0;'>Produk berhasil dihapus!</div>";
            } else {
                echo "<div class='notification error' style='background: rgba(255,107,107,0.3); padding: 10px; border-radius: 5px; margin: 10px 0;'>Error: " . $conn->error . "</div>";
            }
        }
    }
    ?>
    
    <!-- Form Tambah Produk -->
    <div class="card" style="margin: 20px 0;">
        <h3>➕ Tambah Produk Baru</h3>
        <form method="POST" style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end;">
            <div>
                <label>Nama Game:</label>
                <input type="text" name="game_name" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white;">
            </div>
            <div>
                <label>Nama Item:</label>
                <input type="text" name="item_name" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white;">
            </div>
            <div>
                <label>Harga (Rp):</label>
                <input type="number" name="price" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white;">
            </div>
            <div>
                <button type="submit" name="add_product" class="btn btn-primary" style="padding: 8px 15px;">Tambah</button>
            </div>
        </form>
    </div>
    
    <!-- Daftar Produk -->
    <div class="card">
        <h3>📋 Daftar Produk</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="background: rgba(255,255,255,0.1);">
                    <th style="padding: 10px; text-align: left;">ID</th>
                    <th style="padding: 10px; text-align: left;">Game</th>
                    <th style="padding: 10px; text-align: left;">Item</th>
                    <th style="padding: 10px; text-align: left;">Harga</th>
                    <th style="padding: 10px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM products ORDER BY game_name, price");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='border-bottom: 1px solid rgba(255,255,255,0.1);'>";
                        echo "<td style='padding: 10px;'>{$row['id']}</td>";
                        echo "<td style='padding: 10px;'>{$row['game_name']}</td>";
                        echo "<td style='padding: 10px;'>{$row['item_name']}</td>";
                        echo "<td style='padding: 10px;'>Rp " . number_format($row['price'], 0, ',', '.') . "</td>";
                        echo "<td style='padding: 10px; text-align: center;'>
                                <form method='POST' style='display: inline;' onsubmit='return confirm(\"Hapus produk ini?\")'>
                                    <input type='hidden' name='product_id' value='{$row['id']}'>
                                    <button type='submit' name='delete_product' class='btn-logout' style='padding: 5px 10px; font-size: 0.8rem;'>Hapus</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='padding: 10px; text-align: center;'>Tidak ada data produk</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <!-- Form Update Produk -->
    <div class="card">
        <h3>✏️ Update Produk</h3>
        <form method="POST" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 10px; align-items: end;">
            <div>
                <label>ID Produk:</label>
                <input type="number" name="product_id" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white;">
            </div>
            <div>
                <label>Nama Game:</label>
                <input type="text" name="game_name" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white;">
            </div>
            <div>
                <label>Nama Item:</label>
                <input type="text" name="item_name" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white;">
            </div>
            <div>
                <label>Harga (Rp):</label>
                <input type="number" name="price" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white;">
            </div>
            <div>
                <button type="submit" name="update_product" class="btn btn-primary" style="padding: 8px 15px;">Update</button>
            </div>
        </form>
    </div>
</section>

<?php $conn->close(); ?>

    <footer id="referensi">
        <section>
            <h3>Referensi</h3>
            <p>Website ini dibuat dengan referensi dari: <a href="https://www.momomlbb.com/id-id" target="_blank" rel="noopener">https://www.momomlbb.com/id-id</a></p>
        </section>

        <section>
            <p>&copy; 2025 Lamurah Store.</p>
            <p>Dibuat untuk keperluan pembelajaran web development</p>
        </section>
    </footer>
    <script src="script.js"></script>
</body>
</html>