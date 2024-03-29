<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Roadmap;
use App\Models\RoadmapStep;
use Illuminate\Http\Request;

use App\Http\Requests\RoadmapStep\RoadmapStepCreateRequest;
class RoadmapStepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($roadmap_id)
    {
        $roadmap = Roadmap::findOrFail($roadmap_id);
        $roadmapSteps = RoadmapStep::where('roadmap_id', $roadmap_id)
        ->where('has_options', true)->orderBy('order', 'asc')->get();

        $roadmapStepsNoOptions = RoadmapStep::where('roadmap_id', $roadmap_id)
        ->where('has_options', false)->orderBy('order', 'asc')->get();

        return Inertia::render('RoadmapStep/Create', [
            'roadmap' => $roadmap,
            'roadmapSteps' => $roadmapSteps,
            'roadmapStepsNoOptions' => $roadmapStepsNoOptions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($roadmap_id, RoadmapStepCreateRequest $request)
    {
        $maxOrder = RoadmapStep::where('roadmap_id', $roadmap_id)->where('has_options', true)->max('order');

        $roadmapStep = new RoadmapStep();

        $roadmapStep->roadmap_id = $roadmap_id;
        $roadmapStep->order = $maxOrder+1;
        $roadmapStep->title = $request->title;
        $roadmapStep->message_before_options = $request->message_before_options;
        $roadmapStep->message_after_options = $request->message_after_options;
        $roadmapStep->message_invalid_response = $request->message_invalid_response;
        $roadmapStep->has_options = $request->has_options == 'true' ? true : false;
        $roadmapStep->step_before_invalid_response = $request->step_before_invalid_response;
        $roadmapStep->save();

        $roadmapSteps = RoadmapStep::where('roadmap_id', $roadmap_id)->where('has_options', true)->orderBy('order', 'asc')->get();
        return redirect()->back()->with('message', 'Etapa criada com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoadmapStep  $roadmapStep
     * @return \Illuminate\Http\Response
     */
    public function show(RoadmapStep $roadmapStep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoadmapStep  $roadmapStep
     * @return \Illuminate\Http\Response
     */
    public function edit(RoadmapStep $roadmapStep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoadmapStep  $roadmapStep
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoadmapStep $roadmapStep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoadmapStep  $roadmapStep
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoadmapStep $roadmapStep)
    {
        //
    }

     /**
     * Store a order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrder($roadmap_id, Request $request)
    {
        $roadmapSteps = $request->roadmapStepsList;
        foreach ($roadmapSteps as $key => $value) {
            $step = RoadmapStep::find($value['id']);
            $step->order = $key+1;
            $step->save();
        }

        $roadmapSteps = RoadmapStep::where('roadmap_id', $roadmap_id)->where('has_options', true)->orderBy('order', 'asc')->get();

        return $roadmapSteps;
    }
}
