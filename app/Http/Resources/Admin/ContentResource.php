<?php

namespace App\Http\Resources\Admin;

use App\Models\Content;
use App\Models\Country;
use App\Models\Page;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = parent::toArray($request);
        $content = Content::find($response['content_id']);
        $page = Page::find($content->page_id);
        $country = Country::find($response['country_id']);
        $response['country'] = $country;
        $response['content'] = $content;
        $response['page'] = $page;
        return $response;
    }
}
