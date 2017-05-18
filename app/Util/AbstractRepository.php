<?php

namespace App\Util;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    /**
      * @var Model
      */
     protected $model;

     /**
      * @var array
      */
     protected $columns = ['*'];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

     /**
      * Retrieves one model from Database.
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
      * Retrieves all models of type from Databse.
      *
      * @return Model | Collection[]
      */
     public function getAll($columns = null)
     {
         if ($columns == null) {
             $columns = $this->columns;
         }
         return $this->model->all($columns);
     }

     /**
      * Creates model and adds it to database.
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
      * Deletes entry from database.
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
       * Updates entry in database.
       *
       * @param array $attributes
       * @param int   $id
       *
       * @return mixed
       */
      public function update(array $attributes, $id)
      {
          return $this->model->findOrFail($id)->update($attributes);
      }

      /**
       * Sets columns to be retrieved.
       *
       * @param array $columns
       *
       * @return AbstractRepository
       */
      public function setColumns(array $columns)
      {
          $this->columns = $columns;

          return $this;
      }

      /**
       * Magic method to allow calls directly to model.
       * Mostly because i wanted to use a magic method.
       *
       * @return mixed
       */
      public function __call($method, $parameters)
      {
          if(method_exists($this->model, $method)) {
              return call_user_func_array(array($this->location, $method), $parameters);
          }
      }
}
