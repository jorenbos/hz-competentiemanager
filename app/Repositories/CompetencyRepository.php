<?php

namespace App\Repositories;

use App\Models\Competency;
use App\Util\Constants;
use App\Util\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CompetencyRepository implements RepositoryInterface
{
    /**
     * @var Competency
     */
    private $competencies;

    /**
     * Constrcutor.
     */
    public function __construct(Competency $competencies)
    {
        $this->competencies = $competencies;
    }

    /**
     * Returns competency with given id from database.
     *
     * @param  $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return $this->competencies->findOrFail($id);
    }

//end getById()

    /**
     * Returns all competencies in the database.
     *
     * @return Collection|Competency[]
     */
    public function getAll()
    {
        return $this->competencies->get();
    }

//end getAll()

    /**
     * Creates a new competency and stores it in the database.
     *
     * @param array $attributes
     *
     * @return Competency
     */
    public function create(array $attributes)
    {
        return $this->competencies->create($attributes);
    }

//end create()

    /**
     * Removes competencies with given ids from the database.
     *
     * @param int $ids
     *
     * @return mixed
     */
    public function delete($ids)
    {
        return $this->competencies->destroy($ids);
    }

//end delete()

    /**
     * Updates given fields of the repository with the given id.
     *
     * @param  array
     * @param int $id
     *
     * @return Competency
     */
    public function update($data, $id)
    {
        $result = $this->competencies->findOrFail($id)->update($data);
        $this->competencies->findOrFail($id)->save();

        return $result;
    }

    /**
     * Filters competencies on whether or not they are allowed to be picked by the Algorithm.
     *
     * @param Competency |Collection[] (optional) $competencies
     *
     * @return Collection[]
     */
    public function filterAllowedForAlgorithm($competencies = null)
    {
        if ($competencies === null) {
            $competencies = $this->getAll();
        }

        return $competencies->where('pickable_for_algorithm', Constants::COMPETENCY_ALGORITHIM_ALLOWED_TRUE);
    }
}
