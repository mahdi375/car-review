<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;

class CarPolicy
{
    public function update(User $user, Car $car): bool
    {
        return $this->userHasCar($user, $car);
    }

    public function delete(User $user, Car $car): bool
    {
        return $this->userHasCar($user, $car);
    }

    private function userHasCar(User $user, Car $car): bool
    {
        return $user->is($car->owner);
    }
}
