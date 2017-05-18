<?php

namespace App\Util;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{

    /**
     * @var Model
     */
     protected $model;

     public function __construct(Model $model)
     {
         $this->model = $model;
     }

     /**
      * Retrieves one model from Database
      *
      * @param int $id
      *
      * @return Model
      */
     public function getById($id)
     {
         return $this->model->findOrFail($id);
     }

     /**
      * Retrieves all models of type from Databse
      *
      * @return Model | Collection[]
      */
     public function getAll()
     {
         return $this->model->all();
     }

     /**
      * Creates model and adds it to database
      *
      * @param array $attributes
      *
      * @return mixed
      */
     public function create(array $attributes)
     {
         return $this->model->create($attributes);
     }

     /**
      * Deletes entry from database
      *
      * @param int $id
      *
      * @return mixed
      */
     public function delete($id)
     {
         return $this->model->destroy($id);
     }

     /**
      * Updates entry in database
      *
      * @param array $attributes
      * @param int $id
      *
      * @return mixed
      */
      public function update(array $attributes, $id)
      {
          return $this->model->findOrFail($id)->update($attributes);
      }

}
