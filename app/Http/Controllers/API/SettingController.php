<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Http\Response;

class SettingController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request,$id)
    {
        $sittings = Setting::find($id);
        if ($sittings) {
            return ApiResponse::sendResponse(
                Response::HTTP_OK,
                'Sittings retreved succesfly',
                new SettingResource($sittings)
            );
        }
        return ApiResponse::sendResponse(Response::HTTP_OK, 'Sittings not found', null);
    }
}
