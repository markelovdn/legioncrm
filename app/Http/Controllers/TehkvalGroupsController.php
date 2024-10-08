<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTehkvalgroupRequest;
use App\Models\Competition;
use App\Models\Tehkval;
use App\Models\TehkvalGroup;

class TehkvalGroupsController extends Controller
{

    public function index($competition_id)
    {
        $competition = Competition::with('agecategories')->where('id', $competition_id)->first();
        $tehkvals = Tehkval::get();
        $tehkvalgroups = TehkvalGroup::with('agecategory')
            ->where('competition_id', $competition_id)->orderBy('agecategory_id')->get();

        return view('competitions.tehkvalgroups', [
            'competition' => $competition,
            'tehkvals' => $tehkvals,
            'tehkvalgroups' => $tehkvalgroups,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreTehkvalgroupRequest $request)
    {
        $request->validated();

        if (!TehkvalGroup::checkTehkvalGroup(
            $request->competition_id,
            $request->agecategory_id,
            $request->startgyp_id,
            $request->finishgyp_id
        )) {
            return back();
        };

        $titleTehkvalGroup = TehkvalGroup::getNameTehKvalGroup($request->startgyp_id, $request->finishgyp_id);

        $tehkvalgroup = new TehkvalGroup();

        $tehkvalgroup->title = $request->title.$titleTehkvalGroup;
        $tehkvalgroup->competition_id = $request->competition_id;
        $tehkvalgroup->agecategory_id = $request->agecategory_id;
        $tehkvalgroup->startgyp_id = $request->startgyp_id;
        $tehkvalgroup->finishgyp_id = $request->finishgyp_id;

        $tehkvalgroup->save();

        return back();

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //сделал так потому что не смог разобраться с версткой
        $tehkvalgroup = TehkvalGroup::find($id);

        $tehkvalgroup->delete();

        return back();
    }

    public function update(StoreTehkvalgroupRequest $request, $id)
    {
        $request->validated();

        $tehkvalgroup = TehkvalGroup::find($id);

        $tehkvalgroup->title = $request->title;

        $tehkvalgroup->save();

        return back();
    }

    public function destroy($id)
    {

    }
}
