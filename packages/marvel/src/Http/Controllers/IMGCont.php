<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
class IMGController extends CoreController
{
public function uploadImage(Request $request)
{
    $file = $request->file('image');
    $path = $file->storeAs('images', 'filename.jpg', 's3');

    // You can also use the putFileAs() method:
    // $path = Storage::disk('s3')->putFileAs('images', $file, 'filename.jpg');

    // Do any additional processing or save the path to your database

    return response()->json(['path' => $path]);
}
}
