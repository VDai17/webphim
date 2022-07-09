<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Movie_Genre;

use Carbon\Carbon;
use File;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movie::with('category', 'movie_genre', 'genre', 'country')->orderBy('id', 'DESC')->get();
        $path= public_path().'/json/';

        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        File::put($path.'movies.json',json_encode($list));
        return view('admincp.movie.index')->with(compact('list'));
    }

    public function update_year(Request $request) {
        $data =$request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }

    public function update_season(Request $request) {
        $data =$request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }

    public function topview(Request $request) {
        $data =$request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }

    public function filter_topview(Request $request){
        $data = $request->all();
        $movie = Movie::where('topview',$data['value'])->orderBy('ngaycapnhat','DESC')->take(20)->get();
        $output = '';
        foreach($movie as $key => $mov){

              if($mov->resolution==0){
                                       $text = 'HD';
                                    }elseif($mov->resolution==1){
                                       $text = 'SD';
                                    }
                                    elseif($mov->resolution==2){
                                       $text = 'HDCam';
                                    }
                                    elseif($mov->resolution==3){
                                       $text = 'Cam';
                                    }
                                    elseif($mov->resolution==4){
                                       $text = 'FullHD';
                                    }else{
                                        $text = 'Tralier';
                                    }
            $output.='<div class="item">
                              <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                                 <div class="item-link">
                                    <img src="'.url('uploads/movie/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                    <span class="is_trailer">
                                        '.$text.'
                                    </span>
                                 </div>
                                 <p class="title">'.$mov->title.'</p>
                              </a>
                              <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                              <div style="float: left;">
                                 <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                                 <span style="width: 0%"></span>
                                 </span>
                              </div>
                           </div>';
        }
        echo $output;
    }

    public function filter_default(Request $request){
        $data = $request->all();
        // dd($data);
        $movie = Movie::where('topview',0)->orderBy('ngaycapnhat','DESC')->take(20)->get();
        $output = '';
        foreach($movie as $key => $mov){

             if($mov->resolution==0){
                                       $text = 'HD';
                                    }elseif($mov->resolution==1){
                                       $text = 'SD';
                                    }
                                    elseif($mov->resolution==2){
                                       $text = 'HDCam';
                                    }
                                    elseif($mov->resolution==3){
                                       $text = 'Cam';
                                    }
                                    elseif($mov->resolution==4){
                                       $text = 'FullHD';
                                    }else{
                                        $text = 'Tralier';
                                    }
            $output.='<div class="item">
                              <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                                 <div class="item-link">
                                    <img src="'.url('uploads/movie/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                    <span class="is_trailer">
                                        '.$text.'
                                    </span>
                                 </div>
                                 <p class="title">'.$mov->title.'</p>
                              </a>
                              <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                              <div style="float: left;">
                                 <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                                 <span style="width: 0%"></span>
                                 </span>
                              </div>
                           </div>';
        }
        echo $output;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        $list_genre = Genre::all();
        // $list = Movie::with('category', 'genre', 'country')->orderBy('id', 'DESC')->get();
        return view('admincp.movie.form')->with(compact('category', 'genre', 'country', 'list_genre'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->tags = $data['tags'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->phude = $data['phude'];
        $movie->trailer = $data['trailer'];
        $movie->resolution = $data['resolution'];
        $movie->name_eng = $data['name_eng'];
        $movie->sotap = $data['sotap'];
        $movie->thuocphim = $data['thuocphim'];
        $movie->imdb = $data['imdb'];
        $movie->slug = $data['slug'];
        $movie->hot_movie = $data['hot_movie'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        // $movie->image = $data['title'];
        $movie->category_id = $data['category_id'];
        $movie->country_id = $data['country_id'];
        $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');

        foreach($data['genre'] as $key => $gen) {
            $movie->genre_id = $gen[0];
        }



        // Post image
        $get_image = $request->file('image');
        $path = 'uploads/movie';

        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        $movie->movie_genre()->attach($data['genre']);

        return redirect()->route('movie.index');

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
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        $list_genre = Genre::all();

        // $list = Movie::orderBy('id', 'DESC')->get();
        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        return view('admincp.movie.form')->with(compact('category', 'genre', 'country', 'movie', 'list_genre', 'movie_genre'));
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
        $data = $request->all();
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->tags = $data['tags'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->phude = $data['phude'];
        $movie->trailer = $data['trailer'];
        $movie->imdb = $data['imdb'];
        $movie->sotap = $data['sotap'];
        $movie->thuocphim = $data['thuocphim'];
        $movie->resolution = $data['resolution'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug = $data['slug'];
        $movie->hot_movie = $data['hot_movie'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        // $movie->image = $data['title'];
        $movie->category_id = $data['category_id'];
        // $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');

        foreach($data['genre'] as $key => $gen) {
            $movie->genre_id = $gen[0];
        }

        // Post image
        $get_image = $request->file('image');
        $path = 'uploads/movie';

        if($get_image) {
            if(file_exists('uploads/movie/'.$movie->image)) {
                unlink('uploads/movie/'.$movie->image);
            }else{
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $movie->image = $new_image;
            }
        }
        $movie->save();
        $movie->movie_genre()->sync($data['genre']);


        return redirect()->route('movie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        // Xóa ảnh
        if(file_exists('uploads/movie/'.$movie->image)) {
            unlink('uploads/movie/'.$movie->image);
        }
        // Xóa thể loại
        Movie_Genre::whereIn('movie_id', [$movie->id])->delete();
        Episode::whereIn('movie_id', [$movie->id])->delete();
        $movie->delete();
        return Redirect()->back();

    }
}
