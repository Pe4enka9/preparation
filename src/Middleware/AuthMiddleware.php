<?php

namespace Src\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Промежуточное ПО (Middleware) для проверки авторизации пользователя
 *
 * Это "страж", который проверяет, вошел ли пользователь в систему,
 * прежде чем пустить его к защищенным страницам.
 */
class AuthMiddleware
{
    /**
     * Конструктор middleware
     *
     * @param ResponseFactoryInterface $responseFactory Фабрика для создания HTTP-ответов
     *                                                  (нужна для перенаправления неавторизованных пользователей)
     */
    public function __construct(
        protected ResponseFactoryInterface $responseFactory
    )
    {
    }

    /**
     * Основной метод, который вызывается для каждого запроса к защищенным страницам
     *
     * @param ServerRequestInterface $request Запрос от пользователя
     * @param RequestHandlerInterface $handler Обработчик запроса (следующий middleware или контроллер)
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        // Проверяем, авторизован ли пользователь (есть ли его ID в сессии)
        if (!isset($_SESSION['user_id'])) {
            // Если пользователь НЕ авторизован - создаем ответ с перенаправлением
            $response = $this->responseFactory->createResponse();

            // Перенаправляем на страницу входа с кодом 302 (временное перенаправление)
            return $response->withStatus(302)->withHeader('Location', '/login');
        }

        // Если пользователь авторизован - пропускаем его дальше к запрашиваемой странице
        return $handler->handle($request);
    }
}