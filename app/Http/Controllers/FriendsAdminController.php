<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Http\Requests;
use Illuminate\Http\Request;

class FriendsAdminController extends Controller
{
    /**
     * Validation rules
     * @var array
     */
    private $rules = [
        'name' => 'required|string|max:255',
        'url'  => 'required|url|max:255',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $friends = Friend::orderBy('name', 'asc')->paginate(10);

        return view('admin.friends.index', compact('friends'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.friends.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $friend = new Friend();

        $this->saveFriend($request, $friend);

        return redirect()
            ->route('admin.friend.index')
            ->with('message', 'Copain-ine ' . $friend->name . ' a bien été créé-e');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $friend = Friend::findOrFail($id);

        return view('admin.friends.edit', compact('friend'));
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
        $this->validate($request, $this->rules);

        $friend = Friend::findOrFail($id);

        $this->saveFriend($request, $friend);

        return redirect()
            ->route('admin.friend.index')
            ->with('message', 'Les infos de ' . $friend->name . ' ont bien été mises à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $name = Friend::findOrFail($id)->name;
        Friend::destroy($id);

        return redirect()
            ->route('admin.friend.index')
            ->with('message', 'Copain-ine ' . $name . ' a bien été supprimé-e :/');
    }

    /**
     * Save friend to DB
     * @param  Request $request
     * @param  Friend  $friend
     * @return Friend
     */
    public function saveFriend(Request $request, Friend $friend) : Friend
    {
        $friend->name = $request->name;
        $friend->url  = $request->url;

        $friend->save();

        return $friend;
    }
}
