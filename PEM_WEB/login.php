<?php
session_start();

// Redirect ke dashboard jika sudah login
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit;
}

// Proses login
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Validasi: username dan password tidak boleh kosong
    if (empty($username)) {
        $error = 'Username tidak boleh kosong!';
    } elseif (empty($password)) {
        $error = 'Password tidak boleh kosong!';
    } else {
        // Semua username dan password yang tidak kosong bisa login
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lamurah Store</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 90%;
            max-width: 400px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 2.5rem;
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-group input:focus {
            outline: none;
            border-color: #4ecdc4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.6);
        }

        .error-message {
            background: rgba(255, 107, 107, 0.3);
            border-left: 4px solid #ff6b6b;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .demo-info {
            margin-top: 20px;
            padding: 15px;
            background: rgba(78, 205, 196, 0.2);
            border-radius: 10px;
            border-left: 4px solid #4ecdc4;
            font-size: 0.9rem;
        }

        .demo-info strong {
            display: block;
            margin-bottom: 5px;
            color: #4ecdc4;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Lamurah Store</h1>
            <p>Login untuk mengakses dashboard</p>
        </div>

        <?php if ($error): ?>
            <div class="error-message">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="demo-info">
            <strong>ℹ️ Informasi Login:</strong>
            Gunakan username dan password apa saja (tidak boleh kosong)
        </div>
    </div>
</body>
</html>