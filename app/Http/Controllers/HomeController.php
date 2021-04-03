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
        $availableSection =  $data = Http::get("https://content.guardianapis.com/sections?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");
        $availableSection = json_decode($availableSection)->response->results;

        $sections = collect([]);

        foreach ($availableSection as $section) {
            $newSection = new Section();
            $newSection->name = $section->webTitle;
            $sections->push($newSection);
        }

        // $uri = 'https://content.guardianapis.com/';
        // $apiKey = '?api-key=9d97b471-ee1c-473a-b293-7998a92c4182';

        $data = Http::get("https://content.guardianapis.com/search?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");
    

        $data = json_decode($data)->response->results;
        // dd($data);
        // dd($data->response->results);
        $articles = collect([]);
      
        foreach($data as $d){
            $newArticle = new Article();
            $newArticle->title = $d->webTitle;
            $newArticle->category = $d->sectionName;
            $newArticle->url = $d->webUrl;
            $newArticle->webPublicationDate = $d->webPublicationDate;
            $articles->push($newArticle);
        }
        
    
        // return view('home', compact('articles'));
        $content = View::make('home')->with(['articles' => $data, 'sections' => $sections]);
        return Response::make($content, 200);
    }



    public function category($category)
    {
        if(!$category){
            $searchKey = 'search';
        } else {
            $searchKey = $category;
        }

       

        $availableSection =  $data = Http::get("https://content.guardianapis.com/sections?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");
        $availableSection = json_decode($availableSection)->response->results;

        $sections = collect([]);

        foreach ($availableSection as $section) {
            $newSection = new Section();
            $newSection->name = $section->webTitle;
            $sections->push($newSection);
        }
        
        $data = Http::get("https://content.guardianapis.com/$category?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");
        if(json_decode($data)->response->status == "error"){
            abort(404);
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
        
    
        // return view('home', compact('articles'));
        $content = View::make('home')->with(['articles'=> $data, 'sections' => $sections]);
        return Response::make($content, 200);
    }











    public function search(Request $req)
    {

        $searchKey = $req->input('category');
        
        $data = Http::get("https://content.guardianapis.com/$searchKey?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");
        if(json_decode($data)->response->status == "error"){
            abort(404);
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
        
    
        // return view('home', compact('articles'));
        $content = View::make('home')->with('articles', $data);
        return Response::make($content, 200);
    }
}
