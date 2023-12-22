<?php

declare(strict_types=1);

namespace App;

interface ValidatorInterface
{
    /**
     * Выбрасывает исключение при ошибке валидации
     */
    public function validate($object): void;
}