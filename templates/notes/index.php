<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <title>Заметки</title>
</head>
<body>

<main>
    <!-- ПУТЬ: /logout - берется из routes в index.php: $app->get('/logout', [LoginController::class, 'logout']) -->
    <a href="/logout" class="btn">Выйти</a>

    <h1>Заметки</h1>

    <!-- ПУТЬ: /notes/create - берется из routes в index.php: $app->get('/notes/create', [NoteController::class, 'create']) -->
    <a href="/notes/create" class="btn">Добавить</a>

    <div class="notes-wrapper">
        <?php foreach ($notes as $note) : ?>
            <!--
              ЦИКЛ: PHP перебирает массив $notes который пришел из NoteController::index()

              КАК РАБОТАЕТ ЦИКЛ:
              1. $notes - это массив всех заметок из базы данных
              2. foreach берет каждую заметку по очереди и помещает в переменную $note
              3. Для каждой заметки создается HTML-блок с ее данными
              4. Когда заметки заканчиваются - цикл завершается

              ПРИМЕР: если в базе 3 заметки, цикл выполнится 3 раза и создаст 3 блока .notes-item
            -->
            <div class="notes-item">
                <div class="title">
                    <h2><?= $note['name'] ?></h2>
                </div>

                <div class="content">
                    <p><?= $note['text'] ?></p>
                    <time datetime="<?= $note['created_at'] ?>">Создан: <?= $note['created_at'] ?></time>

                    <div class="actions">
                        <!--
                          ПУТЬ: /notes/<?= $note['id'] ?>
                          Генерируется динамически для каждой заметки:
                          - Для заметки с id=1: /notes/1
                          - Для заметки с id=5: /notes/5
                          Соответствует route: $app->get('/notes/{id}', [NoteController::class, 'show'])

                          КАК РАБОТАЕТ: подставляется реальный ID заметки из базы данных
                        -->
                        <a href="/notes/<?= $note['id'] ?>" class="btn">Подробнее</a>

                        <!--
                          ПУТЬ: /notes/<?= $note['id'] ?>/edit
                          Динамический путь для редактирования:
                          - Для заметки с id=1: /notes/1/edit
                          Соответствует route: $app->get('/notes/{id}/edit', [NoteController::class, 'edit'])
                        -->
                        <a href="/notes/<?= $note['id'] ?>/edit" class="btn">Изменить</a>

                        <!--
                          ПУТЬ: /notes/<?= $note['id'] ?>/delete
                          Динамический путь для удаления:
                          - Для заметки с id=1: /notes/1/delete
                          Соответствует route: $app->get('/notes/{id}/delete', [NoteController::class, 'delete'])

                          ВНИМАНИЕ: удаление через GET небезопасно, лучше использовать POST-форму
                        -->
                        <a href="/notes/<?= $note['id'] ?>/delete" class="btn delete">Удалить</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

</body>
</html>