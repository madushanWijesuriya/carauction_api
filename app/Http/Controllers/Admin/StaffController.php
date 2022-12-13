<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\Admin\StaffResource;
use App\Http\Resources\Admin\VehicleCollection;
use App\Http\Resources\Admin\VehicleResource;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Models\VhMakeModel;
use App\Models\VhMaker;
use App\Models\VhModel;
use App\Services\ResponseGenerator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::select('*')->with('roles');
        
        $result = QueryBuilder::for($query)
            ->allowedFilters(['name','email','roles.id'])
            ->allowedSorts(['name','email']);

            if( !$request->has('noPagination')) {
                $result = $result->paginate($request['paginate'] <= 50 ? $request['paginate'] : null);
            } else {
                $result = $result->get();
            }

            return StaffResource::collection($result);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try{
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:staff,email',
                    'password' => 'required',
                    'role_id' => 'required|exists:roles,id'
                ]);
    
            if($validateUser->fails()){
                
            
                return response()->json([
                    'data'=>[
                        'message'=>'The given data was invalid.',
                        'errors'=>$validateUser->errors()
                    ]], 401);
            }
    
            $user = Staff::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $role = Role::find($request->role_id)->name;
            $user->syncRoles([$role]);

             return response()->json([
                'status' => true,
                'message' => 'Staff Created Successfully'
            ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
    }

    public function show($id)
    {
        $user = Staff::findOrFail($id);
        return new StaffResource($user);
    }

    public function update(Request $request, $id)
    {
        try{
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:staff,email,'.$id,
                    'role_id' => 'required|exists:roles,id'
                ]);
    
            if($validateUser->fails()){
                
            
                return response()->json([
                    'data'=>[
                        'message'=>'The given data was invalid.',
                        'errors'=>$validateUser->errors()
                    ]], 401);
            }
    
            $user = Staff::find($id);
            $user->update($request->all());
            $user->syncRoles([Role::find($request->role_id)->name]);

             return response()->json([
                'status' => true,
                'message' => 'Staff Updated Successfully'
            ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
    }

    public function destroy($id)
    {
        try{
            $vehicle = Staff::findOrFail($id);
            $vehicle->delete();
            return response()->json(['message' => 'Successfully Deleted'],200);
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
}
