<?php
namespace Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class IMGController extends Controller
{
    public function uploadImage(Request $request)
    {
        if($request->hasfile('image'))
{
    $file = $request->file('image');
    $imageName=time().$file->getClientOriginalName();
    $filePath = 'uploads/' . $imageName;
    Storage::disk('s3')->put($filePath, file_get_contents($file));
    // After Image is uploaded make entry to database
    return "done";
}
else {
    # code...
    return response()->json(['path' => $path]);
}
    }
}


