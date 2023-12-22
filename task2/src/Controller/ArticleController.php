<?php

declare(strict_types=1);

namespace App\Controller;

use App\AuthentificatorInterface;
use App\DataExtractor\DataExtractorInterface;
use App\Dto\CreateArticle;
use App\Request;
use App\Response;
use App\Response\ResponseTransformerInterface;
use App\Service\Article\ServiceInterface;
use App\ValidatorInterface;
use Throwable;


/**
 * На самом деле не знал на сколько далеко надо реализовывать данную задачу.
 * Сделал до контроллера, хотя бы по созданию статьи
 */
final class ArticleController
{
    private AuthentificatorInterface $authentificator;
    private DataExtractorInterface $dataExtractor;
    private ValidatorInterface $validator;
    private ServiceInterface $service;
    private ResponseTransformerInterface $responseTransformer;

    public function __construct(
        AuthentificatorInterface $authentificator,
        DataExtractorInterface $dataExtractor,
        ValidatorInterface $validator,
        ServiceInterface $service,
        ResponseTransformerInterface $responseTransformer
    ) {
        $this->authentificator = $authentificator;
        $this->dataExtractor = $dataExtractor;
        $this->validator = $validator;
        $this->service = $service;
        $this->responseTransformer = $responseTransformer;
    }

    public function create(Request $request)
    {
        try {
            $user = $this->authentificator->getAuthUser();

            /**
             * @var CreateArticle $createArticeDto
             */
            $createArticeDto = $this->dataExtractor->extract($request);
            $createArticeDto->setUser($user);

            $this->validator->validate($createArticeDto);

            $this->service->create($createArticeDto);
        } catch (Throwable $exception) {
            return $this->responseTransformer->transform($exception);
        }

        return new Response();
    }
}