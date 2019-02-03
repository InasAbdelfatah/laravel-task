<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Company;

class EmployeeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::whereIsAdmin(0)->paginate(10);
        $companies = Company::all();
        return view('employees.index',compact('employees','companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required|min:3|max:25',
            'last_name' => 'required|min:3|max:25',
            'phone' => 'min:7|max:15',
            'email' => 'email',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['status'=>false,'message' => $validator->errors()->first()]);
        }

        $model = new User();
        $model->first_name = $request->first_name;
        $model->last_name = $request->last_name;
        $model->phone = $request->phone;
        $model->email = $request->email;
        $model->password = '';
        $model->company_id = $request->company;

        if($model->save()){
            return response()->json([
                'status' => true,
                'message' => 'employee inserted',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'error',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = User::findOrFail($id);

        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'Employee not found'
            ]);
        }
        $rules = [
            'first_name' => 'required|min:3|max:25',
            'last_name' => 'required|min:3|max:25',
            'phone' => 'min:7|max:15',
            'email' => 'email',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['status'=>false,'message' => $validator->errors()->first()]);
        }

        $model->first_name = $request->first_name;
        $model->last_name = $request->last_name;
        $model->phone = $request->phone;
        $model->email = $request->email;
        $model->company_id = $request->company;

        if($model->save()){
            return response()->json([
                'status' => true,
                'message' => 'employee updated',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'error',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = User::findOrFail($id);

        if ($model->delete()) {
            return response()->json([
                'status' => true,
                'data' => $id
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'not found'
        ]);
    }
}
