<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

abstract class Observer
{
    /**
     * Creates a new record using the given model instance.
     *
     * @param mixed $model The model instance to be used for creating a new record.
     */
    abstract public function creating($model);

    /**
     * Performs actions when a new model is created.
     *
     * @param Model $model The model that has been created
     */
    abstract public function created($model);

    /**
     * Updates the given model in the system.
     *
     * @param mixed $model The model to be updated
     */
    abstract public function updating($model);

    /**
     * Updates the specified model.
     *
     * @param mixed $model The model to be updated.
     */
    abstract public function updated($model);

    /**
     * Deletes the specified model.
     *
     * @param mixed $model The model to be deleted.
     */
    abstract public function deleting($model);

    /**
     * Deletes the specified model.
     *
     * @param mixed $model The model to be deleted.
     */
    abstract public function deleted($model);

}
