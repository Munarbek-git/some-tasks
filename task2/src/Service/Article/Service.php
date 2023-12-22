<?php

declare(strict_types=1);

namespace App\Service\Article;

use App\Dto\CreateArticle;
use App\Entity\User;
use App\EntityManagerInterface;
use App\Factory\FactoryInterface;
use App\Repository\ArticleRepositoryInterface;


/**
 * Функицональность реализована здесь.
 * Этот сервис можно юзать и в контроллере/команде или еще где нибудь.
 * Для кейса создание статьи написал контроллер для примера, а остальные будут без реализации
 */
final class Service implements ServiceInterface
{
    private FactoryInterface $factory;
    private EntityManagerInterface $entityManager;
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(
        FactoryInterface $factory,
        EntityManagerInterface $entityManager,
        ArticleRepositoryInterface $articleRepository
    ) {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param CreateArticle $createArticleDto
     * @return void
     */
    public function create(CreateArticle $createArticleDto)
    {
        $artircle = $this->factory->createArticleEntity($createArticleDto);

        $this->entityManager->save($artircle);
    }

    public function otherCase()
    {
        $article = $this->articleRepository->getById(1);

        /**
         * Возможность получить автора статьи;
         */
        $author = $article->getAuthor();

        /**
         * Возможность получить все статьи конкретного пользователя;
         */
        $allUserArticles = $author->getArtircls();

        /**
         * возможность сменить автора статьи.
         */
        $otherAuthor = new User();
        $article->setAuthor($otherAuthor);
    }


}