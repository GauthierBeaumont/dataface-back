<?php

namespace App\Http\Controllers;

use App\Support;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class SupportsController extends Controller
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
        $support = new Support();
        $support->question = htmlspecialchars_decode($request->question);
        $support->response = htmlspecialchars_decode($request->response);
        $support->save();

        return response()->json([
            'question' => $support->question,
            'response' => $support->response,
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
        $support = Support::find($id);

        $question = '';
        $response = '';

        if (!empty($support)) {
            $question = $support->question;
            $response = $support->response;
        }

        return response()->json([
            'question' => $question,
            'response' => $response,
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
        $support = Support::findOrFail($id);

        $question = '';
        $response = '';

        if (!empty($support)) {
            $question = $support->question;
            $response = $support->response;
        }

        return response()->json([
            'question' => $question,
            'response' => $response,
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
        $support = $support = Support::find(1);
        $support->question = htmlspecialchars_decode($request->question);
        $support->response = htmlspecialchars_decode($request->response);
        $support->save();

        return response()->json([
            'question' => $support->question,
            'response' => $support->response,
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
        $support = Support::findOrFail($id);

        $support->delete();

        return response()->json([
            'delete' => 'L\'élèment a bien été supprimé'
        ]);
    }

    /* Demande de suppression d'un utilisateur */

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function callDelete($email) {
        $user = User::findOrfail($email);
        return response()->json([
            'delete' => $user->id
        ]);
    }
}
