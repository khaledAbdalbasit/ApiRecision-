<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DistrictController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $districts = District::where('city_id', $request->input('city'))->get();
        if($districts){
            return ApiResponse::sendResponse(
                Response::HTTP_OK,
                'Districts retreved successfully',
                DistrictResource::collection($districts)
            );
        }
        return ApiResponse::sendResponse(Response::HTTP_OK, 'Districts not found', null);
    }
}
