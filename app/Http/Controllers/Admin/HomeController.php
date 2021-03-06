<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Comment;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth']);
    }
    public function index(Request $time_specify){
        if(!$time_specify->only('time')){
            $time_specify->time = 0;
        }
        $time_topUser = $time_specify->time;
        $user = Auth::user();
        $time = Article::getTimePublic();
        foreach ($time as $month){
            $month['view'] = Article::getViewsOfMonth($month->value);
            $month['sum-articles'] = Article::getSumOfArticlesOfMonth($month->value);
        }
        if(count($time)){
            $topUsers = User::getTopUsers($time[$time_topUser]->value);
        }
        else{
            $topUsers = [];
        }
        $articles = Article::getArticleWithCommentsInProgress();
        return view('admin/home', [
            'user' => $user, 
            'time' => $time, 
            'topUsers' => $topUsers, 
            'time_topUser' => $time_topUser, 
            'articles' => $articles
            ]);
    }

    public function logout(){
        Auth::logout();
        return redirect('/admin/');
    }
}
