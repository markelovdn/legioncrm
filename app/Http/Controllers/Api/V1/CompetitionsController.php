<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Competitor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CompetitionsController extends Controller
{

    private $competition;
    public function __construct(Competition $competition){
        $this->competition = $competition;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $competitions = Competition::with('agecategories')->get();
        $competitors = Competitor::get();

        return view('competitions.competitions', [
            'competitions'=>$competitions,
            'competitors'=>$competitors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('competitions.addcompetition', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:250'],
            'place' => ['required', 'string', 'max:150'],
            'date_start' => ['required', 'date'],
            'date_end' => ['required', 'date'],
        ]);

        $competition = new Competition();

        $competition->name = $request->name;
        $competition->place = $request->place;
        $competition->date_start = $request->date_start;
        $competition->date_end = $request->date_end;

        $competition->save();

        $request->session()->flash('status', 'Соревнование успешно добавлено');

        return redirect('/')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $competition = Competition::where('id', $id)->with('agecategories')->first();

        return view('competitions.editcompetition', ['competition' => $competition]);
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
        dd($request->agecategory);

        $validate = $request->validate([
            'name' => ['required', 'string', 'max:250'],
            'place' => ['required', 'string', 'max:150'],
            'date_start' => ['required', 'date'],
            'date_end' => ['required', 'date'],
        ]);

        $competition = Competition::find($request->competition_id);

        $competition->name = $request->name;
        $competition->place = $request->place;
        $competition->date_start = $request->date_start;
        $competition->date_end = $request->date_end;

        $competition->save();

        $this->competition->competition_agecategories($request);

        $request->session()->flash('status', 'Соревнование успешно добавлено');

        return redirect('/')->withInput();
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
