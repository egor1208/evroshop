<?php
session_start();
require_once '../config/database.php';

// Проверка прав администратора
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Получение статистики
$stats = [
    'products' => $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(),
    'orders' => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'users' => $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>Админ-панель</h2>
            <nav>
                <ul>
                    <li><a href="index.php">Дашборд</a></li>
                    <li><a href="products.php">Товары</a></li>
                    <li><a href="categories.php">Категории</a></li>
                    <li><a href="orders.php">Заказы</a></li>
                    <li><a href="users.php">Пользователи</a></li>
                    <li><a href="../logout.php">Выход</a></li>
                </ul>
            </nav>
        </aside>

        <main class="content">
            <h1>Дашборд</h1>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Товары</h3>
                    <p><?php echo $stats['products']; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Заказы</h3>
                    <p><?php echo $stats['orders']; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Пользователи</h3>
                    <p><?php echo $stats['users']; ?></p>
                </div>
            </div>

            <div class="recent-orders">
                <h2>Последние заказы</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Пользователь</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("
                            SELECT o.*, u.username 
                            FROM orders o 
                            JOIN users u ON o.user_id = u.id 
                            ORDER BY o.created_at DESC 
                            LIMIT 5
                        ");
                        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['username']); ?></td>
                            <td><?php echo number_format($order['total_amount'], 2); ?> ₽</td>
                            <td><?php echo $order['status']; ?></td>
                            <td><?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html> 