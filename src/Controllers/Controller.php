<?php

namespace Src\Controllers;

use Slim\Views\PhpRenderer;

/**
 * Базовый контроллер для всех контроллеров приложения.
 * Содержит общую логику, которую наследуют все остальные контроллеры.
 */
class Controller
{
    /**
     * Конструктор базового контроллера.
     *
     * @param PhpRenderer $renderer Объект для работы с HTML-шаблонами
     *                              (автоматически передается через контейнер зависимостей)
     */
    public function __construct(
        protected PhpRenderer $renderer  // Сохраняем шаблонизатор для использования в дочерних контроллерах
    )
    {
    }
}