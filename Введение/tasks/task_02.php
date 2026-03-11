<?php
/**
 * ЗАДАНИЕ 2: Работа с данными студентов
 * 
 * Ваша задача: дописать функции для работы с массивом студентов
 * 
 * Что нужно сделать:
 * 1. Создать функцию getAverageScore($students), которая вычисляет средний балл всех студентов
 * 2. Создать функцию getBestStudent($students), которая возвращает студента с наивысшим баллом
 * 3. Создать функцию getStudentsByCourse($students, $course), которая возвращает студентов определенного курса
 * 4. Создать функцию addStudent(&$students, $name, $age, $course, $score), которая добавляет нового студента
 * 5. Дополнить код ниже, чтобы все функции работали корректно
 */

// Массив студентов (не изменяйте этот массив напрямую)
$студенты = [
    ["имя" => "Иван", "возраст" => 20, "курс" => 2, "балл" => 4.5],
    ["имя" => "Мария", "возраст" => 19, "курс" => 1, "балл" => 5.0],
    ["имя" => "Алексей", "возраст" => 21, "курс" => 3, "балл" => 4.2],
    ["имя" => "Анна", "возраст" => 20, "курс" => 2, "балл" => 4.8],
    ["имя" => "Дмитрий", "возраст" => 22, "курс" => 4, "балл" => 3.9]
];

// TODO 1: Создайте функцию getAverageScore
// Функция должна вычислить средний балл всех студентов
function getAverageScore($students) {
    if (empty($students)) {
        return 0;
    }
    $sum = 0;
    $count = 0;
    
    foreach ($students as $student) {
        $sum += $student['балл'];
        $count++;
    }
    return $sum / $count;
}

// TODO 2: Создайте функцию getBestStudent
// Функция должна вернуть массив с данными студента с наивысшим баллом
function getBestStudent($students) {
    if (empty($students)) {
        return null;
    }
    $bestStudent = $students[0];
    foreach ($students as $student) {
        if ($student['балл'] > $bestStudent['балл']) {
            $bestStudent = $student;
        }
    }
    return $bestStudent;

}

// TODO 3: Создайте функцию getStudentsByCourse
function getStudentsByCourse($students, $course) {

    $result = [];

    foreach ($students as $student) {
        if ($student['курс'] == $course) {
            $result[] = $student;
        }
    }
    return $result;
}


// TODO 4: Создайте функцию addStudent
// Функция должна добавить нового студента в массив (используйте & для передачи по ссылке)
function addStudent(&$students, $name, $age, $course, $score) {
    $students[] = [
        "имя" => $name,
        "возраст" => $age,
        "курс" => $course,
        "балл" => $score
    ];
}

// ============================================
// Тестирование функций (не изменяйте этот код)
// ============================================
echo "<h1>Задание 2: Работа с данными студентов</h1>";

echo "<h2>Исходный список студентов:</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Имя</th><th>Возраст</th><th>Курс</th><th>Балл</th></tr>";
foreach ($студенты as $студент) {
    echo "<tr>";
    echo "<td>" . $студент["имя"] . "</td>";
    echo "<td>" . $студент["возраст"] . "</td>";
    echo "<td>" . $студент["курс"] . "</td>";
    echo "<td>" . $студент["балл"] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h2>Результаты:</h2>";

// Тест 1: Средний балл
$средний_балл = getAverageScore($студенты);
$ожидаемый_средний = 4.48; // (4.5 + 5.0 + 4.2 + 4.8 + 3.9) / 5
echo "<p><strong>Средний балл всех студентов:</strong> ";
if (abs($средний_балл - $ожидаемый_средний) < 0.01) {
    echo "<span style='color: green;'>$средний_балл ✓</span></p>";
} else {
    echo "<span style='color: red;'>$средний_балл (ожидалось: ~$ожидаемый_средний) ✗</span></p>";
}

// Тест 2: Лучший студент
$лучший = getBestStudent($студенты);
echo "<p><strong>Лучший студент:</strong> ";
if (isset($лучший["имя"]) && $лучший["имя"] === "Мария" && $лучший["балл"] === 5.0) {
    echo "<span style='color: green;'>" . $лучший["имя"] . " (балл: " . $лучший["балл"] . ") ✓</span></p>";
} else {
    echo "<span style='color: red;'>";
    if (isset($лучший["имя"])) {
        echo $лучший["имя"] . " (балл: " . ($лучший["балл"] ?? 'не указан') . ")";
    } else {
        echo "Функция не вернула правильный результат";
    }
    echo " ✗</span></p>";
}

// Тест 3: Студенты 2 курса
$студенты_2_курса = getStudentsByCourse($студенты, 2);
echo "<p><strong>Студенты 2 курса:</strong> ";
$имена_2_курса = array_column($студенты_2_курса, "имя");
if (count($студенты_2_курса) === 2 && in_array("Иван", $имена_2_курса) && in_array("Анна", $имена_2_курса)) {
    echo "<span style='color: green;'>" . implode(", ", $имена_2_курса) . " ✓</span></p>";
} else {
    echo "<span style='color: red;'>" . (count($имена_2_курса) > 0 ? implode(", ", $имена_2_курса) : "нет результатов") . " ✗</span></p>";
}

// Тест 4: Добавление студента
$количество_до = count($студенты);
addStudent($студенты, "Елена", 19, 1, 4.7);
$количество_после = count($студенты);
echo "<p><strong>Добавление студента:</strong> ";
if ($количество_после === $количество_до + 1) {
    $последний = end($студенты);
    if ($последний["имя"] === "Елена" && $последний["балл"] === 4.7) {
        echo "<span style='color: green;'>Студент добавлен: " . $последний["имя"] . " ✓</span></p>";
    } else {
        echo "<span style='color: red;'>Студент добавлен, но данные неверны ✗</span></p>";
    }
} else {
    echo "<span style='color: red;'>Студент не добавлен ✗</span></p>";
}

// Показать обновленный список
echo "<h2>Обновленный список студентов:</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Имя</th><th>Возраст</th><th>Курс</th><th>Балл</th></tr>";
foreach ($студенты as $студент) {
    echo "<tr>";
    echo "<td>" . $студент["имя"] . "</td>";
    echo "<td>" . $студент["возраст"] . "</td>";
    echo "<td>" . $студент["курс"] . "</td>";
    echo "<td>" . $студент["балл"] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 2: Работа с данными</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1, h2 {
            color: #333;
        }
        table {
            background-color: white;
            margin: 20px 0;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <p><a href="task_01.php">← Предыдущее задание</a></p>
</body>
</html>
