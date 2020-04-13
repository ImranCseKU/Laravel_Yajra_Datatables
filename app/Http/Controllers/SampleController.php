<?php

namespace App\Http\Controllers;

use App\Sample_data;
use Illuminate\Http\Request;
use DataTables; //it will impost Yajra DataTables Packages in this file
use Validator;

class SampleController extends Controller
{
    
    public function index(Request $request)
    {
        // this condition will be true if this function received ajax Request
        if($request->ajax())
        {
            $data = Sample_data::latest()->get();
            // we have write return statement with DataTables class with a method and under this $data method
            // after this we have write addColumn() method with two agrs. 1st Table column name - 2nd a callback function with $data 
            // now he have write return this $button . it will display edit and delete btn ander this action Table Column
            // for new column we want to define a column which should not escaped , for this we have write rowColumns() method
            
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        //using pagination...
        // $datas = Sample_data::paginate(10);

        //using DataTables without pagination...
        // $datas = Sample_data::latest()->get();
        // return view('sample_data', compact('datas'));

        return view('sample_data');
    }
    
    public function store( Request $request){
        $validator = Validator::make($request->all(), [
            'first_name'    =>  'required',
            'last_name'     =>  'required'
        ]);

        if ($validator->fails()) {

            return response()->json(['errors' =>  $validator->errors()->all()]);

        }

        $form_data = [
            "first_name"=> trim($request->first_name),
            "last_name"=> trim($request->last_name),
        ];

        Sample_data::create($form_data);
        return response()->json(['success'=> 'Data Added successfully.']);
    }
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Sample_data::findOrFail($id);
            return response()->json(['user_record' => $data]);
        }

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    =>  'required',
            'last_name'     =>  'required'
        ]);

        if ($validator->fails()) {

            return response()->json(['errors' =>  $validator->errors()->all()]);

        }

        $form_data = [
            "first_name"=> trim($request->first_name),
            "last_name"=> trim($request->last_name),
        ];

        Sample_data::where('id', $request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);

    }

    /*
    public function create()
    {
        //
    }

    
    public function show(Sample_data $sample_data)
    {
        //
    }

    
    

    public function update(Request $request, Sample_data $sample_data)
    {
        $rules = array(
            'first_name'        =>  'required',
            'last_name'         =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'first_name'    =>  $request->first_name,
            'last_name'     =>  $request->last_name
        );

        Sample_data::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);

    }

  
    public function destroy($id)
    {
        $data = Sample_data::findOrFail($id);
        $data->delete();
    }*/
    
}
