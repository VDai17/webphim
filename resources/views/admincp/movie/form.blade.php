@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="{{route('movie.index')}}" class="btn btn-primary">All Movie</a>
                <div class="card-header">Quản lý phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!isset($movie))
                        {!! Form::open(['route'=>'movie.store', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                    @else
                        {!! Form::open(['route'=>['movie.update', $movie->id], 'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!}
                    @endif
                    <div class="form-group">
                        {!! Form::label('title', 'Title', []) !!}
                        {!! Form::text('title', isset($movie) ? $movie->title : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...',
                         'id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Name English', 'Name English', []) !!}
                        {!! Form::text('name_eng', isset($movie) ? $movie->name_eng : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Trailer', 'Trailer', []) !!}
                        {!! Form::text('trailer', isset($movie) ? $movie->trailer : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('thoiluong', 'Thời lượng phim', []) !!}
                        {!! Form::text('thoiluong', isset($movie) ? $movie->thoiluong : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('sotap', 'Số tập phim', []) !!}
                        {!! Form::text('sotap', isset($movie) ? $movie->sotap : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('slug', 'Slug', []) !!}
                        {!! Form::text('slug', isset($movie) ? $movie->slug : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...',
                        'id'=>'convert_slug']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Description', []) !!}
                        {!! Form::textarea('description', isset($movie) ? $movie->description : '', ['style'=>'resize:none;', 'class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...', 'id'=>'title']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Tags', 'Tags phim', []) !!}
                        {!! Form::textarea('tags', isset($movie) ? $movie->tags : '', ['style'=>'resize:none;', 'class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...', 'id'=>'title']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('imdb', 'Điểm IMDb', []) !!}
                        {!! Form::text('imdb', isset($movie) ? $movie->imdb : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Active', 'Active', []) !!}
                        {!! Form::select('status', ['1'=>'Hiển thị', '0'=>'Không hiển thị'], isset($movie) ? $movie->status : '', ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Resolution', 'Resolution', []) !!}
                        {!! Form::select('resolution', ['1'=>'SD', '0'=>'HD', '2'=>'HDCam', '3'=>'CAM', '4'=>'FULLHD', '5'=>'Trailer'], isset($movie) ? $movie->resolution : '', ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('phude', 'Phụ đề', []) !!}
                        {!! Form::select('phude', ['0'=>'Vietsub', '1'=>'Thuyết minh'], isset($movie) ? $movie->phude : '', ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Category', 'Category', []) !!}
                        {!! Form::select('category_id', $category, isset($movie) ? $movie->category_id : '', ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Country', 'Country', []) !!}
                        {!! Form::select('country_id', $country, isset($movie) ? $movie->country_id : '', ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Genre', 'Genre', []) !!}
                        {{-- {!! Form::select('genre_id', $genre, isset($movie) ? $movie->genre_id : '', ['class'=>'form-control']) !!} --}}
                        @foreach($list_genre as $key => $gen)
                            @if(isset($movie))
                                {!! Form::checkbox('genre[]',$gen->id, isset($movie_genre) && $movie_genre->contains($gen->id) ? true : false)  !!}
                                {{-- {!! Form::checkbox('genre[]',$gen->id, $movie->genre_id==$gen->id ? 'checked' : false) !!} --}}
                            @else
                                {!! Form::checkbox('genre[]',$gen->id, '')  !!}
                            @endif
                            {!! Form::label('genre', $gen->title) !!}
                        @endforeach
                    </div>
                    <div class="form-group">
                        {!! Form::label('thuocphim', 'Thuộc thể loại phim', []) !!}
                        {!! Form::select('thuocphim', ['phimbo'=>'Phim bộ', 'phimle'=>'Phim lẻ'], isset($movie) ? $movie->thuocphim : '', ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Hot', 'Hot', []) !!}
                        {!! Form::select('hot_movie',  ['1'=>'Phim hot', '0'=>'Không hot'], isset($movie) ? $movie->hot_movie : '', ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Image', 'Image', []) !!}
                        {!! Form::file('image', ['class'=>'form-control-file']) !!}
                        @if(isset($movie))
                            <img src="{{asset('uploads/movie/'.$movie->image)}}" style="width:140px;">
                        @endif
                    </div>
                    @if(!isset($movie))
                        {!! Form::submit('Thêm dữ liệu', ['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật dữ liệu', ['class'=>'btn btn-success']) !!}
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
