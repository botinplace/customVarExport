<?php
$data = file_get_contents('data.txt');

$resultFile = 'result.php';

$pages =  [
    [
        'id' => 1,
        'method' => 'GET',
        'path' => '/user/{id}',
		'page_hidden'=>false,
		'page_title'=>$data,
		'page_title_spare'=>'Альтернативный Заголовок',
		'page_meta_keywords'=> null,
        'page_meta_description'=> null,
        'controller' => [MainApp\Controllers\UserController::class, 'index'],
        'basetemplate' => null,
		'contentfile'=>null,
        'parent_id_page' => null,
		'needauth' => false,
		'onlyforguest'=> false,
		'priority'=>0,
        'layer' => 1		
    ],
    [
        'id' => 2,  
        'method' => 'GET',
        'path' => '/',
		'page_hidden'=>false,
		'page_title'=>'Заголовок',
		'page_title_spare'=>'Альтернативный Заголовок',
		'page_meta_keywords'=> null,
        'page_meta_description'=> null,
        'controller' => [MainApp\Controllers\IndexController::class, 'index'],
        'basetemplate' => null,
		'contentfile'=>null,
        'parent_id_page' => null,
		'needauth' => false,
		'onlyforguest'=> false,
		'priority'=>0,
        'layer' => 1  
    ]
];


function customVarExport($array) {
    // Проверка на то, является ли входящий параметр массивом
    if (!is_array($array)) {
        throw new \InvalidArgumentException('Параметр должен быть массивом.');
    }

    // Рекурсивная функция для обработки элементов массива
    return processArray($array);
}

function processArray($array, $indentLevel = 0) {
    $output = [];
    $indent = \str_repeat("    ", $indentLevel); // Уровень отступа

    foreach ($array as $key => $value) {
        // Если массив числовой, игнорируем ключ
        if (is_numeric($key)) {
            $output[] = $indent . '    ' . processValue($value, $indentLevel);
        } else {
            // Если массив ассоциативный, выводим ключ и значение
            $output[] = $indent . \var_export($key, true) . ' => ' . processValue($value, $indentLevel);
        }
    }

    // Возвращаем массив в короткой нотации
	$indent='    ';
    return "[\n" . implode(",\n", $output) . "\n$indent]";
}

function processValue($value, $indentLevel) {
    // Обрабатываем значения для корректного вывода
    if (is_array($value)) {
        return processArray($value, $indentLevel/2 + 2); // Увеличиваем уровень вложенности
    } elseif (is_string($value)) {
        return \var_export($value, true);
    } else {
        return \var_export($value, true);
    }
}

$content = "<?php \nreturn " . customVarExport( $pages ) . ";";

file_put_contents($resultFile, $content  );