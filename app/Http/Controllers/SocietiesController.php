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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $society = new Society();
        $society = Society::firstOrCreate(['id' => 1]);
        $society->id = 1;
        $society->name = $request->name;
        $society->presentation = htmlspecialchars_decode($request->presentation);
        $society->mentionLegal = htmlspecialchars_decode($request->mentionLegal);
        $society->cgv = htmlspecialchars_decode($request->cgv);
        $society->save();

        return response()->json([
            'name' => $society->name,
            'presentation' => $society->presentation,
            'mentionLegal' => $society->mentionLegal,
            'cgv' => $society->cgv
        ]);
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
//        $society = Society::firstOrCreate(['id' => 9]);
//        dd($request->name);
//        $society->name = $request->name;
//        $society->presentation = $request->presentation;
//        $society->mentionLegal = $request->mentionLegal;
//        $society->cgv = $request->cgv;
//        $society->save();
//
//        return response()->json([
//            'name' => $society->name,
//            'presentation' => $society->presentation,
//            'mentionLegal' => $society->mentionLegal,
//            'cgv' => $society->cgv
//        ]);
    }
}
