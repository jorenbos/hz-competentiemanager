<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemandController extends Controller
{

    public function index()
    {
        return view('demand.index', ['calc_comp' => competency_demand_algorithm]);
    }

    private function competency_demand_algorithm()
    {
        $calculated_competencies = [];

        foreach($competencies as $competency)
        {
            $calculated_competencies[$competency.id] = 0;
        }

        foreach($students as $student)
        {
            foreach($student.todo_slots as $slot)
            {
                foreach($slot.competencies as $competency)
                {
                    $calculated_competencies[$competency.id] += (1 / $slot.competencies.length / $student.todo_slots.length);
                }
            }
        }

        return $calculated_competencies;

    }
}
