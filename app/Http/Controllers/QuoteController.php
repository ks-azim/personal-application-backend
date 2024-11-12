<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    public function getAll()
    {
        $quotes = Quote::orderBy('order', 'DESC')->get();

        if(!$quotes) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $quotes
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
            \DB::transaction(function() use($request) {
                $quote = Quote::create([
                    'project_id' => $request->project_id,
                    'name'       => $request->name, 
                    'email'      => $request->email, 
                    'phone'      => $request->phone, 
                    'subject'    => $request->subject, 
                    'message'    => $request->message
                ]);
    
                Notification::create([
                    'quote_id'  => $quote->id,
                    'status'    => 'not seen'
                ]);
            });
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Quote Created Successfully !'
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
        $quote = Quote::where('id', $id)->first();

        if(!$quote) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'   => 200,
            'data'     => $quote
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
            Quote::where('id', $id)->update([
                'project_id' => $request->project_id,
                'name'       => $request->name, 
                'email'      => $request->email, 
                'phone'      => $request->phone, 
                'subject'    => $request->subject, 
                'message'    => $request->message
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Quote Updated Successfully !'
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
        $quote = Quote::find($id);

        if(!$quote) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        $quote->delete();

        return response()->json([
            'status'   => 200,
            'message'  => 'Data Deleted Successfully !'
        ]);
    }
}
