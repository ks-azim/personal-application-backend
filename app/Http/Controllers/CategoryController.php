<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function getAll()
    {
        $categories = Category::orderBy('order', 'DESC')->get();

        if(!$categories) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $categories
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
            Category::create([
                'name'   => $request->name, 
                'icon'   => $request->icon, 
                'order'  => $request->order 
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Category Created Successfully !'
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
        $category = Category::where('id', $id)->first();

        if(!$category) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $category
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
            Category::where('id', $id)->update([
                'name'   => $request->name, 
                'icon'   => $request->icon, 
                'order'  => $request->order 
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Category Updated Successfully !'
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
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        $category->delete();

        return response()->json([
            'status'   => 200,
            'message'  => 'Data Deleted Successfully !'
        ]);
    }
}
