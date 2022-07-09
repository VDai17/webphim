@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý danh mục</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!isset($category))
                        {!! Form::open(['route'=>'category.store', 'method'=>'POST']) !!}
                    @else
                        {!! Form::open(['route'=>['category.update', $category->id], 'method'=>'PUT']) !!}
                    @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($category) ? $category->title : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...',
                             'id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($category) ? $category->slug : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...',
                            'id'=>'convert_slug']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($category) ? $category->description : '', ['style'=>'resize:none;', 'class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...', 'id'=>'title']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status', ['1'=>'Hiển thị', '0'=>'Không hiển thị'], isset($category) ? $category->status : '', ['class'=>'form-control']) !!}
                            {{-- {!! Form::select($name, $list, $selected, [$options]) !!} --}}
                        </div>
                        @if(!isset($category))
                            {!! Form::submit('Thêm dữ liệu', ['class'=>'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Cập nhật dữ liệu', ['class'=>'btn btn-success']) !!}
                        @endif
                    {!! Form::close() !!}
                </div>
            </div>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Description</th>
                    <th scope="col">Active/Inactive</th>
                    <th scope="col" colspan="2">Manage</th>
                  </tr>
                </thead>
                <tbody class="order_position">
                    @foreach($list as $key =>$item)
                    <tr>
                        <th scope="row" id="{{$item->id}}">{{$key+1}}</th>
                        <td>{{$item->title}}</td>
                        <td>{{$item->slug}}</td>
                        <td>{{$item->description}}</td>
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
                                ['method'=>'DELETE', 'route'=> ['category.destroy', $item->id], 'onsubmit'=>'return confirm("Bạn có chắn muốn xóa?")']
                            ) !!}
                                {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td>
                            <a href="{{route('category.edit', $item->id)}}" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
