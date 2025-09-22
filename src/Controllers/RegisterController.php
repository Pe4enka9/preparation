<?php

namespace Src\Controllers;

use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Контроллер для регистрации новых пользователей
 */
class RegisterController extends Controller
{
    /**
     * Показывает страницу регистрации
     */
    public function registerPage(RequestInterface $request, ResponseInterface $response)
    {
        // Показываем форму с полями "логин" и "пароль"
        return $this->renderer->render($response, 'auth/register.php');
    }

    /**
     * Обрабатывает данные из формы регистрации
     */
    public function register(RequestInterface $request, ResponseInterface $response)
    {
        // Получаем логин и пароль из формы
        $login = $request->getParsedBody()['login'];
        $password = $request->getParsedBody()['password'];

        // Создаем нового пользователя в базе данных
        $user = ORM::forTable('users')->create([
            'login' => $login,
            'password' => $password,  // Пароль сохраняется как есть (без шифрования)
        ]);
        $user->save();

        // Автоматически входим под новым пользователем (сохраняем его ID в сессии)
        $_SESSION['user_id'] = $user['id'];

        // После регистрации сразу перенаправляем в личный кабинет с заметками
        return $response->withStatus(302)->withHeader('Location', '/notes');
    }
}