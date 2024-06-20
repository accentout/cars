<?php

namespace App\Repositories;

use App\Models\CarModel;
use App\Models\User;
use App\Repositories\Contracts\CarRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CarRepository implements CarRepositoryInterface
{
    /**
     * Получить все машины по пользователю.
     *
     * @param User $user
     * @return Collection|array
     */
    public function getAllByUser(User $user): Collection|array
    {
        $position = $user->position;

        $categoriesIds = $position->carComfortCategories->pluck('id');

        return CarModel::whereHas('carComfortCategory', function ($query) use ($categoriesIds) {
            $query->whereIn('car_comfort_categories.id', $categoriesIds);
        })
            ->with('cars')
            ->get()
            ->flatMap(function ($carModel) {
                return $carModel->cars;
            });
    }

    /**
     * Получить все незабронированные машины.
     *
     * @param Collection $cars
     * @param array $data
     * @return Builder
     */
    public function getAllNotBooked(Collection $cars, array $data): Builder
    {
        $startTime = $data['startTime'];
        $endTime = $data['endTime'];

        return $cars->whereDoesntHave('carBookings', function ($query) use ($startTime, $endTime) {
            $query->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            });
        });
    }

    /**
     * Получить машины по модели.
     *
     * @param Builder $query
     * @param int $carModelId
     * @return Builder
     */
    public function getAllByCarModel(Builder $query, int $carModelId): Builder
    {
        return $query->where('car_model_id', $carModelId);
    }

    /**
     * Получить машины по категории комфорта.
     *
     * @param Builder $query
     * @param int $carComfortCategoryId
     * @return Builder
     */
    public function getAllByCarComfortCategory(Builder $query, int $carComfortCategoryId): Builder
    {
        return $query->whereHas('carModel', function ($query) use ($carComfortCategoryId) {
            $query->where('car_comfort_category_id', $carComfortCategoryId);
        });
    }
}
