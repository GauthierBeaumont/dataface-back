<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Society;

class SocietiesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $society = Society::find(1);

        $name = '';
        $presentation = '';
        $mentionLegal = '';
        $cgv = '';

        if (!empty($society)) {
            $name = $society->name;
            $presentation = $society->presentation;
            $mentionLegal = $society->mentionLegal;
            $cgv = $society->mentionLegal;
        }

        return response()->json([
            'name' => $name,
            'presentation' => $presentation,
            'mentionLegal' => $mentionLegal,
            'cgv' => $cgv
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $society = Society::find(1);
//
//        return response()->json([
//            'name' => $society->name,
//            'presentaion' => $society->presentation,
//            'mentionLegal' => $society->mentionLegal,
//            'cgv' => $society->mentionLegal
//        ]);
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
        $society = Society::firstOrCreate($id);
        $society->name = $request->name;
        $society->description = $request->description;
        $society->mentionLegal = $request->mentionLegal;
        $society->cgv = $request->cgv;
        $society->save();

        return response()->json([
            'name' => $society->name,
            'presentaion' => $society->presentation,
            'mentionLegal' => $society->mentionLegal,
            'cgv' => $society->mentionLegal
        ]);
    }
}
