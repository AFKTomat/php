<?php
/**
 * ЗАДАНИЕ 1: Простой калькулятор
 * 
 * Ваша задача: дописать код калькулятора, который выполняет основные операции
 * 
 * Что нужно сделать:
 * 1. Создать функцию calculate($a, $b, $operation), которая принимает два числа и операцию
 * 2. Функция должна поддерживать операции: '+', '-', '*', '/'
 * 3. При делении на ноль должна возвращать сообщение об ошибке
 * 4. Если операция неизвестна, вернуть сообщение об ошибке
 * 5. Дополнить код ниже, чтобы калькулятор работал
 */

// TODO: Создайте функцию calculate здесь
// Подсказка: используйте switch или if-else для проверки операции

function calculate($a, $b, $operation) {

  switch ($operation) {
    case '+':
      return $a + $b;
    case '-':
      return $a - $b;
    case '*':
      return $a * $b;
    case '/':
      if ($b == 0) {
        return "Ошибка: деление на ноль";
      }
    return $a / $b;
  default:
    return "Неизвестная операция";
  }
}

// ============================================
// Тестовые примеры (не изменяйте этот код)
// ============================================
echo "<h1>Задание 1: Калькулятор</h1>";
echo "<h2>Тестовые примеры:</h2>";

$тесты = [
    [10, 5, '+', 15],
    [10, 5, '-', 5],
    [10, 5, '*', 50],
    [10, 5, '/', 2],
    [10, 0, '/', 'Ошибка: деление на ноль'],
    [10, 5, '%', 'Неизвестная операция']
];

foreach ($тесты as $тест) {
    $a = $тест[0];
    $b = $тест[1];
    $операция = $тест[2];
    $ожидаемый_результат = $тест[3];
    
    $результат = calculate($a, $b, $операция);
    
    echo "$a $операция $b = ";
    
    if ($результат === $ожидаемый_результат) {
        echo "<span style='color: green;'>$результат ✓</span><br>";
    } else {
        echo "<span style='color: red;'>$результат (ожидалось: $ожидаемый_результат) ✗</span><br>";
    }
}

// ============================================
// Интерактивный калькулятор (бонусное задание)
// ============================================
echo "<h2>Интерактивный калькулятор:</h2>";
echo "<form method='GET'>";
echo "Число 1: <input type='number' name='num1' value='" . ($_GET['num1'] ?? '') . "'><br><br>";
echo "Операция: <select name='operation'>";
echo "<option value='+'" . (($_GET['operation'] ?? '') === '+' ? ' selected' : '') . ">+</option>";
echo "<option value='-'" . (($_GET['operation'] ?? '') === '-' ? ' selected' : '') . ">-</option>";
echo "<option value='*'" . (($_GET['operation'] ?? '') === '*' ? ' selected' : '') . ">×</option>";
echo "<option value='/'" . (($_GET['operation'] ?? '') === '/' ? ' selected' : '') . ">÷</option>";
echo "</select><br><br>";
echo "Число 2: <input type='number' name='num2' value='" . ($_GET['num2'] ?? '') . "'><br><br>";
echo "<input type='submit' value='Вычислить'>";
echo "</form>";

if (isset($_GET['num1']) && isset($_GET['num2']) && isset($_GET['operation'])) {
    $num1 = (float)$_GET['num1'];
    $num2 = (float)$_GET['num2'];
    $operation = $_GET['operation'];
    
    $result = calculate($num1, $num2, $operation);
    echo "<h3>Результат: $result</h3>";
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 1: Калькулятор</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1, h2 {
            color: #333;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        input, select {
            padding: 8px;
            margin: 5px 0;
            font-size: 16px;
        }
        input[type='submit'] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type='submit']:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <p><a href="../examples/04_arrays.php">← Назад к примерам</a> | <a href="task_02.php">Следующее задание →</a></p>
</body>
</html>
