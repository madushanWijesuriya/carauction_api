<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Country;
use App\Models\CountryContent;
use App\Models\Page;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            'Burundi',
'Kenya',
'Tanzania',
'SouthAfrica',
'DRCongo',
'Uganda',
'Zambia',
'Botswana',
'Malawi',
'Mozambique',
'Pakistan',
'SriLanka',
'Bangladesh',
'Myanmar',
'UAE',
'Singapore',
'Thailand',
'Malaysia',
'Philippines',
'HongKong',
'Cyprus',
'UnitedKingdom',
'Malta',
'Turkey',
'Ireland',
'Georgia',
'Russian',
'Armenia',
'Jamaica',
'Grenada',
'Bahamas',
'Guyana',
'SaintLucia',
'Barbados',
'Haiti',
'NewZealand',
'Fiji',
'Tonga',
'Samoa',
'SolomonIslands',
'Guam',
'Palau',
'Micronesia',
'Australia',
        ];

        $pages = [
            'Country',
        ];
     foreach ($pages as $index => $page) {
         $page = Page::updateOrCreate(['name'=>$page]);
         foreach ($countries as $index => $value) {
            $content = Content::updateOrCreate([
                'page_id' => $page->id,
                'contents' => 'Heading - '.$index,
            ]);
         }
         
        
    }


    foreach ($countries as $index => $value) {
        $country = Country::updateOrCreate(['name'=>$value]);

        foreach (Content::all() as $key => $content) {
            CountryContent::updateOrCreate([
                'content_id' => $content->id,
                'country_id' => $country->id,
            ]);
        }
    }
    
    }
}
