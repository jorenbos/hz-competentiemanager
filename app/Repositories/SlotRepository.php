<?php

namespace App\Repositories;

use App\Models\Slot;
use App\Util\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;

class SlotRepository extends AbstractRepository
{


    public function __construct(Slot $slots)
    {
        parent::__construct($slots);
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
        return $this->model->where('phase', '=', 0)->get();
    }
}
