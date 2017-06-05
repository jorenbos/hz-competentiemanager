<?php

namespace App\Repositories;

use App\Models\Slot;
use Illuminate\Database\Eloquent\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;

class SlotRepository extends EloquentRepository implements SlotRepositoryContract
{
    protected $repositoryId = 'hz.slots';
    protected $model = Slot::class;

    /**
     * @var string[] What relations to eager load
     */
    protected $relations = ['competencies'];

    /**
     * @return Slot[]|Collection
     */
    public function findAllPropedeuseSlots()
    {
        return $this->findAll()->where('phase', 0);
    }
}
