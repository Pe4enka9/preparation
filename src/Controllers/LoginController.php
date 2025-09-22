<?php

namespace Src\Controllers;

use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Контроллер для работы с входом и выходом пользователей
 */
class LoginController extends Controller
{
    /**
     * Показывает страницу входа в систему
     */
    public function loginPage(RequestInterface $request, ResponseInterface $response)
    {
        // Просто показываем HTML-форму для входа
        return $this->renderer->render($response, 'auth/login.php');
    }

    /**
     * Обрабатывает данные из формы входа
     */
    public function login(RequestInterface $request, ResponseInterface $response)
    {
        // Получаем логин и пароль из формы
        $login = $request->getParsedBody()['login'];
        $password = $request->getParsedBody()['password'];

        // Ищем пользователя в базе данных по логину
        $user = ORM::forTable('users')->where('login', $login)->findOne();

        // Если пользователь не найден - возвращаем на страницу входа
        if (!$user) {
            return $response->withStatus(302)->withHeader('Location', '/login');
        }

        // Если пароль не совпадает - возвращаем на страницу входа
        if ($user['password'] !== $password) {
            return $response->withStatus(302)->withHeader('Location', '/login');
        }

        // Если все верно - сохраняем ID пользователя в сессии (это значит "пользователь вошел")
        $_SESSION['user_id'] = $user['id'];

        // Перенаправляем на страницу с заметками
        return $response->withStatus(302)->withHeader('Location', '/notes');
    }

    /**
     * Выход пользователя из системы
     */
    public function logout(RequestInterface $request, ResponseInterface $response)
    {
        // Удаляем ID пользователя из сессии (это значит "пользователь вышел")
        unset($_SESSION['user_id']);

        // Перенаправляем обратно на страницу входа
        return $response->withStatus(302)->withHeader('Location', '/login');
    }
}