<?php
/**
 * ЗАДАНИЕ 3: Форма обратной связи с валидацией
 *
 * Ваша задача: обработать форму и проверить введённые данные
 *
 * Что нужно сделать:
 * 1. При отправке формы (method="POST") получить из $_POST поля: name, email, message
 * 2. Валидация: имя — не пустое, не короче 2 символов; email — корректный формат; сообщение — не пустое
 * 3. Вывести ошибки под формой, если есть; иначе вывести сообщение «Данные приняты»
 * 4. Сохранять в полях формы введённые значения (чтобы при ошибке пользователь не терял ввод)
 * 5. Использовать htmlspecialchars() при выводе любых данных от пользователя
 */

$ошибки = [];
$успех = false;
$сохранённые = ['name' => '', 'email' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $сохранённые['name'] = trim($_POST['name'] ?? '');
    $сохранённые['email'] = trim($_POST['email'] ?? '');
    $сохранённые['message'] = trim($_POST['message'] ?? '');

    // TODO: добавьте проверки и заполняйте массив $ошибки
    // Пример: if (strlen($сохранённые['name']) < 2) { $ошибки[] = 'Имя должно быть не короче 2 символов'; }
    // Для email используйте filter_var($email, FILTER_VALIDATE_EMAIL)
    
    // Проверка имени
    if (empty($сохранённые['name'])) {
        $ошибки[] = 'Имя не может быть пустым';
    } elseif (strlen($сохранённые['name']) < 2) {
        $ошибки[] = 'Имя должно содержать не менее 2 символов';
    }
    
    // Проверка email
    if (empty($сохранённые['email'])) {
        $ошибки[] = 'Email не может быть пустым';
    } elseif (!filter_var($сохранённые['email'], FILTER_VALIDATE_EMAIL)) {
        $ошибки[] = 'Введите корректный email адрес';
    }
    
    // Проверка сообщения
    if (empty($сохранённые['message'])) {
        $ошибки[] = 'Сообщение не может быть пустым';
    }

    if (empty($ошибки)) {
        $успех = true;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 3: Форма с валидацией</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        .error { color: #c00; margin: 10px 0; }
        .success { color: #080; margin: 10px 0; }
        form { background: #fff; padding: 20px; border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 8px; box-sizing: border-box; margin-top: 4px; }
        textarea { min-height: 100px; resize: vertical; }
        button { margin-top: 15px; padding: 10px 20px; background: #4CAF50; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #45a049; }
    </style>
</head>
<body>
    <h1>Задание 3: Форма обратной связи</h1>
    <p>Дополните код валидации в файле <code>task_03.php</code>: проверьте имя (не пустое, ≥ 2 символов), email (корректный формат), сообщение (не пустое).</p>

    <?php if (!empty($ошибки)): ?>
        <ul class="error">
            <?php foreach ($ошибки as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($успех): ?>
        <p class="success">Данные приняты. Спасибо за обращение!</p>
    <?php endif; ?>

    <form method="POST">
        <label>Имя: <input type="text" name="name" value="<?= htmlspecialchars($сохранённые['name']) ?>"></label>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($сохранённые['email']) ?>"></label>
        <label>Сообщение: <textarea name="message"><?= htmlspecialchars($сохранённые['message']) ?></textarea></label>
        <button type="submit">Отправить</button>
    </form>

    <p style="margin-top: 20px;"><a href="task_02.php">← Предыдущее задание</a> | <a href="task_04.php">Следующее задание →</a></p>
</body>
</html>
