<?php

namespace Src\Controllers;

use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Контроллер для работы с заметками (CRUD операции)
 * Позволяет создавать, просматривать, редактировать и удалять заметки
 */
class NoteController extends Controller
{
    /**
     * Показывает список всех заметок ТЕКУЩЕГО пользователя
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        // Ищем только заметки, принадлежащие текущему пользователю
        $notes = ORM::forTable('notes')->where('user_id', $_SESSION['user_id'])->findMany();

        // Показываем страницу со списком заметок (только своих)
        return $this->renderer->render($response, '/notes/index.php', ['notes' => $notes]);
    }

    /**
     * Показывает форму для создания новой заметки
     */
    public function create(RequestInterface $request, ResponseInterface $response)
    {
        // Просто показываем форму с полями "название" и "текст"
        return $this->renderer->render($response, '/notes/create.php');
    }

    /**
     * Сохраняет новую заметку в базу данных
     */
    public function store(RequestInterface $request, ResponseInterface $response)
    {
        // Получаем данные из формы
        $name = $request->getParsedBody()['name'];
        $text = $request->getParsedBody()['text'];

        // Создаем новую заметку и привязываем к текущему пользователю
        ORM::forTable('notes')->create([
            'name' => $name,                      // Название заметки
            'text' => $text,                      // Текст заметки
            'user_id' => $_SESSION['user_id'],    // ID пользователя (чтобы знать, чья это заметка)
        ])->save();

        // После сохранения возвращаемся к списку заметок
        return $response->withStatus(302)->withHeader('Location', '/notes');
    }

    /**
     * Показывает одну конкретную заметку
     */
    public function show(RequestInterface $request, ResponseInterface $response, array $args)
    {
        // Получаем ID заметки из URL (например, /notes/123)
        $id = $args['id'];

        // Находим заметку в базе по ID
        $note = ORM::forTable('notes')->findOne($id);

        // Показываем страницу с полным содержанием заметки
        return $this->renderer->render($response, '/notes/show.php', ['note' => $note]);
    }

    /**
     * Показывает форму для редактирования существующей заметки
     */
    public function edit(RequestInterface $request, ResponseInterface $response, array $args)
    {
        // Получаем ID заметки из URL
        $id = $args['id'];

        // Находим заметку для редактирования
        $note = ORM::forTable('notes')->findOne($id);

        // Показываем форму редактирования с заполненными данными
        return $this->renderer->render($response, '/notes/edit.php', ['note' => $note]);
    }

    /**
     * Обновляет существующую заметку в базе данных
     */
    public function update(RequestInterface $request, ResponseInterface $response, array $args)
    {
        // Получаем новые данные из формы
        $name = $request->getParsedBody()['name'];
        $text = $request->getParsedBody()['text'];
        $id = $args['id'];

        // Находим заметку и обновляем ее данные
        ORM::forTable('notes')->findOne($id)->set([
            'name' => $name,  // Новое название
            'text' => $text,  // Новый текст
        ])->save();

        // Возвращаемся к списку заметок
        return $response->withStatus(302)->withHeader('Location', '/notes');
    }

    /**
     * Удаляет заметку из базы данных
     */
    public function delete(RequestInterface $request, ResponseInterface $response, array $args)
    {
        // Получаем ID заметки для удаления
        $id = $args['id'];

        // Находим и удаляем заметку
        ORM::forTable('notes')->findOne($id)->delete();

        // Возвращаемся к списку заметок
        return $response->withStatus(302)->withHeader('Location', '/notes');
    }
}