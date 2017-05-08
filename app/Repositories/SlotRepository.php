<?php

namespace App\Repositories;

use App\Models\Slot;
use App\Util\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SlotRepository implements RepositoryInterface
{
    /**
      * @var Slot
      */
     private $slots;

    public function __construct(Slot $slots)
    {
        $this->slots = $slots;
    }

    /**
     * @param $id
     *
     * @return Slot
     */
    public function getById($id)
    {
        return $this->slots->findOrFail($id);
    }

    /**
     * @return Slot[]|Collection
     */
    public function getAll()
    {
        return $this->slots->all();
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->slots->create($attributes);
    }

    /**
     * @param int $ids
     *
     * @return mixed
     */
    public function delete($ids)
    {
        return $this->slots->destroy($ids);
    }

    /**
     * @return Slot[]|Collection
     */
    public function getAllWithRelations()
    {
        $slots = $this->getAll();
        foreach ($slots as $slot) {
            if ($slot->competencies()) {
                foreach ($slot->competencies as $competency) {
                }
            }
        }

        return $slots;
    }

    /**
     * @return Slot[]|Collection
     */
    public function getAllPropedeuse()
    {
        return $this->slots->where('phase', '=', 0)->get();
    }
}
