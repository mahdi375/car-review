<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class Filter
{
    protected Builder $builder;

    protected array $filters = [];

    public function __construct(protected Request $request)
    {
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $name => $value) {
            $name = Str::camel($name);
            if (in_array($name, $this->filters) && method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value], fn () => ! is_null($value)));
            }
        }

        return $this->builder;
    }

    protected function castStringToBool(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
