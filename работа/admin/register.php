<?php
session_start();
require_once 'config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Валидация
    if (empty($username)) {
        $errors[] = "Введите имя пользователя";
    }
    if (empty($email)) {
        $errors[] = "Введите email";
    }
    if (empty($password)) {
        $errors[] = "Введите пароль";
    }
    if ($password !== $password_confirm) {
        $errors[] = "Пароли не совпадают";
    }

    // Проверка существующего пользователя
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Пользователь с таким именем или email уже существует";
        }
    }

    // Регистрация
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        
        try {
            $stmt->execute([$username, $email, $password_hash]);
            $_SESSION['success'] = "Регистрация успешна! Теперь вы можете войти.";
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Ошибка при регистрации. Попробуйте позже.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <div class="auth-container">
            <h1>Регистрация</h1>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Подтверждение пароля</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                </div>

                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            </form>

            <p class="auth-links">
                Уже есть аккаунт? <a href="login.php">Войти</a>
            </p>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>