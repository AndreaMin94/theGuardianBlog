<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

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
        $content = View::make('home')->with(['articles' => $this->getArticles(), 'sections' => Section::all()]);
        return Response::make($content, 200);
    }



    public function section($section)
    {
        if(!$section){
            $searchKey = null;
        } else {
            $searchKey = $section;
        }

    
        // return view('home', compact('articles'));
        $content = View::make('home')->with(['articles'=> $this->getArticles($section), 'sections' => Section::all()]);
        return Response::make($content, 200);
    }



    public function search(Request $req)
    {
        $searchKey = $req->input('category');
        $slug = strtolower(str_replace(' ', '-', $searchKey));
     
        $content = View::make('home')->with(['articles'=> $this->getArticles($slug), 'sections' => Section::all()]);
        return Response::make($content, 200);
    }



    public function getArticles($category = 'all')
    {
        
        if($category == 'all'){
            $fetchArticles = Http::get("https://content.guardianapis.com/search?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");

        } else {

            $searchKey = $category;

            $fetchArticles = Http::get("https://content.guardianapis.com/$searchKey?api-key=9d97b471-ee1c-473a-b293-7998a92c4182");
            if(json_decode($fetchArticles)->response->status == "error"){
                abort(404);
            }
        }

        $fetchArticles = json_decode($fetchArticles)->response->results;
      
      
        foreach($fetchArticles as $article){

            // $x = Article::where('id_string', $article->id)->get();
            // dd($article->webPublicationDate);
            $existingArticle = Article::where('id_string', $article->id)->first();
            
            if($existingArticle == null){
                $section = Section::whereName($article->sectionName)->first();
                $newArticle = Article::create([
                    'id_string' => $article->id,
                    'title' => $article->webTitle,
                    'section_id' => $section->id,
                    'url' => $article->webUrl,
                    'published_at' => $article->webPublicationDate
                ]);     
            }

        }
        if($category == 'all'){
            return Article::orderBy('id', 'desc')->take(9)->get();
        } else {
            return Section::where('slug', $category)->first()->articles->sortDesc()->take(10);
        }

    }

}