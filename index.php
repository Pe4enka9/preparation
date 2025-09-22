<?php

// Подключаем необходимые классы и библиотеки
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Views\PhpRenderer;
use Src\Controllers\LoginController;
use Src\Controllers\NoteController;
use Src\Controllers\RegisterController;
use Src\Middleware\AuthMiddleware;

// Начинаем сессию для работы с авторизацией пользователей
session_start();

// Подключаем автозагрузчик Composer (автоматически загружает все зависимости)
require __DIR__ . '/vendor/autoload.php';

// Создаем контейнер для зависимостей (удобное управление компонентами приложения)
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

// Настраиваем шаблонизатор - указываем папку где лежат HTML-шаблоны
$container->set(PhpRenderer::class, function () {
    return new PhpRenderer(__DIR__ . '/templates');
});

// Подключаем базу данных MySQL
ORM::configure('mysql:host=MySQL-8.4;dbname=slim;charset=utf8mb4');
ORM::configure('username', 'root');
ORM::configure('password', '');

// Маршруты доступные всем пользователям (без авторизации)
$app->get('/register', [RegisterController::class, 'registerPage']); // Страница регистрации
$app->post('/auth/register', [RegisterController::class, 'register']); // Обработка формы регистрации
$app->get('/login', [LoginController::class, 'loginPage']); // Страница входа
$app->post('/auth/login', [LoginController::class, 'login']); // Обработка формы входа
$app->get('/logout', [LoginController::class, 'logout']); // Выход из системы

// Группа защищенных маршрутов - требуют авторизации
$app->group('/', function () use ($app) {
    // Все маршруты работы с заметками
    $app->get('/notes', [NoteController::class, 'index']); // Список всех заметок
    $app->get('/notes/create', [NoteController::class, 'create']); // Форма создания заметки
    $app->post('/notes/create', [NoteController::class, 'store']); // Сохранение новой заметки
    $app->get('/notes/{id}', [NoteController::class, 'show']); // Просмотр одной заметки
    $app->get('/notes/{id}/edit', [NoteController::class, 'edit']); // Форма редактирования заметки
    $app->post('/notes/{id}/edit', [NoteController::class, 'update']); // Обновление заметки
    $app->get('/notes/{id}/delete', [NoteController::class, 'delete']); // Удаление заметки
})->add(new AuthMiddleware($container->get(ResponseFactory::class))); // Добавляем проверку авторизации

// Запускаем приложение
$app->run();