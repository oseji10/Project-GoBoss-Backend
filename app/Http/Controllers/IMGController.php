<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Attachment;
use Illuminate\Support\Str;

use App\Models\ProductTag;

class IMGController extends Controller
{
    public function uploadImage(Request $request)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pin = mt_rand(100000, 999999) . mt_rand(100000, 999999);
        $random_string = str_shuffle($pin);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->sale_price = $request->sale_price;
        $product->quantity = $request->quantity;
        $product->unit = $request->unit;
        $product->shop_id = $request->shop_id;
        $product->type_id = 1;
        $product->category_id = $request->category_id;
        // $product->slug = $random_string;
        $product->slug = Str::slug($request->name);

        $completeUrl = null;
        $completeGalleryUrls = [];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . $file->getClientOriginalName();
            $filePath = 'uploads/' . $imageName;

            try {
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $imageUrl = $filePath;
                $completeUrl = [
                    "id" => 477,
                    "original" => 'https://goboss-ng.s3.amazonaws.com/' . $imageUrl,
                    "thumbnail" => 'https://goboss-ng.s3.amazonaws.com/' . $imageUrl,
                ];
                $product->image = json_encode($completeUrl);
            } catch (\Exception $e) {
                // Handle error while uploading the image
                // You may log the error or perform necessary error handling
            }
        }

        if ($request->hasFile('gallery')) {
            $galleryFiles = $request->file('gallery');

            foreach ($galleryFiles as $gallery) {
                $galleryName = time() . $gallery->getClientOriginalName();
                $galleryPath = 'uploads/' . $galleryName;

                try {
                    Storage::disk('s3')->put($galleryPath, file_get_contents($gallery));
                    $galleryUrl = $galleryPath;
                    $completeGalleryUrls[] = [
                        "id" => 477,
                        "original" => 'https://goboss-ng.s3.amazonaws.com/' . $galleryUrl,
                        "thumbnail" => 'https://goboss-ng.s3.amazonaws.com/' . $galleryUrl,
                    ];
                } catch (\Exception $e) {
                    // Handle error while uploading a gallery image
                    // You may log the error or perform necessary error handling
                }
            }

            $product->gallery = json_encode($completeGalleryUrls);
        }

        $product->save();

    //    $product_tag = new ProductTag();
    //     $product_tag->product_id= $product->id;
    //     $product_tag->tag_id= 10;

    //     // $product_tag->withoutTimestamps();
    //     $product_tag->save();


        // $category_product = new CategoryProduct()
        // $category_product->product_id

        return $product;
    }





    public function avatar(Request $request)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pin = mt_rand(100000, 999999) . mt_rand(100000, 999999);
        $random_string = str_shuffle($pin);

        $avatar = new Attachment();


        $completeUrl = null;


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . $file->getClientOriginalName();
            $filePath = 'uploads/' . $imageName;

            try {
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $imageUrl = $filePath;
                $completeUrl = [
                    "id" => 477,
                    "original" => 'https://goboss-ng.s3.amazonaws.com/' . $imageUrl,
                    "thumbnail" => 'https://goboss-ng.s3.amazonaws.com/' . $imageUrl,
                ];
                $avatar->image = json_encode($completeUrl);
            } catch (\Exception $e) {
            }
        }



        $avatar->save();


        return $avatar;
    }
}
