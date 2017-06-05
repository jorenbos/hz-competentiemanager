<?php

namespace App\Repositories;

use Rinvex\Repository\Contracts\CacheableContract;
use Rinvex\Repository\Contracts\RepositoryContract;

interface SlotRepositoryContract extends RepositoryContract, CacheableContract
{
    /**
     * @return Slot[]|Collection
     */
    public function findAllPropedeuseSlots();
}
