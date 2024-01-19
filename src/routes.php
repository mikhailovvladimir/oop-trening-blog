<?php

return [
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^articles/delete/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^articles/(\d+)/comments$~' => [\MyProject\Controllers\ArticlesController::class, 'commentForm'],
    '~^articles/(\d+)/add-comment$~' => [\MyProject\Controllers\ArticlesController::class, 'addComment'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activate'],
    '~^users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
];
