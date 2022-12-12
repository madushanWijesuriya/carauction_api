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



    $contents = [
        'header_one_01' => 'Fully ',
        'header_one_02' => 'Transparent ',
        'header_one_03' => 'Fully in ',
        'header_one_04' => 'Control ',
        'para_one_01' => 'say hello to an online shopping experience that pute you right in the drivers seat.',
        'contact_us' => 'Contact Us',
        'office' => 'Office',
        'office_value' => '123 Anywhere St., Any City, ST 12345',
        'phone_no' => 'Phone Number',
        'phone_no_value' => '+123-456-789 0',
        'email' => 'Email',
        'email_value' => 'hello@reallygreatsite.com',
        'header_two_01' => 'Why do ',
        'header_two_country' => 'Sri Lankan ',
        'header_two_02' => 'customers choose JAMAX to buy a car in Japan?',
        'para_two_01' => 'We will give you a member registration form that you can use to register with us. Jamex Auto Auctions will give you due assistance regarding the procedure with which you can place your bids and control them for the deposit, auction, and payments.',
        'point_01_header' => 'Fully tested car',
        'point_01_value' => 'The motors we export are fully inspected. We guarantee you that you will get a satisfying car at the lowest price. The condition of the car is the same as the public sale list, as there are fair inspectors who guarantee complete satisfaction to customers around the world.',
        'point_02_header' => 'Lowest price',
        'point_02_value' => 'Jamex Motors achieves the lowest price for a car by avoiding the hidden costs that directly increase the overall value of the used car.',
        'point_03_header' => 'Prompt delivery',
        'point_03_value' => 'Transportation has become faster and easier thanks to our public sale houses near the harbor. We have a strong connection with the Sri Lankan shipping company.',
        'point_04_header' => 'Well paid network',
        'point_04_value' => 'Our well-distributed community of more than 140 public housing in Japan provides 145,000 vehicles to our customers each week.',
        'point_05_header' => 'Full buyer support',
        'point_05_value' => 'We have 24/7 buyer support exclusively for clients who want to get informationon the safe transportation of vehicles in Sri Lanka. With the support of Sri Lankas Logistics Agency, additional secure customs clearance is permitted.',

    ];
     foreach ($pages as $index => $page) {
         $page = Page::updateOrCreate(['name'=>$page]);
         foreach ($contents as $index => $value) {
            $content = Content::updateOrCreate([
                'page_id' => $page->id,
                'key' => $index,
                'contents' => '',
                'data' => $value,
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
