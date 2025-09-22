<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <title>Вход</title>
</head>
<body>

<main>
    <!-- Форма для входа в систему -->
    <form action="/auth/login" method="post">
        <!--
          action="/auth/login" - указывает, что данные формы будут обрабатываться
          методом login в LoginController (маршрут который мы настроили в index.php)
        -->

        <!--
          method="post" - используется потому что мы отправляем конфиденциальные данные (логин/пароль).
          POST скрывает данные в теле запроса (не видно в адресной строке) и безопаснее для передачи паролей.
          GET бы сделал URL вида: /auth/login?login=user&password=123 (это небезопасно!)
        -->

        <h1>Вход</h1>

        <!-- Поле для ввода логина -->
        <div class="field">
            <label for="login">Логин</label>
            <input type="text" name="login" id="login" placeholder="Логин" required>
            <!-- required - браузер не даст отправить форму с пустым полем -->
        </div>

        <!-- Поле для ввода пароля -->
        <div class="field">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Пароль" required>
            <!-- type="password" скрывает ввод звездочками -->
        </div>

        <!-- Кнопка для отправки формы -->
        <button type="submit" class="btn">Войти</button>

        <!-- Ссылка на страницу регистрации (для новых пользователей) -->
        <a href="/register">Регистрация</a>
    </form>
</main>

</body>
</html>