<?php
/**
 * ЗАДАНИЕ 4: Счётчик посещений и «корзина» в сессии
 *
 * Ваша задача: использовать сессии для хранения данных между запросами
 *
 * Что нужно сделать:
 * 1. В начале скрипта вызвать session_start() (до любого вывода)
 * 2. Реализовать счётчик посещений: при каждом заходе на страницу увеличивать значение в $_SESSION['visits']
 * 3. Реализовать простую «корзину»: массив $_SESSION['cart'] — список товаров (названия строкой).
 *    Форма добавляет товар в корзину (поле product_name), корзина выводится списком ниже.
 * 4. Добавить кнопку «Очистить корзину», которая очищает $_SESSION['cart'] и перенаправляет на эту же страницу
 * 5. Добавить кнопку «Сбросить счётчик», которая сбрасывает $_SESSION['visits'] в 0
 */

// Запускаем сессию в самом начале (до любого вывода)
session_start();

$сообщение = '';

// Обработка действий
if (isset($_GET['action'])) {
    // Очистка корзины
    if ($_GET['action'] === 'clear_cart') {
        $_SESSION['cart'] = [];
        // Перенаправляем на эту же страницу без параметров action
        header('Location: task_04.php');
        exit;
    }
    
    // Сброс счётчика посещений
    if ($_GET['action'] === 'reset_visits') {
        $_SESSION['visits'] = 0;
        // Перенаправляем на эту же страницу без параметров action
        header('Location: task_04.php');
        exit;
    }
}

// Инициализация счётчика посещений, если не задан
if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 0;
}
// Увеличиваем счётчик на 1 при каждом заходе на страницу
$_SESSION['visits']++;

// Инициализация корзины как пустого массива, если не задана
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Добавление товара в корзину из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['product_name'] ?? ''))) {
    // Добавляем товар в массив корзины
    $_SESSION['cart'][] = trim($_POST['product_name']);
    $сообщение = 'Товар добавлен в корзину.';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 4: Сессии</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        h1, h2 { color: #333; }
        .block { background: #fff; padding: 15px; border-radius: 8px; margin: 15px 0; }
        input[type="text"] { padding: 8px; width: 250px; }
        button, .btn { display: inline-block; padding: 8px 16px; margin: 5px 5px 5px 0; background: #4CAF50; color: #fff; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn.secondary { background: #666; }
        .btn.danger { background: #c00; }
        ul { margin: 10px 0; padding-left: 20px; }
    </style>
</head>
<body>
    <h1>Задание 4: Счётчик и корзина в сессии</h1>
    <p>Дополните код: session_start(), счётчик посещений, добавление товара в корзину, кнопки «Очистить корзину» и «Сбросить счётчик».</p>

    <?php if ($сообщение): ?>
        <p style="color: #080;"><?= htmlspecialchars($сообщение) ?></p>
    <?php endif; ?>

    <div class="block">
        <h2>Счётчик посещений</h2>
        <p>Вы открыли эту страницу в текущей сессии: <strong><?= (int)($_SESSION['visits'] ?? 0) ?></strong> раз(а).</p>
        <a href="task_04.php?action=reset_visits" class="btn secondary">Сбросить счётчик</a>
    </div>

    <div class="block">
        <h2>Корзина</h2>
        <form method="POST">
            <input type="text" name="product_name" placeholder="Название товара" required>
            <button type="submit">Добавить в корзину</button>
        </form>
        <?php if (!empty($_SESSION['cart'])): ?>
            <ul>
                <?php foreach ($_SESSION['cart'] as $товар): ?>
                    <li><?= htmlspecialchars($товар) ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="task_04.php?action=clear_cart" class="btn danger">Очистить корзину</a>
        <?php else: ?>
            <p>Корзина пуста.</p>
        <?php endif; ?>
    </div>

    <p><a href="task_03.php">← Предыдущее задание</a> | <a href="task_05.php">Следующее задание →</a></p>
</body>
</html>
