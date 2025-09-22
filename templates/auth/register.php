<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <title>Регистрация</title>
</head>
<body>

<main>
    <!-- Форма для создания нового аккаунта -->
    <form action="/auth/register" method="post">
        <!--
          action="/auth/register" - данные формы будут обрабатываться
          методом register в RegisterController (маршрут из index.php)
        -->

        <!--
          method="post" - используется потому что мы создаем новую запись в базе данных
          (пользователя). POST подходит для операций создания, обновления, удаления данных.
          Также скрывает конфиденциальные данные (логин/пароль) от посторонних глаз.
        -->

        <h1>Регистрация</h1>

        <!-- Поле для ввода логина (будет сохранен в базе данных) -->
        <div class="field">
            <label for="login">Логин</label>
            <input type="text" name="login" id="login" placeholder="Логин" required>
            <!-- required - обязательное поле, браузер проверит перед отправкой -->
        </div>

        <!-- Поле для ввода пароля (будет сохранен в базе данных) -->
        <div class="field">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Пароль" required>
            <!-- type="password" скрывает ввод для безопасности -->
        </div>

        <!-- Кнопка для отправки данных и создания аккаунта -->
        <button type="submit" class="btn">Зарегистрироваться</button>

        <!-- Ссылка для тех, у кого уже есть аккаунт -->
        <a href="/login">Вход</a>
    </form>
</main>

</body>
</html>