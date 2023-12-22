<?php

declare(strict_types=1);

namespace App\DataExtractor;

use App\Request;

/**
 * Интерфейс на преобразование данных с запроса на какую нибудь дто-ошку.
 */
interface DataExtractorInterface
{
    /**
     * Тип возвращаемого значения специально не указана, так как можно использовать
     * данный интерфейс под различные апи и дто-ошку могут быть разными
     */
    public function extract(Request $request);
}