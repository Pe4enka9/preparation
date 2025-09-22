<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <title>Создать заметку</title>
</head>
<body>

<main>
    <!-- Форма для создания новой заметки -->
    <form action="/notes/create" method="post">
        <!--
          ПУТЬ action="/notes/create":
          - Берется из routes в index.php: $app->post('/notes/create', [NoteController::class, 'store'])
          - Этот путь обрабатывает СОХРАНЕНИЕ новой заметки (метод store)
          - Обратите внимание: для показа формы используется GET /notes/create, а для сохранения - POST /notes/create
        -->

        <!--
          METHOD="post":
          - Используем POST потому что создаем новую запись в базе данных
          - GET не подходит: данные заметки могут быть большими, и GET показывает их в URL
          - Семантически POST используется для создания новых ресурсов
        -->

        <h1>Создать заметку</h1>

        <!-- Поле для названия заметки -->
        <div class="field">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" placeholder="Название" required>
            <!-- required - браузер не даст отправить форму с пустым полем -->
        </div>

        <!-- Поле для текста заметки -->
        <div class="field">
            <label for="text">Текст</label>
            <textarea name="text" id="text" placeholder="Текст" required></textarea>
            <!-- textarea позволяет вводить многострочный текст -->
        </div>

        <!-- Блок с кнопками действия -->
        <div class="actions">
            <!-- Кнопка отправки формы - создает заметку -->
            <button type="submit" class="btn">Создать</button>

            <!--
              ПУТЬ /notes - возвращает к списку заметок
              Берется из routes: $app->get('/notes', [NoteController::class, 'index'])
              Это безопасный выход без сохранения данных
            -->
            <a href="/notes" class="btn delete">Отмена</a>
        </div>
    </form>
</main>

</body>
</html>