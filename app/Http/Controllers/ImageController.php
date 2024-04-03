<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ImageController extends Controller
{
    public function index(): View
    {
        return view('imageUpload');
    }
        
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $imageName = 'abbas' . time() . '.' . $request->image->extension();  
         
        // Store the uploaded image in the custom directory "uploads"
        $request->image->move(public_path('uploads'), $imageName);
        
        // Create a thumbnail
        //$thumbnailPath = 'thumbnails/' . $imageName;
       // $thumbnail = Image::make(public_path('uploads') . '/' . $imageName)->fit(100)->save(public_path($thumbnailPath));

        // Store the original image in local storage
        $originalPath = 'originals/' . $imageName;
        Storage::disk('local')->put($originalPath, file_get_contents(public_path('uploads') . '/' . $imageName));

        // Store the thumbnail in S3 storage
        //Storage::disk('s3')->put($thumbnailPath, file_get_contents(public_path($thumbnailPath)));

        // Store image information in the Passenger model
        
        $passenger = new Passenger();
        $passenger->first_name = 'Fake Name';
        $passenger->last_name = 'Fake Name';
        $passenger->email = 'fake_' . Str::random(5) . '@gmail.com';
        $passenger->password = 'StrongPassword123';
        $passenger->date_of_birth = date('Y-m-d', strtotime('-'.rand(18, 80).' years'));
        $passenger ->passport_expiry_date =date('Y-m-d', strtotime('-'.rand(18, 80).' years'));

        $passenger->image = $imageName;
     //   $passenger->thumbnail = $thumbnailPath;
        $passenger->save();

        return back()
                    ->with('success', 'You have successfully uploaded the image.')
                    ->with('image', $imageName);
                    //->with('thumbnail', $thumbnailPath);
    }
}
