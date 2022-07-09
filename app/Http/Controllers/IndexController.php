<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Movie_Genre;
use App\Models\Watch;
use App\Models\Episode;
use DB;


class IndexController extends Controller
{
    public function home() {
        $hot_movie = Movie::where('hot_movie', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->get();
        $hot_movie_sidebar = Movie::where('hot_movie', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(10)->get();
        $hot_movie_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->where('status', 1)->get();
        $category_home = Category::with('movie')->orderBy('id', 'DESC')->where('status', 1)->get();
        return view('pages.home')->with(compact('category', 'genre', 'country', 'category_home', 'hot_movie', 'hot_movie_sidebar', 'hot_movie_trailer'));

    }

    public function category($slug) {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->where('status', 1)->get();
        $hot_movie_sidebar = Movie::where('hot_movie', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(10)->get();
        $hot_movie_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();

        $cate_slug = Category::where('slug', $slug)->first();
        $movie = Movie::where('category_id', $cate_slug->id)->orderBy('ngaycapnhat', 'DESC')->paginate(6);
        return view('pages.category')->with(compact('category', 'genre', 'country', 'cate_slug', 'movie', 'hot_movie_sidebar', 'hot_movie_trailer'));
    }

    public function year($year) {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->where('status', 1)->get();
        $hot_movie_sidebar = Movie::where('hot_movie', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(10)->get();
        $hot_movie_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();

        $year = $year;
        $movie = Movie::where('year', $year)->orderBy('ngaycapnhat', 'DESC')->paginate(6);
        return view('pages.year')->with(compact('category', 'genre', 'country', 'movie', 'year', 'hot_movie_sidebar', 'hot_movie_trailer'));
    }

    public function tag($tag) {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->where('status', 1)->get();
        $hot_movie_sidebar = Movie::where('hot_movie', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(10)->get();
        $hot_movie_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();

        // dd($tag);
        $tag = $tag;
        $movie = Movie::where('tags', 'LIKE', '%'.$tag.'%')->orderBy('ngaycapnhat', 'DESC')->paginate(6);
        return view('pages.tag')->with(compact('category', 'genre', 'country', 'movie', 'tag', 'hot_movie_sidebar', 'hot_movie_trailer'));
    }

    public function genre($slug) {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->where('status', 1)->get();
        $hot_movie_sidebar = Movie::where('hot_movie', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(10)->get();
        $hot_movie_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();

        $gen_slug = Genre::where('slug', $slug)->first();
        //Nhiều thể loại
        $movie_genre = Movie_Genre::where('genre_id', $gen_slug->id)->get();
        $many_genre = [];
        foreach ($movie_genre as $key => $movi) {
            $many_genre[]= $movi->movie_id;
        }
        // dd($many_genre);
        $movie = Movie::whereIn('id', $many_genre)->orderBy('ngaycapnhat', 'DESC')->paginate(6);

        return view('pages.genre')->with(compact('category', 'genre', 'country', 'gen_slug', 'movie', 'hot_movie_sidebar', 'hot_movie_trailer'));
    }

    public function country($slug) {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->where('status', 1)->get();
        $hot_movie_sidebar = Movie::where('hot_movie', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(10)->get();
        $hot_movie_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();

        $country_slug = Country::where('slug', $slug)->first();
        $movie = Movie::where('country_id', $country_slug->id)->orderBy('ngaycapnhat', 'DESC')->paginate(6);

        return view('pages.country')->with(compact('category', 'genre', 'country', 'country_slug', 'movie', 'hot_movie_sidebar', 'hot_movie_trailer'));
    }

    public function movie($slug) {
        $hot_movie_sidebar = Movie::where('hot_movie', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(10)->get();
        $hot_movie_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();

        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->where('status', 1)->get();

        $movie = Movie::with('category', 'country', 'movie_genre', 'genre')->where('slug', $slug)->where('status', 1)->first();
        $movie_related = Movie::with('category', 'country', 'genre')->where('category_id', $movie->category->id)->orderBy(DB::raw('RAND()'))
        ->whereNotIn('slug', [$slug])->get();
        // Lay tap dau
        $episode_tapdau = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'ASC')->take(1)->first();
        // Lay 3 tap moi nhat
        $episode = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'DESC')->take(3)->get();
        // Lay tong so tap phim da co
        $episode_current_list = Episode::with('movie')->where('movie_id', $movie->id)->get();
        $episode_current_list_count = $episode_current_list->count();
        return view('pages.movie')->with(compact('category', 'genre', 'country', 'movie', 'movie_related', 'hot_movie_sidebar', 'hot_movie_trailer', 'episode', 'episode_tapdau', 'episode_current_list_count'));
    }


    public function search(Request $request) {
        if(isset($_GET['search'])){
            // $data = $request->all();
            $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
            $genre = Genre::orderBy('id', 'DESC')->where('status', 1)->get();
            $country = Country::orderBy('id', 'DESC')->where('status', 1)->get();
            $hot_movie_sidebar = Movie::where('hot_movie', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(10)->get();
            $hot_movie_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();
            $search = $_GET['search'];
            $search_movie = Movie::where('title', 'LIKE', '%'.$search.'%')->where('status', 1)->orderBy('id', 'DESC')->paginate(10);
            // dd($search_movie);
            return view('pages.search')->with(compact('category', 'genre', 'country', 'hot_movie_sidebar', 'hot_movie_trailer', 'search_movie', 'search'));


        }else {
            return redirect()->to('/');
        }
    }

    public function watch($slug, $tap) {
        
        // dd($tapphim);
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'DESC')->where('status', 1)->get();

        $hot_movie_sidebar = Movie::where('hot_movie', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(10)->get();
        $hot_movie_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();
        $movie = Movie::with('category', 'country', 'movie_genre', 'genre', 'episode')->where('slug', $slug)->where('status', 1)->first();
        $movie_related = Movie::with('category', 'country', 'genre')->where('category_id', $movie->category->id)->orderBy(DB::raw('RAND()'))
        ->whereNotIn('slug', [$slug])->get();
        // Lấy tập 1
        if(isset($tap)) {
            $tapphim= $tap;
            $tapphim = substr($tap, 4, 20);
            $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->first();

        } else {
            $tapphim=1;
            $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->first();
        }

        return view('pages.watch')->with(compact('tapphim', 'category', 'genre', 'country', 'hot_movie_trailer', 'hot_movie_sidebar', 'movie', 'movie_related', 'episode'));
    }

    public function episode() {
        return view('pages.episode');
    }
}
