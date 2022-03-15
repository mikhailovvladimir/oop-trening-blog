<?php
// фронт контроллер для конслольных приложений
try {
    unset($argv[0]);

    spl_autoload_register(function (string $className) {
        require_once __DIR__ . '/../src/' . $className . '.php';
    });

    $className = '\\MyProject\\Cli\\' . array_shift($argv);


    if (!class_exists($className)) {
        throw new MyProject\Exceptions\CliException('Class "' . $className . '" не найден');
    }

    $parentClasses = class_parents($className);
    if (!in_array('MyProject\\Cli\\AbstractCommand', $parentClasses)) {
        throw new MyProject\Exceptions\CliException('Class "' . $className . '" не имеет родителя');
    }

    $params = [];
    foreach ($argv as $argument) {
        preg_match('/^-(.+)=(.+)$/', $argument, $matches);
        if (!empty($matches)) {
            $paramName = $matches[1];
            $paramValue = $matches[2];

            $params[$paramName] = $paramValue;
        }
    }

    $class = new $className($params);
    $class->execute();
} catch (\MyProject\Exceptions\CliException $e) {
    echo 'Error ' . $e->getMessage();
}