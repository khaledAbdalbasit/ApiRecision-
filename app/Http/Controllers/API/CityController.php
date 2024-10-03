<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $cities = City::all();
        if($cities){
            return ApiResponse::sendResponse(Response::HTTP_OK,'Cities retreved successfully',CityResource::collection($cities));
        }
        return ApiResponse::sendResponse(Response::HTTP_OK,'Cities not found',null);
    }
}
