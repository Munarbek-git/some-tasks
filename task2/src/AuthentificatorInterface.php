<?php

declare(strict_types=1);

namespace App;

use App\Entity\User;


/**
 * Предоставляют данные по аутентифицированному юзеру, обычно их предоставляют фреймворки
 */
interface AuthentificatorInterface
{
    public function getAuthUser(): User;
}