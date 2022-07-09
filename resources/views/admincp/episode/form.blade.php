@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="{{route('episode.index')}}" class="btn btn-primary">Danh sách tập phim</a>
                <div class="card-header">Quản lý tập phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!isset($episode))
                        {!! Form::open(['route'=>'episode.store', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                    @else
                        {!! Form::open(['route'=>['episode.update', $episode->id], 'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!}
                    @endif

                    {{-- <div class="form-group">
                        {!! Form::label('Movie', 'Chọn phim', []) !!}
                        {!! Form::select('movie_id',  $list_movie, isset($episode) ? $episode->movie_id : '', ['class'=>'form-control select-movie']) !!}
                    </div> --}}
                    <div class="form-group">
                        {!! Form::label('movie', 'Chọn Phim', []) !!}
                        {!! Form::select('movie_id', ['0'=>'Chọn phim' , 'Phim mới nhất'=> $list_movie], isset($episode) ? $episode->movie_id : '', ['class'=>'form-control select-movie']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Linkphim', 'Link phim', []) !!}
                        {!! Form::text('linkphim', isset($episode) ? $episode->linkphim : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    <div class="form-group">
                        @if(isset($episode))
                            <div class="form-group">
                                {!! Form::label('episode', 'Tập phim', []) !!}
                                {!! Form::text('episode', isset($episode) ? $episode->episode : '', ['class'=>'form-control','placeholder'=>'...', isset($episode) ? 'readonly' : '']) !!}
                            </div>
                        @else

                            <div class="form-group">
                                {!! Form::label('episode', 'Tập phim', []) !!}
                                <select name="episode" class="form-control" id="show_movie"></select>
                            </div>

                        @endif

                    </div>

                    @if(!isset($episode))
                        {!! Form::submit('Thêm tập phim', ['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật tập phim', ['class'=>'btn btn-success']) !!}
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
            {{-- <table class="table" id="tablephim">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Country</th>
                    <th scope="col">Active/Inactive</th>
                    <th scope="col" colspan="2">Manage</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($list as $key =>$item)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$item->title}}</td>
                        <td>
                            <img src="{{asset('uploads/movie/'.$item->image)}}" style="width:140px;">
                        </td>
                        <td>{{$item->slug}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->category->title}}</td>
                        <td>{{$item->genre->title}}</td>
                        <td>{{$item->country->title}}</td>
                        <td>
                            @if($item->status==1)
                                <p class="btn btn-info">
                                    Hiển thị
                                </p>
                            @else
                                <p class="btn btn-warning">
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
            </table> --}}
        </div>
    </div>
</div>
@endsection
