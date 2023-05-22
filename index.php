<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

function getPartsFromFullname($fullname) {
    $parts = explode(' ', $fullname);
    $result = [
        'surname' => $parts[0],
        'name' => $parts[1],
        'patronymic' => $parts[2]
    ];
    return $result;
}

function mergePersonsArray($persons_array) {
    $result = [];
    foreach ($persons_array as $person) {
        $name_parts = getPartsFromFullname($person['fullname']);
        $person_data = [
            'surname' => $name_parts['surname'],
            'name' => $name_parts['name'],
            'patronymic' => $name_parts['patronymic'],
        ];
        $result[] = $person_data;
    }
    return $result;
}

$merged_array = mergePersonsArray($example_persons_array);

// Выводим результат
foreach ($merged_array as $person) {
    echo 'Фамилия: ' . $person['surname'] . '<br>';
    echo 'Имя: ' . $person['name'] . '<br>';
    echo 'Отчество: ' . $person['patronymic'] . '<br><br>';
}
?>
<hr>
<?php
function getFullnameFromParts($surname, $name, $patronymic) {
    return $surname . ' ' . $name . ' ' . $patronymic;
}

foreach ($example_persons_array as $person) {
    $fullname = getFullnameFromParts(
        // Разбиваем полное имя на части
        explode(' ', $person['fullname'])[0], // Фамилия
        explode(' ', $person['fullname'])[1], // Имя
        explode(' ', $person['fullname'])[2],  // Отчество
    );
    echo $fullname . '<br><br>';
}
?>
<hr>
<?php
function getShortName($fullname) {
    $name_parts = getPartsFromFullname($fullname);
    $short_surname = mb_substr($name_parts['surname'], 0, 1) . '.'.'<br>';
    $result = $name_parts['name'] . ' ' . $short_surname.'<br>';
    return $result;
}

foreach ($example_persons_array as $person) {
    $short_name = getShortName($person['fullname']);
    echo $short_name;
}
?>
<hr>
<?php
function getGenderFromName($fullname) {
    $parts = getPartsFromFullname($fullname);
    $gender_sum = 0;
    foreach ($parts as $part) {
        if (in_array($part, ['муж']) || preg_match('/ич$/', $part) || preg_match('/^(й|н)$/', $part)){
            $gender_sum++;
        } elseif (in_array($part, ['жен']) || preg_match('/(вна|ва)$/', $part) || preg_match('/^а$/', $part)) {
            $gender_sum--;
        }
    }
    if ($gender_sum > 0) {
        return 1;
    } elseif ($gender_sum < 0) {
        return -1;
    } else {
        return 0;
    }
}

foreach ($example_persons_array as $person) {
    $gender = getGenderFromName($person['fullname']);
    echo $gender.'<br><br>';
}
?>
<hr>
<?php
function getGenderDescription($persons_array){
    $total_count = count($persons_array);
    $male_count = count(array_filter($persons_array, function($person){
        return getGenderFromName($person['fullname']) == 1;
    }));
    $female_count = count(array_filter($persons_array, function($person){
        return getGenderFromName($person['fullname']) == -1;
    }));
    $unknown_count = $total_count - $male_count - $female_count;
    
    $male_percent = round($male_count / $total_count * 100);
    $female_percent = round($female_count / $total_count * 100);
    $unknown_percent = round($unknown_count / $total_count * 100);
    
    return "Гендерный состав аудитории:<br><br>Мужчины - {$male_percent}%\n<br><br>Женщины - {$female_percent}%\n<br><br>Не удалось определить - {$unknown_percent}%";
}

echo getGenderDescription($example_persons_array);
?>  
</body>
</html>