<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticle;
use App\Http\Requests\StoreImage;
use App\Http\Requests\UpdateArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Article::count()){
//            show all article even if deleted articles
//            $articles = Article::withTrashed()->latest()->paginate(3);
//            show only deleted articles
//            $articles = Article::onlyTrashed()->latest()->paginate(3);
//            to undelete article use
//            $articles->restore();
        $articles = Article::getArticles();
        }
        else {
            $articles = [];
        }
        return view('admin.articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::getCategory();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticle $request)
    {
        $thumbnail = new StoreImage(['image' => $request->thumbnail]);

        if(Article::saveArticle($request)){
            return redirect('admin/articles')->with('success', 'Create successfully');
        }
        else{
            return redirect('admin.articles.create')->with('error', 'Please check your input!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        $article->id_author = Article::find($id)->author;
        return view('articles.show', compact('article'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);
        if(Auth::user()->id !== $article->author->id){
            return redirect('admin/articles')->with('error', 'Cannot edit this article because it is not yours.');
        }
        $categories = Category::getCategory();
        return view('admin.articles.edit', ['article' => $article, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticle $request, $id)
    {
        if(Article::updateArticle($id, $request)){
            return redirect('admin/articles')->with("success", "Update successfully!");
        }
        return redirect('admin/articles')->with("error", "Something wrong!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();
        return redirect('admin/articles')->with('success', 'Delete successfully!');
    }
}
