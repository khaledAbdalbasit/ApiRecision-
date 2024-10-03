<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdRequest;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::latest()->paginate(10);
        if (count($ads) > 0) {
            if ($ads->total() > $ads->perPage()) {
                $data = [
                    'records' => AdResource::collection($ads),
                    'pagination links' => [
                        'current page' => $ads->currentPage(),
                        'per page' => $ads->perPage(),
                        'total' => $ads->total(),
                        'links' => [
                            'first' => $ads->url(1),
                            'last' => $ads->url($ads->lastPage()),
                        ],
                    ],
                ];
            } else {
                $data = AdResource::collection($ads);
            }
            return ApiResponse::sendResponse(Response::HTTP_OK, 'Ads fetched successfully', AdResource::collection($data));
        }
        return ApiResponse::sendResponse(Response::HTTP_OK, 'No ads found', []);
    }

    public function latest()
    {
        $ads = Ad::latest()->take(10)->get();
        if (count($ads) > 0) {
            return ApiResponse::sendResponse(Response::HTTP_OK, 'Ads fetched successfully', AdResource::collection($ads));
        }
        return ApiResponse::sendResponse(Response::HTTP_OK, 'No ads found', []);
    }


    public function domain($domain_id)
    {
        $ads = Ad::where('domain_id', $domain_id)->latest()->get();
        if (count($ads) > 0) {
            return ApiResponse::sendResponse(Response::HTTP_OK, 'Ads fetched successfully', AdResource::collection($ads));
        }
        return ApiResponse::sendResponse(Response::HTTP_OK, 'No ads found', []);
    }

    public function sreach(Request $request)
    {
        $word = $request->input('word') ?? null;
        $ads = Ad::when($word != null, function ($query) use ($word) {
            $query->where('title', 'like', '%'.$word.'%');
        })->latest()->get();
        if (count($ads) > 0) {
            return ApiResponse::sendResponse(Response::HTTP_OK, 'Ads fetched successfully', AdResource::collection($ads));
        }
        return ApiResponse::sendResponse(Response::HTTP_OK, 'No ads found', []);
    }

    public function create(AdRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $record = Ad::create($data);
        if ($record) {
            return ApiResponse::sendResponse(Response::HTTP_OK, 'Ad created successfully', new AdResource($record));
        }
        return ApiResponse::sendResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to create ad');
    }

    public function update(AdRequest $request, $id)
    {
        $ad = Ad::findOrfail($id);
        if($ad->user_id != $request->user()->id){
            return ApiResponse::sendResponse(Response::HTTP_FORBIDDEN, 'You are not allowed to update this ad');
        }

        $data = $request->validated();
        $update = $ad->update($data);
        if ($update) {
            return ApiResponse::sendResponse(Response::HTTP_OK, 'Ad updated successfully', new AdResource($ad));
        }
        return ApiResponse::sendResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to create ad');
    }

    public function delete(Request $request,$id){
        $ad = AD::findOrfail($id);

        if($ad->user_id != auth()->user()->id){
            return ApiResponse::sendResponse(Response::HTTP_FORBIDDEN, 'You are not allowed to delete this ad',[]);
        }
        $delete = $ad->delete();
        if($delete){
            return ApiResponse::sendResponse(Response::HTTP_OK, 'Ad deleted successfully',[]);
        }
        return ApiResponse::sendResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to delete ad',[]);
    }

    public function myAds(){
        $ads = Ad::where('user_id',auth()->user()->id)->latest()->get();
        // if($ads->user_id != auth()->user()->id){
        //     return ApiResponse::sendResponse(Response::HTTP_FORBIDDEN, 'You are not allowed to view this ad',[]);
        // }

        if($ads){
            return ApiResponse::sendResponse(Response::HTTP_OK, 'Ads fetched successfully', AdResource::collection($ads));
        }
        return ApiResponse::sendResponse(Response::HTTP_OK, 'No ads found', []);
    }
}
