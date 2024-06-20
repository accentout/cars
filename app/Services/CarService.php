<?php

namespace App\Services;

use App\Repositories\Contracts\CarRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CarService
{
    protected CarRepositoryInterface $carRepository;

    public function __construct(CarRepositoryInterface $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    /**
     * Получить все свободные машины.
     *
     * @param array $data
     * @return Builder
     */
    public function getAvailableCarsByAuthUser(array $data): Builder
    {
        $user = Auth::user();

        $cars = $this->carRepository->getAllByUser($user);

        return $this->carRepository->getAllNotBooked($cars, $data);
    }

    /**
     * Получить машины по модели.
     *
     * @param Builder $query
     * @param int $carModelId
     * @return Builder
     */
    public function getCarsByCarModel(Builder $query, int $carModelId): Builder
    {
        return $this->carRepository->getAllByCarModel($query, $carModelId);
    }

    /**
     * Получить машины по категории комфорта.
     *
     * @param Builder $query
     * @param int $carComfortCategoryId
     * @return Builder
     */
    public function getCarsByCarComfortCategory(Builder $query, int $carComfortCategoryId): Builder
    {
        return $this->carRepository->getAllByCarComfortCategory($query, $carComfortCategoryId);
    }
}
