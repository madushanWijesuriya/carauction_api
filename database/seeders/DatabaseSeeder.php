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
use App\Models\VhMaker;
use App\Models\VhModel;
use App\Models\VhStatus;
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
            ['name' => 'Make1'],
            ['name' => 'Make2'],
            ['name' => 'Make3'],
            ['name' => 'Make4'],
            ['name' => 'Make5']
        ];

        foreach ($make as $key => $value) {
            VhMaker::updateOrCreate($value);
        }
        $model = [
            ['name' => 'model1'],
            ['name' => 'model2'],
            ['name' => 'model3'],
            ['name' => 'model4'],
            ['name' => 'model5']
        ];

        foreach ($model as $key => $value) {
            VhModel::updateOrCreate($value);
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
            ['name' => 'bodyType1'],
            ['name' => 'bodyType2'],
            ['name' => 'bodyType3'],
            ['name' => 'bodyType4'],
            ['name' => 'bodyType5']
        ];

        foreach ($status as $key => $value) {
            VhBodyType::updateOrCreate($value);
        }

        $doorType = [
            ['name' => 'doorType1'],
            ['name' => 'doorType2'],
            ['name' => 'doorType3'],
            ['name' => 'doorType4'],
            ['name' => 'doorType5']
        ];

        foreach ($doorType as $key => $value) {
            VhDoorTypes::updateOrCreate($value);
        }

        $driverType = [
            ['name' => 'driverType1'],
            ['name' => 'driverType2'],
            ['name' => 'driverType3'],
            ['name' => 'driverType4'],
            ['name' => 'driverType5']
        ];

        foreach ($driverType as $key => $value) {
            VhDriveTypes::updateOrCreate($value);
        }
        $exteriorColor = [
            ['name' => 'color1'],
            ['name' => 'color2'],
            ['name' => 'color3'],
            ['name' => 'color4'],
            ['name' => 'color5']
        ];

        foreach ($exteriorColor as $key => $value) {
            VhExteriorColor::updateOrCreate($value);
        }

        $features = [
            ['name' => 'feature1'],
            ['name' => 'feature2'],
            ['name' => 'feature3'],
            ['name' => 'feature4'],
            ['name' => 'feature5']
        ];

        foreach ($features as $key => $value) {
            VhFeatures::updateOrCreate($value);
        }

        $fuelTypes = [
            ['name' => 'fuel1'],
            ['name' => 'fuel2'],
            ['name' => 'fuel3'],
            ['name' => 'fuel4'],
            ['name' => 'fuel5']
        ];

        foreach ($fuelTypes as $key => $value) {
            VhFuelTypes::updateOrCreate($value);
        }
        $fuelTypes = [
            ['name' => 'fuel1'],
            ['name' => 'fuel2'],
            ['name' => 'fuel3'],
            ['name' => 'fuel4'],
            ['name' => 'fuel5']
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
