<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\User;
use App\Models\VhBodyType;
use App\Models\VhDoorTypes;
use App\Models\VhDriveTypes;
use App\Models\VhExteriorColor;
use App\Models\VhFeatures;
use App\Models\VhFuelTypes;
use App\Models\VhMakeModel;
use App\Models\VhMaker;
use App\Models\VhModel;
use App\Models\VhStatus;
use App\Models\VhStreeing;
use App\Models\VhTransmission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $make = [
            ['name' => 'Toyota'],
            ['name' => 'Audi'],
            ['name' => 'Suzuki'],
            ['name' => 'Nissan'],
            ['name' => 'Yamaha']
        ];

        foreach ($make as $key => $value) {
            VhMaker::updateOrCreate($value);
        }
        $model = [
            'Toyota' =>[
                ['name' => 'AQUA'],
                ['name' => 'AQUA G'],
                ['name' => 'AQUA AAD'],
                ['name' => 'AQUA Hybrid'],
                ['name' => 'AQUA L']
            ],
            'Audi' => [
                ['name' => 'A3'],
                ['name' => 'A6'],
            ],
            'Suzuki' =>[
                ['name' => 'Altra'],
                ['name' => 'Every'],
                ['name' => 'Carry Truck'],
                ['name' => 'Solio'],
                ['name' => 'Key']
            ],
        ];

        foreach ($model as $key => $values) {
            foreach ($values as $index => $value) {
                $make = VhMaker::where('name',$key)->first();
                $mod = VhModel::updateOrCreate($value);
                VhMakeModel::updateOrCreate([
                    'model_id' => $mod->id,
                    'make_id' => $make ? $make->id : VhMaker::create(['name' => $key])->id,
                ]);
            }
        }
        $status = [
            ['name' => 'Status1'],
            ['name' => 'Status2'],
            ['name' => 'Status3'],
            ['name' => 'Status4'],
            ['name' => 'Status5']
        ];

        foreach ($status as $key => $value) {
            VhStatus::updateOrCreate($value);
        }

        $bodyType = [
            ['name' => '4WD'],
            ['name' => 'Buses'],
            ['name' => 'Brand New Cars'],
            ['name' => 'Coupe'],
            ['name' => 'Duel Cab']
        ];

        foreach ($bodyType as $key => $value) {
            VhBodyType::updateOrCreate($value);
        }

        $steering = [
            ['name' => 'Left'],
            ['name' => 'Right'],
            ['name' => 'Center'],
            ['name' => 'Unspecified'],
        ];

        foreach ($steering as $key => $value) {
            VhStreeing::updateOrCreate($value);
        }

        $doorType = [
            ['name' => '1 Door'],
            ['name' => '2 Door'],
            ['name' => '3 Door'],
            ['name' => '4 Door'],
            ['name' => '5 Door'],
            ['name' => 'Conversional Door']
        ];

        foreach ($doorType as $key => $value) {
            VhDoorTypes::updateOrCreate($value);
        }

        $driverType = [
            ['name' => '2WD'],
            ['name' => '4WD'],
            ['name' => 'Both'],

        ];

        foreach ($driverType as $key => $value) {
            VhDriveTypes::updateOrCreate($value);
        }
        $exteriorColor = [
            ['name' => 'Al pin white'],
            ['name' => 'Any'],
            ['name' => 'Alabaster white'],
            ['name' => 'Alabaster Silder'],
        ];

        foreach ($exteriorColor as $key => $value) {
            VhExteriorColor::updateOrCreate($value);
        }

        $features = [
            ['name' => 'A/C front'],
            ['name' => 'A/C rear'],
            ['name' => 'Alarm'],
            ['name' => 'Alloy wheel'],
            ['name' => 'Radio']
        ];

        foreach ($features as $key => $value) {
            VhFeatures::updateOrCreate($value);
        }
        $transmission = [
            ['name' => 'transmission']
        ];
        

        foreach ($transmission as $key => $value) {
            VhTransmission::updateOrCreate($value);
        }
        
        $fuelTypes = [
            ['name' => 'ASK'],
            ['name' => 'Bio Diesel'],
            ['name' => 'Electic'],
            ['name' => 'Gas'],
            ['name' => 'Gasoline']
        ];
        foreach ($fuelTypes as $key => $value) {
            VhFuelTypes::updateOrCreate($value);
        }

        $this->call([
            CountrySeeder::class,
            PermissionSeeder::class
        ]);
    }
}
