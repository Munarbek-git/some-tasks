<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Article;

interface ArticleRepositoryInterface
{
    public function getById(int $id): Article;
}