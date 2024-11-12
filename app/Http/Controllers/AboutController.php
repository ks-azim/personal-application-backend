<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;

class AboutController extends Controller
{
    public function view()
    {
        $about = About::where('id', 1)->first();

        if(!$about) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $about
        ]);
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validate->fails()) {
           return response()->json([
            'status' => 400,
            'errors' => $validate->errors()
           ]);
        }

        try {
            $featuredPhoto = '';
            if($request->hasFile('photo')) {
               $featuredPhoto = $this->handleFile($request->photo);
            }

            About::where('id', $id)->update([
                'photo'       => $featuredPhoto,
                'description' => $request->description
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Page Updated Successfully !'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'   => 500,
                'message'  => $e
            ]);
        }
    }

    private function handleFile($file)
    {
        $extension = $file->getOriginalClientExtension();
        $fileName = time().'.'.$extension;
        $file->move('public/about', $fileName);
        return $fileName;
    }
}
