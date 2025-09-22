<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <!--
      ДИНАМИЧЕСКИЙ ЗАГОЛОВОК: подставляется название заметки в title страницы
      Например: "Покупки" вместо "Заметка"
    -->
    <title><?= $note['name'] ?></title>
</head>
<body>

<main>
    <!--
      ПУТЬ /notes - возврат к списку всех заметок
      Берется из routes: $app->get('/notes', [NoteController::class, 'index'])
    -->
    <a href="/notes" class="btn">Назад</a>

    <!--
      ЗАГОЛОВОК ЗАМЕТКИ: показываем название и дату создания
      Например: "Покупки (2024-01-15 10:30:00)"
    -->
    <h1><?= $note['name'] ?> (<?= $note['created_at'] ?>)</h1>

    <!-- ТЕКСТ ЗАМЕТКИ -->
    <p><?= $note['text'] ?></p>

    <!-- Блок кнопок управления заметкой -->
    <div class="actions">
        <!--
          ПУТЬ /notes/<?= $note['id'] ?>/edit - редактирование этой заметки
          Берется из routes: $app->get('/notes/{id}/edit', [NoteController::class, 'edit'])
          Динамический путь: для заметки с ID=5 будет /notes/5/edit
        -->
        <a href="/notes/<?= $note['id'] ?>/edit" class="btn">Изменить</a>

        <!--
          ПУТЬ /notes/<?= $note['id'] ?>/delete - удаление этой заметки
          Берется из routes: $app->get('/notes/{id}/delete', [NoteController::class, 'delete'])
          Динамический путь: для заметки с ID=5 будет /notes/5/delete
        -->
        <a href="/notes/<?= $note['id'] ?>/delete" class="btn delete">Удалить</a>
    </div>
</main>

</body>
</html>