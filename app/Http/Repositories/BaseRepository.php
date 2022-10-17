<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * Gets the base model for the repository
     *
     * @return Model
     */
    abstract public function getModel(): Model;
}
