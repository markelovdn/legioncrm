<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradesCntroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $competitor_id = Grade::first();
        $id = $competitor_id->competitor_id;
        $competitor  = Competitor::with('athlete')->where('id', $id)->first();

        $competitor_logo = '';

        foreach ($competitor->athlete->user->organizations as $organization) {
            $competitor_logo = $organization->logo;
            break;
        }

        $grades = Grade::where('grade', '!=', null)->get();

        $grade_avg = '0';
        if (count($grades) == 3) {
            $grade_avg = round($grades->avg('grade'), 2);
        } elseif (count($grades) > 3) {
            $grade_avg = 'Ожидание оценок';
        }


        return view('competitions.poomsae.poomsae-tablo', [
            'competitor' => $competitor,
            'grade' => $grade_avg,
            'competitor_logo'=>$competitor_logo
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $grade = new Grade();

        $grade->grade = $request->grade;
        $grade->save();

        $request->session()->flash('status', 'Данные отправлены');
        return back();

    }

    public function setName(Request $request)
    {
        DB::table('grades')->truncate();
        $grade = new Grade();

        $grade->competitor_id = $request['params']['competitor_id'];
        $grade->save();

        $request->session()->flash('status', 'Данные отправлены');
        return back();

    }

    public function getId()
    {
        $grade = Grade::first();

        $id = $grade->competitor_id;

        return $id;

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
        //
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
}
