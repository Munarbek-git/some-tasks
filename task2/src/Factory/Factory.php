<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\CreateArticle;
use App\Entity\Article;

final class Factory implements FactoryInterface
{
    /**
     * В данном кейсе процесс создания простая, но может содержать более сложную бизнес логику.
     * Классический паттерн фабричный немного другой, здесь более упрощенный.
     * Может быть даже назвал бы просто Assembler
     */
    public function createArticleEntity(CreateArticle $createArticleDto)
    {
        return
            (new Article())
                ->setTitle($createArticleDto->getTitle())
                ->setContent($createArticleDto->getContent())
                ->setAuthor($createArticleDto->getUser())
            ;
    }
}