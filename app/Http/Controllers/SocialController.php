<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Social;
use Illuminate\Support\Facades\Validator;

class SocialController extends Controller
{
    public function getAll()
    {
        $socials = Social::get();

        if(!$socials) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $socials
        ]);
    }

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title'    => 'required',
            'base_url' => 'required',
            'link'     => 'required'
        ]);

        if($validate->fails()) {
           return response()->json([
            'status' => 400,
            'errors' => $validate->errors()
           ]);
        }

        try {
            Social::create([
                'title'    => $request->title, 
                'base_url' => $request->base_url, 
                'link'     => $request->link, 
                'icon'     => $request->icon
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Social Created Successfully !'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'   => 500,
                'message'  => $e
            ]);
        }
    }

    public function getById($id)
    {
        $social = Social::where('id', $id)->first();

        if(!$social) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $social
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title'    => 'required',
            'base_url' => 'required',
            'link'     => 'required'
        ]);

        if($validate->fails()) {
           return response()->json([
            'status' => 400,
            'errors' => $validate->errors()
           ]);
        }

        try {
            Social::where('id', $id)->update([
                'title'    => $request->title, 
                'base_url' => $request->base_url, 
                'link'     => $request->link, 
                'icon'     => $request->icon
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Social Updated Successfully !'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'   => 500,
                'message'  => $e
            ]);
        }
    }

    public function delete($id)
    {
        $social = Social::find($id);

        if(!$social) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        $social->delete();

        return response()->json([
            'status'   => 200,
            'message'  => 'Data Deleted Successfully !'
        ]);
    }
}
