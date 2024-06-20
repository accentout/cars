<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAvailableCarsRequest;
use App\Services\CarService;

class CarController extends Controller
{
    protected CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function availableCars(GetAvailableCarsRequest $request)
    {
        $attributes = $request->validated();

        $carModelId = $attributes['car_model_id'];
        $carComfortCategoryId = $attributes['car_comfort_category_id'];
        $dataTime = [
            'start_time' => $attributes['start_time'],
            'end_time' => $attributes['end_time']
        ];

        $carsQuery = $this->carService->getAvailableCarsByAuthUser($dataTime);

        if ($carModelId) {
            $carsQuery = $this->carService->getCarsByCarModel($carsQuery, $carModelId);
        }

        if ($carComfortCategoryId) {
            $carsQuery = $this->carService->getCarsByCarComfortCategory($carsQuery, $carComfortCategoryId);
        }

        return response()->json([
            'cars' => $carsQuery->get(),
        ]);
    }
}
