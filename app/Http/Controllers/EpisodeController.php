<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use Carbon\Carbon;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_episode = Episode::with('movie')->orderBy('movie_id', 'DESC')->get();
        // return response()->json($list_episode);
        return view('admincp.episode.index')->with(compact('list_episode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $list_movie = Movie::orderBy('id', 'DESC')->pluck('title', 'id', 'thuocphim');
        return view('admincp.episode.form')->with(compact('list_movie'));
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
        $episode = new Episode();
        $episode->movie_id = $data['movie_id'];
        $episode->linkphim = $data['linkphim'];
        $episode->episode = $data['episode'];
        $episode->create_at = Carbon::now('Asia/Ho_Chi_Minh');
        $episode->update_at = Carbon::now('Asia/Ho_Chi_Minh');
        $episode->save();
        return redirect()->back();
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
        $episode = Episode::find($id);
        $list_movie = Movie::orderBy('id', 'DESC')->pluck('title', 'id');
        // return response()->json($episode);
        return view('admincp.episode.form')->with(compact('episode', 'list_movie'));
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
        $episode = Episode::find($id);
        $episode->movie_id = $data['movie_id'];
        $episode->linkphim = $data['linkphim'];
        $episode->episode = $data['episode'];
        $episode->create_at = Carbon::now('Asia/Ho_Chi_Minh');
        $episode->update_at = Carbon::now('Asia/Ho_Chi_Minh');
        $episode->save();
        return redirect()->to('episode');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $episode = Episode::find($id)->delete();
        return redirect()->to('episode');
    }

    public function select_movie(){
        $id = $_GET['id'];
        $movie = Movie::find($id);
        $output='<option>---Chọn tập phim---</option>';
        if($movie->thuocphim=='phimbo') {
            for($i=1;$i<=$movie->sotap;$i++){
                $output.='<option value="'.$i.'">'.$i.'</option>';
            }
        }else {
            $output.='<option value="HD">HD</option><option value="FULLHD">FULLHD</option>';
        }

        echo $output;
    }
}
