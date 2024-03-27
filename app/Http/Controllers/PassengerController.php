<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Cache;


class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cacheKey = 'passengers_' . $request->fullUrl();
    
        return Cache::remember($cacheKey, now()->addMinutes(1), function () use ($request) {
            $passengers = QueryBuilder::for(Passenger::class)
                ->allowedFilters([AllowedFilter::exact('id'),'first_name', 'last_name','date_of_birth','passport_expiry_date'])
                ->allowedSorts(['first_name', 'last_name','date_of_birth','passport_expiry_date'])
                ->paginate($request->input('per_page', 100));
    
            return response()->json($passengers);
        });
    }
    

    
   
     public function store(Request $request)
     {
         // Define validation rules
         $rules = [
             'first_name' => 'required|string|max:255',
             'last_name' => 'required|string|max:255',
             'email' => 'required|email|unique:passengers',
             'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
             'date_of_birth' => 'required|date',
             'passport_expiry_date' => 'required|date',
         ];
     
         // Validate the incoming request data
         $validatedData = $request->validate($rules);
     
         // Encrypt password if provided
         if(isset($validatedData['password'])) {
             $validatedData['password'] = bcrypt($validatedData['password']);
         }
     
         // Create a new record in the passengers table using validated data
         $passenger = Passenger::create($validatedData);
     
         // Return a JSON response with the created passenger
         return response()->json($passenger);
     }
     
     public function update(Request $request, Passenger $passenger)
     {
         // Define validation rules
         $rules = [
             'first_name' => 'required|string|max:255',
             'last_name' => 'required|string|max:255',
             'email' => 'required|email|unique:passengers,email,'.$passenger->id,
             'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
             'date_of_birth' => 'required|date',
             'passport_expiry_date' => 'required|date',
         ];
     
         // Validate the incoming request data
         $validatedData = $request->validate($rules);
     
         // Encrypt password if provided
         if(isset($validatedData['password'])) {
             $validatedData['password'] = bcrypt($validatedData['password']);
         }
     
         // Update the passenger record with the validated data
         $passenger->update($validatedData);
     
         // Return the updated passenger record
         return response()->json($passenger);
     }
     

  

     public function show(Passenger $passenger)
     {
         $cacheKey = 'passenger_' . $passenger->id;
     
         return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($passenger) {
             return response()->json($passenger);
             
         });
         
     }
     

   
    public function destroy(Passenger $passenger)
    {
        $passenger->delete();
        return response()->json(['message' => 'passenger deleted successfully']);
    }
}
