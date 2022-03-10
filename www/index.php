<?php
try {
    spl_autoload_register(function (string $className) {
        require_once __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';
    });

    $route = $_GET['route'] ?? '';

    $routes = require __DIR__ . '/../src/routes.php';

// ищем сопадения по патерну
    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

// если роут не найден значит страница не найдена
    if (!$isRouteFound) {
        throw new \MyProject\Exceptions\NotFoundException();
    }

// просто удаляем полное совпадение по патерну
// так как оно не нужно
    unset($matches[0]);

// получаем контроллер и экшен и вызываем их
    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

// с помощью ... получаем аргументы в том
// порядке в котором они идут в массиве, то есть если начинается с одного
// то 0 считать не будет
    $controller = new $controllerName();
    $controller->$actionName(...$matches);
} catch (\MyProject\Exceptions\DbException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
} catch (\MyProject\Exceptions\NotFoundException $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php', [], 404);
} catch (\MyProject\Exceptions\ActivationCodeNotFound $e) {
    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('activationCodeNotFound.php', ['error' => $e->getMessage()], 404);
}