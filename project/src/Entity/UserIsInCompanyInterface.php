<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface UserIsInCompanyInterface
{

    public function getUsers(): ?Collection;
    public function setUsers(): ?self;

    public function addUser(User $user): ?self;

    public function removeUser(User $user): ?self;
}
