<?php

namespace Domain\Auth\Contracts;

use Domain\Auth\DTOs\NewUser;

interface RegisterNewUserContract
{
    public function __invoke(NewUser $dto);
}
