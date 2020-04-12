<?php

namespace App\Http\Controllers;

use App\Answer;
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
    public function index(Request $request)
    {
        $filter = null;
        if (Auth::user()->isManager()){
            if ($request->has('filter')){
                $filter = $request->input('filter');
                switch ($filter){
                    case 'unclosed':
                        $complaints = Complaint::where('status', '!=', 'closed')->get();
                        break;
                    case 'untreated':
                        $complaints = Complaint::where([['status', '!=', 'closed'],['status', '!=', 'answered']])->get();
                        break;
                    case 'unviewed':
                        $complaints = Complaint::where('status', '=', 'created')->orWhere('status', '=', 'unviewed')->get();
                        break;
                    case 'viewed':
                        $complaints = Complaint::where('status', '=', 'viewed')->orWhere('status', '=', 'accept')->get();
                        break;
                    case 'answered':
                        $complaints = Complaint::where('status', '=', 'answered')->get();
                        break;
                    case 'closed':
                        $complaints = Complaint::where('status', '=', 'closed')->get();
                        break;
                    default:
                        $complaints = Complaint::all();
                }
            }else{
                $complaints = Complaint::all();
            }
        }else{
            $complaints = Auth::user()->complaints;
        }
        
        return view('complaint.index', ['complaints' => $complaints, 'filter' => $filter]);
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

        if (($complaint->status == 'created' || $complaint->status == 'unviewed') && Auth::user()->isManager()){
            $complaint->status = 'viewed';
            $complaint->update();
        }

        return view('complaint.show', ['complaint' => $complaint, 'answers' => $complaint->answers]);
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
        $complaint->status = 'unviewed';
        $complaint->update();

        $answer = new Answer();
        $answer->user_id = Auth::user()->id;
        $answer->complaint_id = $complaint->id;
        $answer->text = 'Изменено заявка.';
        $answer->save();

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

    public function answer(Request $request, $id){
        $complaint = $this->getModel($id);

        if (!Auth::user()->can('answer', $complaint)){
            abort(403);
        }

        Validator::make(
            $request->all(),
            [
                'text' => 'required',
                'file' => 'file'
            ]
        )->validate();

        $answer = new Answer();
        $answer->user_id = $request->user()->id;
        $answer->complaint_id = $complaint->id;
        $answer->text = $request->input('text');
        if($request->hasFile('file')){
            $answer->file_path = $request->file('file')->store('answer_files');
        }
        $answer->save();

        if (Auth::user()->isManager()){
            $complaint->status = 'answered';
        }else{
            $complaint->status = 'unviewed';
        }
        $complaint->update();

        return redirect()->route('complaints.show', $complaint);
    }

    public function accept($id){
        $complaint = $this->getModel($id);

        if (!Auth::user()->can('accept', Complaint::class)){
            abort(403);
        }

        $complaint->status = 'accept';
        $complaint->update();

        return redirect()->route('complaints.show', $complaint);
    }

    public function close($id){
        $complaint = $this->getModel($id);

        if (!Auth::user()->can('close', $complaint)){
            abort(403);
        }

        $complaint->status = 'closed';
        $complaint->update();

        return redirect()->route('complaints.show', $complaint);
    }
}
