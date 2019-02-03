<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Company;

class CompanyController extends Controller
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
        $companies = Company::paginate(10);
        return view('companies.index',compact('companies'));
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
            'name' => 'required|min:3|max:255',
            'logo'  => 'image|dimensions:min_width=100,min_height=100',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['status'=>false,'message' => $validator->errors()->first()]);
        }

        $model = new Company();
        $model->name = $request->name;
        $model->email = $request->email ? $request->email : '';
        $model->website = $request->website ? $request->website : '';
        $model->address = $request->address ? $request->address : '';
        $model->logo = $request->logo ? $this->uploadImage($request->logo) : '';
        
        if($model->save()){
            return response()->json([
                'status' => true,
                'message' => 'company inserted',
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
        $model = Company::findOrFail($id);

        if (!$model) {
            return response()->json([
                'status' => 400,
                'message' => 'Company not found'
            ]);
        }

        $rules = [
            'name' => 'required|min:3|max:255',
            //'logo'  => 'image|dimensions:min_width=100,min_height=100',
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['status'=>false,'message' => $validator->errors()->first()]);
        }

        if($request->has('name')):
            $model->name = $request->name;
        endif;

        if($request->has('email')):
            $model->email = $request->email;
        endif;

        if($request->has('website')):
            $model->website = $request->website;
        endif;

        if($request->has('address')):
            $model->address = $request->address;
        endif;

        if($request->has('logo')):
            $model->logo = $this->uploadImage($request->logo);
        endif;

        
        if($model->save()){
            return response()->json([
                'status' => true,
                'message' => 'company updated',
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
        $model = Company::findOrFail($id);

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

    private function uploadImage($image)
    {
        $image_name = date('mdYHis') .$image->getClientOriginalName();
        $path = base_path() . '/storage/app/public';
        $image->move($path,$image_name);
        return $image_name;
    }
}
