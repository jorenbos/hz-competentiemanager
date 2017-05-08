<?php

namespace App\Repositories;

use App\Model\Timetable;
use App\Util\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TimetableRepository implements RepositoryInterface
{
    /**
     * @var Timetable
     */
    private $timetable;

    public function __construct(Timetable $timetable)
    {
        $this->timetable = $timetable;
    }

    /**
     * @return Timetable
     */
    public function getById($id)
    {
        return $this->timetable->findOrFail($if);
    }

    /**
     * @return Timetable[]|Collection
     */
     public function getAll()
     {
         return $this->timetable->all();
     }

     /**
      * @param array $attributes
      *
      * @return mixed
      */
      public function create(array $attributes)
      {
          return $this->timetable->create($attributes);
      }

      /**
       * @param int $ids
       *
       * @return mixed
       */
      public function delete($ids)
      {
          return $this->timetable->destroy($ids);
      }
}
