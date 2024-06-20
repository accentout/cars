<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface CarRepositoryInterface
{
    /**
     * Получить все машины по пользователю.
     *
     * @param User $user
     * @return Collection|array
     */
    public function getAllByUser(User $user): Collection|array;

    /**
     * Получить все незабронированные машины.
     *
     * @param Collection $cars
     * @param array $data
     * @return Builder
     */
    public function getAllNotBooked(Collection $cars, array $data): Builder;

    /**
     * Получить машины по модели.
     *
     * @param Builder $query
     * @param int $carModelId
     * @return Builder
     */
    public function getAllByCarModel(Builder $query, int $carModelId): Builder;

    /**
     * Получить машины по категории комфорта.
     *
     * @param Builder $query
     * @param int $carComfortCategoryId
     * @return Builder
     */
    public function getAllByCarComfortCategory(Builder $query, int $carComfortCategoryId): Builder;
}
