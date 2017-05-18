<?php

namespace App\Repositories;

use App\Models\Timetable;
use App\Util\RepositoryInterface;
use Carbon\Carbon;
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
        return $this->timetable->findOrFail($id);
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

      /**
       * @return Timetable[]|Collection
       */
      public function getCurrent()
      {
          $currentDate = Carbon::now();

          return $this->timetable->where([
              ['starting_date', '>=', $currentDate],
              ['end_date', '<=', $currentDate],
          ])->get();
      }

      /**
       * @return Timetable
       */
      public function getNext()
      {
          $currentDate = Carbon::now();
          $futureTimetables = $this->timetable->where('starting_date', '>=', $currentDate)->get();
          $futureTimetables = $futureTimetables->sortBy('starting_date');
          $keysFutureTimetables = $futureTimetables->keys();

          return $futureTimetables[$keysFutureTimetables[0]];
      }
}
