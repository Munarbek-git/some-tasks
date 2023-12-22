<?php

declare(strict_types=1);

namespace App\Service\Article;

use App\Dto\CreateArticle;

interface ServiceInterface
{
    public function create(CreateArticle $createArticleDto);
}