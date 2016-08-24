<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class ResponsesController extends Controller
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
        $response = new Response();
        $response->title = htmlspecialchars_decode($request->title);
        $response->user_id = 2; /*AuthComponent::user('id')*/;
        $response->question_id = intval($request->questionId);
        $response->save();

        $user = User::find($response->user_id);
        $question = Question::find($response->question_id);
        return response()->json([
            'title' => $response->title,
            'user' => $user->lastname,
            'question' => $question->title,
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
        $response = Response::find($id);

        $title      = '';
        $user       = '';
        $question   = '';

        if (!empty($response)) {
            $title = $response->title;
            $user = User::find($response->user_id);
            $user = $user->lastname;
            $question = Question::find($response->user_id);
            $question = $question->lastname;
        }

        return response()->json([
            'title' => $title,
            'user' => $user,
            'question' => $question,
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
        $response = Response::find($id);

        $title = '';
        $user = '';
        $question = '';

        if (!empty($response)) {
            $title = $response->title;
            $user = User::find($response->user_id);
            $user = $user->lastname;
            $question = Question::find($response->question_id);
            $question = $question->lastname;
        }

        return response()->json([
            'title' => $title,
            'user' => $user,
            'question' => $question
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
        $response = Response::find($id);
        if (!empty($request->title)) {
            $response->title = htmlspecialchars_decode($request->title);
        }
        if (!empty($request->questionId)) {
            $response->question_id = intval($request->questionId);
        }
        $response->user_id = 2; /*AuthComponent::user('id')*/;
        $response->save();

        $user = User::find($response->user_id);
        $question = Question::find($response->question_id);
        return response()->json([
            'title' => $response->title,
            'user' => $user->lastname. ' '.$user->firstname,
            'question' => $question->title,
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
        $response = Response::findOrFail($id);

        $response->delete();

        return response()->json([
            'delete' => 'La reponse a bien été supprimé'
        ]);
    }
}
