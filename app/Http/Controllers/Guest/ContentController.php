<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ContentResource;
use App\Models\Content;
use App\Models\Country;
use App\Models\CountryContent;
use App\Models\Page;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class ContentController extends Controller
{
    public function index(Request $request){
        $query = CountryContent::select('*');
        
        $result = QueryBuilder::for($query)
            ->allowedFilters(['country_id', 'content_id'])
            ->allowedSorts(['country_id', 'content_id']);

            if( !$request->has('noPagination')) {
                $result = $result->paginate($request['paginate'] <= 50 ? $request['paginate'] : null);
            } else {
                $result = $result->get();
            }

            return ContentResource::collection($result);
    }
    public function getByCountryName(Request $request, $name){
        $country = Country::where('name', $name)->first();
        $contentIds = CountryContent::where('country_id', $country->id)->pluck('content_id')->toArray();
        $query = Content::select('*')->whereIn('id',$contentIds);
        $result = QueryBuilder::for($query);

            if( !$request->has('noPagination')) {
                $result = $result->paginate($request['paginate'] <= 50 ? $request['paginate'] : null);
            } else {
                $result = $result->get();
            }

            return JsonResource::collection($result);
    }
    
    public function update(Request $request, $id){
        try{
            $result = DB::transaction(function () use ($request, $id) {
                $countryContent = CountryContent::find($id);
                $content = Content::find($countryContent->content_id);
                $content->update($request->all());

                return $content;
            });

            if($result){
                return response()->json(['message' => 'Successfully Updated'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
                
    }
}
