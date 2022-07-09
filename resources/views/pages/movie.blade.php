@extends('layout')
@section('content')
<div class="row container" id="wrapper">
    <div class="halim-panel-filter">
       <div class="panel-heading">
          <div class="row">
             <div class="col-xs-6">
                <div class="yoast_breadcrumb hidden-xs"><span><span><a href="{{route('category', $movie->category->slug)}}">{{$movie->category->title}}</a> » <span>
                    <a href="{{route('category', $movie->country->slug)}}">{{$movie->country->title}}</a> »
                    @foreach($movie->movie_genre as $key => $movi)
                        <a href="{{route('genre', $movie->genre->slug)}}" rel="category tag">{{$movi->title}}</a> »
                    @endforeach
                    <span class="breadcrumb_last" aria-current="page">{{$movie->title}}</span></span></span></span></div>
                </div>
          </div>
       </div>
       <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
          <div class="ajax"></div>
       </div>
    </div>
    <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
       <section id="content" class="test">
          <div class="clearfix wrap-content">

             <div class="halim-movie-wrapper">
                <div class="title-block">
                   <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="38424">
                      <div class="halim-pulse-ring"></div>
                   </div>
                   <div class="title-wrapper" style="font-weight: bold;">
                      Bookmark
                   </div>
                </div>
                <div class="movie_info col-xs-12">
                   <div class="movie-poster col-md-3">
                      <img class="movie-thumb" src="{{asset('uploads/movie/'.$movie->image)}}" alt="{{$movie->title}}">
                        @if($movie->resolution!=5)
                            @if($episode_current_list_count>0)
                            <div class="bwa-content">
                                <div class="loader"></div>
                                <a href="{{url('xem-phim/'.$movie->slug.'/tap-'.$episode_tapdau->episode)}}" class="bwac-btn">
                                <i class="fa fa-play"></i>
                                </a>
                            </div>
                            @endif
                            @else
                            <a href="#watch_trailer" style="display: block;" class="btn btn-primary watch_trailer">Xem Trailer</a>

                        @endif
                   </div>
                   <div class="film-poster col-md-9">
                      <h1 class="movie-title title-1" style="display:block;line-height:35px;margin-bottom: -14px;color: #ffed4d;text-transform: uppercase;font-size: 18px;">{{$movie->title}}</h1>
                      <h2 class="movie-title title-2" style="font-size: 12px;">{{$movie->name_eng}}</h2>
                      <ul class="list-info-group">
                         <li class="list-info-group-item"><span>Trạng Thái</span> : <span class="quality">
                            @if($movie->resolution==0)
                                HD
                            @elseif($movie->resolution==1)
                                SD
                            @elseif($movie->resolution==2)
                                HDCam
                            @elseif($movie->resolution==3)
                                CAM
                            @elseif($movie->resolution==4)
                                FULLHD
                            @else
                                Trailer
                            @endif
                        </span>
                        @if($movie->resolution!=5)
                            <span class="episode">
                                @if($movie->phude==0)
                                    Vietsub
                                @else
                                    Thuyết minh
                                @endif
                            </span>
                        @endif
                        </li>
                        @if($movie->imdb!=0)
                         <li class="list-info-group-item"><span>Điểm IMDb</span> : <span class="imdb">{{$movie->imdb}}</span></li>
                         @endif
                         @if($movie->season!=0)
                            <li class="list-info-group-item"><span>Seasons</span> : {{$movie->season}}</li>
                         @endif
                         <li class="list-info-group-item"><span>Thời lượng</span> : {{$movie->thoiluong}}</li>
                         <li class="list-info-group-item"><span>Tập phim</span> :
                            @if($movie->thuocphim=='phimbo')
                                {{$episode_current_list_count}}/{{$movie->sotap}}-
                                @if($episode_current_list_count==$movie->sotap)
                                    Hoàn thành
                                @else
                                    Đang cập nhật
                                @endif
                            @else
                                HD
                            @endif
                        </li>
                         <li class="list-info-group-item">
                             <span>Thể loại</span> :
                             @foreach($movie->movie_genre as $key => $movi)
                                <a href="{{route('genre', $movie->genre->slug)}}" rel="category tag">{{$movi->title}}</a>
                             @endforeach
                             {{-- <a href="{{route('genre', $movie->genre->slug)}}" rel="category tag">{{$movie->genre->title}}</a> --}}
                        </li>
                        <li class="list-info-group-item">
                            <span>Danh mục phim</span> : <a href="{{route('category', $movie->category->slug)}}" rel="category tag">{{$movie->category->title}}</a>
                       </li>
                         <li class="list-info-group-item"><span>Quốc gia</span> : <a href="{{route('country', $movie->country->slug)}}" rel="tag">{{$movie->country->title}}</a></li>
                         <li class="list-info-group-item">
                            <span>Tập phim mới nhất</span> :
                            @if($episode_current_list_count>0)
                                @if($movie->thuocphim=='phimbo')
                                    @foreach($episode as $key =>$ep)
                                    <a href="{{url('xem-phim/'.$ep->movie->slug.'/tap-'.$ep->episode)}}" rel="tag">Tập {{$ep->episode}}</a>
                                    @endforeach
                                @elseif($movie->thuocphim=='phimle')
                                    @foreach($episode as $key =>$ep)
                                        <a href="{{url('xem-phim/'.$ep->movie->slug.'/tap-'.$ep->episode)}}" rel="tag">{{$ep->episode}}</a>
                                    @endforeach
                                @endif
                            @else
                                Đang cập nhật
                            @endif
                        </li>
                         {{-- <li class="list-info-group-item"><span>Đạo diễn</span> : <a class="director" rel="nofollow" href="https://phimhay.co/dao-dien/cate-shortland" title="Cate Shortland">Cate Shortland</a></li>
                         <li class="list-info-group-item last-item" style="-overflow: hidden;-display: -webkit-box;-webkit-line-clamp: 1;-webkit-box-flex: 1;-webkit-box-orient: vertical;"><span>Diễn viên</span> : <a href="" rel="nofollow" title="C.C. Smiff">C.C. Smiff</a>, <a href="" rel="nofollow" title="David Harbour">David Harbour</a>, <a href="" rel="nofollow" title="Erin Jameson">Erin Jameson</a>, <a href="" rel="nofollow" title="Ever Anderson">Ever Anderson</a>, <a href="" rel="nofollow" title="Florence Pugh">Florence Pugh</a>, <a href="" rel="nofollow" title="Lewis Young">Lewis Young</a>, <a href="" rel="nofollow" title="Liani Samuel">Liani Samuel</a>, <a href="" rel="nofollow" title="Michelle Lee">Michelle Lee</a>, <a href="" rel="nofollow" title="Nanna Blondell">Nanna Blondell</a>, <a href="" rel="nofollow" title="O-T Fagbenle">O-T Fagbenle</a></li> --}}
                      </ul>
                      <div class="movie-trailer hidden"></div>
                   </div>
                </div>
             </div>
             <div class="clearfix"></div>
             <div id="halim_trailer"></div>
             <div class="clearfix"></div>
             <div class="section-bar clearfix">
                <h2 class="section-title"><span style="color:#ffed4d">Nội dung phim</span></h2>
             </div>
             <div class="entry-content htmlwrap clearfix">
                <div class="video-item halim-entry-box">
                   <article id="post-38424" class="item-content">
                      {{$movie->description}}
                   </article>
                </div>
             </div>
             {{-- Tags phim --}}
             <div class="section-bar clearfix">
                <h2 class="section-title"><span style="color:#ffed4d">Tags phim</span></h2>
             </div>
             <div class="entry-content htmlwrap clearfix">
                <div class="video-item halim-entry-box">
                   <article id="post-38424" class="item-content">
                        @if($movie->tags!=NULL)
                            @php
                                $tags = array();
                                $tags = explode(',', $movie->tags);
                                // print_r($tags);
                            @endphp
                            @foreach($tags as $key =>$tag)
                                <a href="{{url('tag/'.$tag)}}">{{$tag}}</a>
                            @endforeach
                        @else
                            {{$movie->title}}
                        @endif
                   </article>
                </div>
             </div>
             {{-- Trailer phim --}}
             @if($movie->trailer!=NULL)
             <div class="section-bar clearfix">
                <h2 class="section-title"><span style="color:#ffed4d">Tags phim</span></h2>
             </div>
             <div class="entry-content htmlwrap clearfix">
                <div class="video-item halim-entry-box">
                   <article id="watch_trailer" class="item-content">
                        <iframe width="100%" height="360" src="https://www.youtube.com/embed/{{$movie->trailer}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                   </article>
                </div>
             </div>
             @endif
             {{-- Comment Facebook --}}
             <div class="section-bar clearfix">
                <h2 class="section-title"><span style="color:#ffed4d">Bình luận</span></h2>
             </div>
             <div class="entry-content htmlwrap clearfix">
                @php
                    $current_url = Request::url();
                @endphp
                <div class="video-item halim-entry-box">
                   <article id="post-38424" class="item-content" style="background: aliceblue">

                        <div class="fb-comments" data-href="{{$current_url}}" data-width="100%" data-numposts="10"></div>
                   </article>
                </div>
             </div>
          </div>
       </section>
       <section class="related-movies">
          <div id="halim_related_movies-2xx" class="wrap-slider">
             <div class="section-bar clearfix">
                <h3 class="section-title"><span>CÓ THỂ BẠN MUỐN XEM</span></h3>
             </div>
             <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                 @foreach($movie_related as $key => $rel)
                <article class="thumb grid-item post-38498">
                   <div class="halim-item">
                      <a class="halim-thumb" href="{{route('movie', $rel->slug)}}" title="{{$rel->title}}">
                         <figure><img class="lazy img-responsive" src="{{asset('uploads/movie/'.$rel->image)}}" alt="{{$rel->title}}" title="{{$rel->title}}"></figure>
                         <span class="status">
                            @if($rel->resolution==0)
                                HD
                            @elseif($rel->resolution==1)
                                SD
                            @elseif($rel->resolution==2)
                                HDCam
                            @elseif($rel->resolution==3)
                                CAM
                            @elseif($rel->resolution==4)
                                FULLHD
                            @else
                                Trailer
                            @endif
                        </span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                            @if($rel->phude==0)
                                Vietsub
                                @if($rel->season!=0)
                                    - Season {{$rel->season}}
                                @endif
                            @else
                                Thuyết minh
                                @if($rel->season!=0)
                                    - Season {{$rel->season}}
                                @endif
                            @endif
                        </span>
                         <div class="icon_overlay"></div>
                         <div class="halim-post-title-box">
                            <div class="halim-post-title ">
                               <p class="entry-title">{{$rel->title}}</p>
                               <p class="original_title">{{$rel->eng}}</p>
                            </div>
                         </div>
                      </a>
                   </div>
                </article>
                @endforeach

             </div>
             <script>
                $(document).ready(function($) {
                var owl = $('#halim_related_movies-2');
                owl.owlCarousel({loop: true,margin: 4,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 600: {items:4},1000: {items: 4}}})});
             </script>
          </div>
       </section>
    </main>
    {{-- <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4"></aside> --}}
    {{-- Sidebar --}}
    @include('pages.include.sidebar');
 </div>
 @endsection
