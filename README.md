# Установка нового проекта

1. Развернуть docker lamp образ
2. Поднять контейнеры
3. Добавить .htaccess для направления всех запросов в index.php
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```
4. Перейти в контейнер lamp-php83 docker exec -it lamp-php83 bash
5. Установить зависимости:
```bash
composer require slim/slim
composer require slim/psr7
composer require slim/php-view
composer require php-di/slim-bridge
composer require j4mie/idiorm
```
6. В composer.json добавить секцию автозагрузки:
```json
"autoload": {
    "psr-4": {
        "Src\\": "src/"
    }
}
```
7. Запустить команду composer du
8. В файле index.php запустить фреймворк
```php
<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

$container->set(PhpRenderer::class, function () {
    return new PhpRenderer(__DIR__ . '/templates');
});

ORM::configure('mysql:host=database;dbname=docker');
ORM::configure('username', 'root');
ORM::configure('password', 'tiger');

$app->get('/', [HomeController::class, 'index']);

$app->run();
```
## Middleware
1. Создать папку Middleware в src
2. Создать AuthMiddleware:
```php
<?php

namespace Src\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware
{
    public function __construct(
        protected ResponseFactoryInterface $responseFactory
    )
    {
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        if (!isset($_SESSION['user_id'])) {
            $response = $this->responseFactory->createResponse();

            return $response->withStatus(302)->withHeader('Location', '/login');
        }

        return $handler->handle($request);
    }
}
```
3. В index.php добавить:
```php
$app->group('/', function () use ($app) {
    $app->get('/', [HomeController::class, 'index']); // Пример
    // Остальные маршруты, для которых нужна авторизация
})->add(new AuthMiddleware($container->get(ResponseFactory::class)));
```