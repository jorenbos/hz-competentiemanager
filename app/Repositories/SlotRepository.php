<?php

namespace App\Repositories;

use App\Models\Slot;
use App\Util\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SlotRepository implements RepositoryInterface
{
    /**
     * @param $id
     *
     * @return Slot
     */
    public function getById($id)
    {
        return Slot::findOrFail($id);
    }

    /**
     * @return Slot[]|Collection
     */
    public function getAll()
    {
        return Slot::all();
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Slot::create($attributes);
    }

    /**
     * @param int $ids
     *
     * @return mixed
     */
    public function delete($ids)
    {
        return Slot::destroy($ids);
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
}
