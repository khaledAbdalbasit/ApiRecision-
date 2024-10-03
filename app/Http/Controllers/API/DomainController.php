<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DomainResource;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DomainController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $domains = Domain::all();
        if($domains){
            return ApiResponse::sendResponse(Response::HTTP_OK, 'Domains fetched successfully', DomainResource::collection($domains));
        }
        return ApiResponse::sendResponse(Response::HTTP_OK, 'No domains found', null);

    }
}
