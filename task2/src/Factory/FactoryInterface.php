<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\CreateArticle;

interface FactoryInterface
{
    public function createArticleEntity(CreateArticle $createArticleDto);
}