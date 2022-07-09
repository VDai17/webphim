@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý tập phim</div>
            </div>
            <a href="{{route('episode.create')}}" class="btn btn-primary">Thêm tập phim</a>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên phim</th>
                    <th scope="col">Tập phim</th>
                    <th scope="col">Linh phim</th>
                    {{-- <th scope="col">Trạng thái</th> --}}
                    <th scope="col" colspan="2">Quản lý</th>
                  </tr>
                </thead>
                <tbody class="order_position">
                    @foreach($list_episode as $key =>$episode)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$episode->movie->title}}</td>
                            <td>{{$episode->episode}}</td>
                            <td>{!!$episode->linkphim!!}</td>
                            {{-- <td>
                                @if($episode->status==1)
                                    <p class="btn btn-info">
                                        Hiển thị
                                    </p>
                                @else
                                    <p class="btn btn-warning">
                                        Không hiển thị
                                    </p>
                                @endif
                            </td> --}}
                            <td>
                                {!! Form::open(
                                    ['method'=>'DELETE', 'route'=> ['episode.destroy', $episode->id], 'onsubmit'=>'return confirm("Bạn có chắn muốn xóa?")']
                                ) !!}
                                    {!! Form::submit('Xóa', ['class'=>'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                            <td>
                                <a href="{{route('episode.edit', $episode->id)}}" class="btn btn-warning">Sửa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
