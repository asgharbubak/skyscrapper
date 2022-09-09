<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teacher_id = $request->input('id');
        if($teacher_id>0){
            $data = Schedule::with('subject')->with('cls')->where('teacher_id',$teacher_id)->select('*',Schedule::raw('TIME_FORMAT(start_time, "%h:%i %p") as formatted_start_time'),Schedule::raw('TIME_FORMAT(end_time, "%h:%i %p") as formatted_end_time'),Schedule::raw('TIMESTAMPDIFF(MINUTE, start_time, end_time) as duration'))->orderBy('start_time','asc')->get();
            $i=0;
            foreach($data as $r){
                $_class_name=$r['cls']->name ?? '';
                $_subject_name=$r['subject']->name ?? '';
                $data[$i]['class_name']=$_class_name;
                $data[$i]['subject_name']=$_subject_name;
                $i++;
            }
            return $data;
        }else{
            $data = Schedule::with('subject')->with('cls')->where('teacher_id',$teacher_id)->select('*',Schedule::raw('TIME_FORMAT(start_time, "%h:%i %p") as formatted_start_time'),Schedule::raw('TIME_FORMAT(end_time, "%h:%i %p") as formatted_end_time'),Schedule::raw('TIMESTAMPDIFF(MINUTE, start_time, end_time) as duration'))->orderBy('start_time','asc')->get();
            $i=0;
            foreach($data as $r){
                $_class_name=$r['cls']->name ?? '';
                $_subject_name=$r['subject']->name ?? '';
                $data[$i]['class_name']=$_class_name;
                $data[$i]['subject_name']=$_subject_name;
                $i++;
            }
            return $data;
        }
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
        $this->validate($request,[
            'teacher_id' => 'required',
            'is_break' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $record = new Schedule;
        $record->is_break = $request->input('is_break');
        $record->teacher_id = $request->input('teacher_id');
        $record->subject_id = $request->input('subject_id') ?? 0;
        $record->class_id = $request->input('class_id') ?? 0;
        $record->start_time = $request->input('start_time');
        $record->end_time = $request->input('end_time');
        $record->save();
        return $record;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Schedule::findorFail($id);
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
        
        $this->validate($request,[
            'teacher_id' => 'required',
            'is_break' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $record = Schedule::findorFail($id);
        $record->is_break = $request->input('is_break');
        $record->subject_id = $request->input('subject_id');
        $record->teacher_id = $request->input('teacher_id');
        $record->class_id = $request->input('class_id');
        $record->start_time = $request->input('start_time');
        $record->end_time = $request->input('end_time');
        $record->save();
        return $record;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Schedule::findorFail($id);
        if($record->delete()){
            return 'deleted successfully';
        }
    }
}
