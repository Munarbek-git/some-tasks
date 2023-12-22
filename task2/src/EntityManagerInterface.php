<?php

declare(strict_types=1);

namespace App;


/**
 * Интерфейс для задачи, обычно их предоставляют фреймворки
 */
interface EntityManagerInterface
{
    public function save($entity): void;
}