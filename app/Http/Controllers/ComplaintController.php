<?php

namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        if (Auth::user()->isManager()){
            $complaints = Complaint::all();
        }else{
            $complaints = Auth::user()->complaints;
        }
        
        return view('complaint.index', ['complaints' => $complaints]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create', Complaint::class)){
            abort(403);
        }
        return view('complaint.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create', Complaint::class)){
            abort(403);
        }

        Validator::make(
            $request->all(),
            [
                'theme' => 'required|min:3',
                'message' => 'required|min:5',
                'file' => 'file'
            ]
        )->validate();

        $complaint = new Complaint();
        $complaint->user_id = $request->user()->id;
        $complaint->theme = $request->input('theme');
        $complaint->message = $request->input('message');
        if($request->hasFile('file')){
            $complaint->file_path = $request->file('file')->store('complaint_files');
        }
        $complaint->save();

        return redirect()->route('complaints.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $complaint = $this->getModel($id);

        if (!Auth::user()->can('view',$complaint)){
            abort(403);
        }

        return view('complaint.show', ['complaint' => $complaint]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $complaint = $this->getModel($id);

        if (!Auth::user()->can('update',$complaint)){
            abort(403);
        }

        return view('complaint.edit', ['complaint' => $complaint]);
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
        $complaint = $this->getModel($id);

        if (!Auth::user()->can('update', $complaint)){
            abort(403);
        }

        Validator::make(
            $request->all(),
            [
                'theme' => 'required|min:3',
                'message' => 'required|min:5',
                'file' => 'file'
            ]
        )->validate();

        $complaint->user_id = $request->user()->id;
        $complaint->theme = $request->input('theme');
        $complaint->message = $request->input('message');
        if($request->hasFile('file')){
            $complaint->file_path = $request->file('file')->store('complaint_files');
        }
        $complaint->update();

        return redirect()->route('complaints.show', $complaint);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getModel($id){
        $model = Complaint::find($id);
        if (is_null($model)){
            abort(404);
        }
        return $model;
    }
}
