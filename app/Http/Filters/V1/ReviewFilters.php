<?php

namespace App\Http\Filters\V1;

use App\Http\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ReviewFilters extends Filter
{
    protected array $filters = ['car', 'sort', 'minStar'];

    protected function car(int $value): Builder
    {
        return $this->builder->where('car_id', $value);
    }

    protected function minStar(int $value): Builder
    {
        return $this->builder->where('star', '>=', $value);
    }

    protected function sort(string $value): Builder
    {
        return $this->builder->orderBy($value, request('order', 'asc'));
    }
}
