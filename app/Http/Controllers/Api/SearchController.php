<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use App\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
        ]);

        $search = new Search([
            'user_id' => Auth::user()->id,
            'keyword' => $request->keyword
        ]);

        $search->save();

        $client = new \GuzzleHttp\Client();
        $request = $client->get(
            config('services.giphy.uri') .
            "search?api_key=" . config('services.giphy.key') .
            "&q=" . $request->keyword .
            "&limit=25&offset=0&rating=G&lang=en");

        return $request->getBody()->getContents();
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
        //
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

    /**
     * Get historic of search requests by user_id
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getByUserId(Request $request)
    {
        $searches = Search::where('user_id', Auth::user()->id)->get();
        return response()->json($searches);
    }
}
