<?php
  
// namespace App\Http\Controllers;
  
// use Illuminate\Http\Request;
// use Illuminate\View\View;
// use Illuminate\Http\RedirectResponse;
  
// class ImageController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index(): View
//     {
//         return view('imageUpload');
//     }
        
//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\RedirectResponse
//      */
//     public function store(Request $request): RedirectResponse
//     {
//         $request->validate([
//             'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//         ]);
        
//         $imageName ='abbas'. time() . '.' . $request->image->extension();  
         
//         // Store the uploaded image in the custom directory "uploads"
//         $request->image->move(public_path('uploads'), $imageName);
        
//         /* 
//             Write Code Here for
//             Store $imageName name in DATABASE from HERE 
//         */
        
//         return back()
//                     ->with('success', 'You have successfully uploaded the image.')
//                     ->with('image', $imageName); 
//     }
// }



namespace App\Http\Controllers;

use App\Models\Passenger; // Import the Passenger model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Facades\Image;


class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('imageUpload');
    }
        
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $imageName = 'abbas' . time() . '.' . $request->image->extension();  
         
        // Store the uploaded image in the custom directory "uploads"
        $request->image->move(public_path('uploads'), $imageName);
        
        // Create a thumbnail
        $thumbnailPath = 'thumbnails/' . $imageName;
       // $thumbnail = Image::make(public_path('uploads') . '/' . $imageName)->fit(100)->save(public_path($thumbnailPath));

        // Store the original image in local storage
        $originalPath = 'originals/' . $imageName;
        Storage::disk('local')->put($originalPath, file_get_contents(public_path('uploads') . '/' . $imageName));

        // Store image information in the Passenger model
        // $passenger = new Passenger();
        // $passenger->image = $imageName;
        // $passenger->thumbnail = $thumbnailPath;
        // $passenger->save();

        return back()
                    ->with('success', 'You have successfully uploaded the image.')
                    ->with('image', $imageName)
                    ->with('thumbnail', $thumbnailPath);
    }
}

