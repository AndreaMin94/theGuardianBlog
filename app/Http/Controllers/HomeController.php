<?php

namespace App\Http\Controllers;

use App\Models\Article;

use App\Models\Section;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home', compact('articles'));
        $content = View::make('home')->with(['articles' => $this->getArticles(), 'sections' => $this->getSections()]);
        return Response::make($content, 200);
    }



    public function category($category)
    {
        if(!$category){
            $searchKey = null;
        } else {
            $searchKey = $category;
        }

    
        // return view('home', compact('articles'));
        $content = View::make('home')->with(['articles'=> $this->getArticles(), 'sections' => $this->getSections()]);
        return Response::make($content, 200);
    }



    public function search(Request $req)
    {

        $searchKey = $req->input('category');
    
        // return view('home', compact('articles'));
        $content = View::make('home')->with(['articles'=> $this->getArticles($searchKey), 'sections' => $this->getSections()]);
        return Response::make($content, 200);
    }


    public function getSections()
    {
        $availableSection =  $data = Http::get("https://content.guardianapis.com/sections?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");
        $availableSection = json_decode($availableSection)->response->results;

        $sections = collect([]);

        foreach ($availableSection as $section) {
            $newSection = new Section();
            $newSection->name = $section->webTitle;
            $sections->push($newSection);
        }

        return $sections;
    }

    public function getArticles($category = 'all')
    {
        
        if($category == 'all'){
            $data = Http::get("https://content.guardianapis.com/search?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");
        } else {

            $searchKey = $category;

            $data = Http::get("https://content.guardianapis.com/$searchKey?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");
            if(json_decode($data)->response->status == "error"){
                abort(404);
            }
        }

        $data = json_decode($data)->response->results;

        $articles = collect([]);
      
        foreach($data as $d){
            $newArticle = new Article();
            $newArticle->title = $d->webTitle;
            $newArticle->category = $d->sectionName;
            $newArticle->url = $d->webUrl;
            $newArticle->webPublicationDate = $d->webPublicationDate;
            $articles->push($newArticle);
        }

        return $articles;

    }

}
