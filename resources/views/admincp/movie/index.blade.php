@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{route('movie.create')}}" class="btn btn-primary">Add Movie</a>
            <table class="table" id="tablephim">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    {{-- <th scope="col">Slug</th> --}}
                    {{-- <th scope="col">Tags phim</th> --}}
                    <th scope="col">Thời lượng</th>
                    <th scope="col">Số tập</th>
                    <th scope="col">Image</th>
                    <th scope="col">Điểm IMDb</th>
                    {{-- <th scope="col">Description</th> --}}
                    <th scope="col">Category</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Country</th>
                    <th scope="col">Thuộc thể loại phim</th>
                    <th scope="col">Hot-Movies</th>
                    <th scope="col">Định dạng</th>
                    <th scope="col">Phụ đề</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Ngày cập nhật</th>
                    <th scope="col">Seasons</th>
                    <th scope="col">Năm phim</th>
                    <th scope="col">Top views</th>
                    <th scope="col">Active</th>
                    <th scope="col" colspan="2">Manage</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($list as $key =>$item)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$item->title}}</td>
                        {{-- <td>{{$item->slug}}</td> --}}
                        {{-- <td>{{$item->tags}}</td> --}}
                        <td>{{$item->thoiluong}}</td>
                        <td>{{$item->sotap}}</td>
                        <td>
                            <img src="{{asset('uploads/movie/'.$item->image)}}" style="width:140px;">
                        </td>
                        <td>
                            <span class="badge badge-pill badge-secondary">
                                {{$item->imdb}}

                            </span>
                        </td>
                        {{-- <td>{{$item->description}}</td> --}}
                        <td>{{$item->category->title}}</td>
                        <td>
                            @foreach($item->movie_genre as $gen)
                            <span class="badge badge-pill badge-dark">{{$gen->title}}</span>
                                {{-- {{$gen->title}} --}}
                            @endforeach
                        </td>
                        <td>{{$item->country->title}}</td>
                        <td>
                            @if($item->thuocphim=='phimbo')
                                <p class="badge badge-pill badge-success">
                                    Phim bộ
                                </p>
                            @else
                                <p class="badge badge-pill badge-success">
                                    Phim lẻ
                                </p>
                            @endif
                        </td>
                        <td>
                            @if($item->hot_movie==1)
                                <p class="badge badge-pill badge-danger">
                                    Hot
                                </p>
                            @else
                                <p class="badge badge-pill badge-dark">
                                    Không
                                </p>
                            @endif
                        </td>
                        <td>
                            @if($item->resolution==0)
                                <p class="badge badge-pill badge-info">
                                    HD
                                </p>
                            @elseif($item->resolution==1)
                                <p class="badge badge-pill badge-info">
                                    SD
                                </p>
                            @elseif($item->resolution==2)
                                <p class="badge badge-pill badge-info">
                                    HDCam
                                </p>
                            @elseif($item->resolution==3)
                                <p class="badge badge-pill badge-info">
                                    CAM
                                </p>
                            @elseif($item->resolution==4)
                                <p class="badge badge-pill badge-info">
                                    FULLHD
                                </p>
                            @else
                                <p class="badge badge-pill badge-danger">
                                    Trailer
                                </p>
                            @endif
                        </td>
                        <td>
                            @if($item->phude==0)
                                <p class="badge badge-pill badge-success">
                                    Vietsub
                                </p>
                            @else
                                <p class="badge badge-pill badge-warning">
                                    Thuyết minh
                                </p>
                            @endif
                        </td>
                        <td>{{$item->ngaytao}}</td>
                        <td>{{$item->ngaycapnhat}}</td>
                        <td>
                            {!! Form::selectRange('season', 0, 10, isset($item->season)?$item->season : '', ['class'=>'select-season', 'id'=>$item->id]) !!}
                        </td>
                        <td>
                            <form method="POST">
                                @csrf
                                {!! Form::selectYear('year', 2005, 2022, isset($item->season)?$item->season : '', ['class'=>'select-year', 'id'=>$item->id]) !!}
                            </form>
                        </td>
                        <td>
                            {!! Form::select('topview', ['0'=>'Ngày', '1'=>'Tuần', '2'=>'Tháng'], isset($movie) ? $movie->topview : '', ['class'=>'select-topview', 'id'=>$item->id]) !!}
                        </td>
                        <td>
                            @if($item->status==1)
                                <p class="badge badge-pill badge-success">
                                    Hiển thị
                                </p>
                            @else
                                <p class="badge badge-pill badge-danger">
                                    Không hiển thị
                                </p>
                            @endif
                        </td>

                        <td>
                            {!! Form::open(
                                ['method'=>'DELETE', 'route'=> ['movie.destroy', $item->id], 'onsubmit'=>'return confirm("Bạn có chắn muốn xóa?")']
                            ) !!}
                                {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td>
                            <a href="{{route('movie.edit', $item->id)}}" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
