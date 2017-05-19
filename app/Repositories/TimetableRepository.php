<?php

namespace App\Repositories;

use App\Models\Timetable;
use App\Util\AbstractRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class TimetableRepository extends AbstractRepository
{
    public function __construct(Timetable $timetable)
    {
        parent::__construct($timetable);
    }

      /**
       * @return Timetable[]|Collection
       */
      public function getCurrent()
      {
          $currentDate = Carbon::now();

          return $this->model->where([
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
          $futureTimetables = $this->model->where('starting_date', '>=', $currentDate)->get();
          $futureTimetables = $futureTimetables->sortBy('starting_date');
          $keysFutureTimetables = $futureTimetables->keys();

          return $futureTimetables[$keysFutureTimetables[0]];
      }
}
