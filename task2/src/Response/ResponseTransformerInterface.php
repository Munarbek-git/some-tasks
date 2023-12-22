<?php

declare(strict_types=1);

namespace App\Response;

use App\Response;
use Throwable;

interface ResponseTransformerInterface
{
    public function transform(Throwable $throwable): Response;
}