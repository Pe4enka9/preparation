<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <title>Редактировать заметку</title>
</head>
<body>

<main>
    <!-- Форма для редактирования существующей заметки -->
    <form action="/notes/<?= $note['id'] ?>/edit" method="post">
        <!--
          ПУТЬ action="/notes/<?= $note['id'] ?>/edit":
          - Динамический путь: подставляется реальный ID заметки (например: /notes/5/edit)
          - Берется из routes: $app->post('/notes/{id}/edit', [NoteController::class, 'update'])
          - Этот путь обрабатывает ОБНОВЛЕНИЕ существующей заметки (метод update)
        -->

        <!--
          METHOD="post":
          - Используем POST потому что изменяем существующую запись в базе
          - POST скрывает данные и подходит для операций изменения
        -->

        <h1>Редактировать заметку</h1>

        <!-- Поле названия с предзаполненным значением -->
        <div class="field">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" placeholder="Название" value="<?= $note['name'] ?>">
            <!--
              value="<?= $note['name'] ?>" - подставляет текущее название заметки в поле
              Пользователь видит текущее значение и может его изменить
            -->
        </div>

        <!-- Поле текста с предзаполненным значением -->
        <div class="field">
            <label for="text">Текст</label>
            <textarea name="text" id="text" placeholder="Текст"><?= $note['text'] ?></textarea>
            <!--
              Текст заметки подставляется между тегами textarea
              Пользователь видит текущий текст и может его редактировать
            -->
        </div>

        <!-- Блок с кнопками действия -->
        <div class="actions">
            <!-- Кнопка отправки формы - сохраняет изменения -->
            <button type="submit" class="btn">Редактировать</button>

            <!-- Ссылка для отмены редактирования - возврат к списку -->
            <a href="/notes" class="btn delete">Отмена</a>
        </div>
    </form>
</main>

</body>
</html>