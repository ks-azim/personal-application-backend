<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function getAll()
    {
        $projects = Project::with('category')->orderBy('date', 'DESC')->get();

        if(!$projects) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $projects
        ]);
    }

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'project_title' => 'required',
            'cat_id'        => 'required'
        ]);

        if($validate->fails()) {
           return response()->json([
            'status' => 400,
            'errors' => $validate->errors()
           ]);
        }

        try {
            Project::create([
                'cat_id'        => $request->cat_id, 
                'project_title' => $request->project_title, 
                'description'   => $request->description, 
                'date'          => $request->date
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Project Created Successfully !'
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
        $project = Project::where('id', $id)->first();

        if(!$project) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $project
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'project_title' => 'required',
            'cat_id'        => 'required'
        ]);

        if($validate->fails()) {
           return response()->json([
            'status' => 400,
            'errors' => $validate->errors()
           ]);
        }

        try {
            Project::where('id', $id)->update([
                'cat_id'        => $request->cat_id, 
                'project_title' => $request->project_title, 
                'description'   => $request->description, 
                'date'          => $request->date
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Project Updated Successfully !'
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
        $project = Project::find($id);

        if(!$project) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        $project->delete();

        return response()->json([
            'status'   => 200,
            'message'  => 'Data Deleted Successfully !'
        ]);
    }
}
