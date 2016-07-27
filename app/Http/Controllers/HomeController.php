<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests;
use App\Issue;
use App\Location;
use App\Tag;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function welcome()
    {
        $tagsCloud = Cache::remember('tagsCloud', 300, function() {
            return Tag::getCloud();
        });
        $locations = Location::all()->toJson();

        return view('welcome', compact('tagsCloud', 'locations'));
    }

    /**
     * Search articles
     * @return View
     */
    public function search(Request $request)
    {
        $this->validate($request, ['search' => 'required|string|max:3000']);

        $search  = $request->search;

        $articles = Article::search($search)->paginate(10);

        return view('search', compact('search', 'articles'));
    }

    /**
     * Handles contact form
     * @return Redirect
     */
    public function contact(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'message' => 'required|string|min:5|max:20000']);

        $email   = $request->email;
        $content = $request->message;

        \Mail::queue('emails.contact', compact('email', 'content'), function ($mail) use ($email) {
            $mail->from($email, 'Nouveau message de contact sur polenta.lautre.net');
        });

        return redirect('/')
            ->with('message', 'Votre message a bien été transmis.');
    }

    public function find()
    {
        $locations = Location::byCity()->get();

        return view('find', compact('locations'));
    }
}
