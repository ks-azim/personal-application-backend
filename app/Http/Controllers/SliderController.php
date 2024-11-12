<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function getAll()
    {
        $sliders = Slider::with('slides')->orderBy('order', 'DESC')->get();

        if(!$sliders) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $sliders
        ]);
    }

    public function create(Request $request)
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
            Slider::create([
                'title'  => $request->title, 
                'status' => $request->status
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Slider Created Successfully !'
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
        $slider = Slider::where('id', $id)->first();

        if(!$slider) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $slider
        ]);
    }

    public function update(Request $request, $id)
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
            Slider::where('id', $id)->update([
                'title'  => $request->title, 
                'status' => $request->status
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Slider Updated Successfully !'
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
        $slider = Slider::find($id);

        if(!$slider) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        $slider->delete();

        return response()->json([
            'status'   => 200,
            'message'  => 'Data Deleted Succesfully !'
        ]);
    }
}
