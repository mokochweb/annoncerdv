@extends('layouts.app')

@section('content')
    <div class="row  justify-content-center ">
        @if (isset($new))
            <form method="POST" action="{{ route('news.update',$new[0]->id) }}" class="col-md-6">
                <h4 class="text-warning" style="text-align: center; font-size: 40px">Create a news </h4>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="name">News Title</label>
                    <input type="text" name="news" value="{{ $new[0]->news ?? old('news') }}" class="form-control">
                    <div class="form-group">
                        @error('news')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content_news" id="content_news" cols="30" rows="4" class="form-control">{{ $new[0]->news ?? old('content_news') }}</textarea>
                    @error('content_news')
                    <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-sign-in"></i>update
                </button>
                <br>
                <br>
                <br>
                <table style="width: 100%">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td>News</td>
                        <td>Content</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $news = DB::select('select * from news order by id desc');
                    @endphp
                    @foreach( $news  as $new)
                        <tr>
                            <td>{{ $new->id }}</td>
                            <td>{{ $new->news }}</td>
                            <td>{{ $new->content_news }}</td>
                            <td>
                                <a href="{{ route('news.edit', $new->id) }}">edit</a>
                                <a href="{{ route('news.delete' , $new->id) }}">delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </form>
        @else
            <form method="POST" action="{{ route('news.store') }}" class="col-md-6">
                <h4 class="text-warning" style="text-align: center; font-size: 40px">Create a news </h4>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="name">News Title</label>
                    <input type="text" name="news" value="{{ old('news') }}" class="form-control">
                    <div class="form-group">
                        @error('news')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content_news" id="content_news" cols="30" rows="4" class="form-control">{{ old('content_news') }}</textarea>
                    @error('content_news')
                    <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-sign-in"></i>News
                </button>
                <br>
                <br>
                <br>
                <table style="width: 100%">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td>News</td>
                        <td>Content</td>
                        <td>Action</td>
                    </tr>
                    @php
                        $news = [] ;
                        $news = DB::select('select * from news order by id desc');
                    @endphp
                    @foreach( $news  as $new)
                        <tr>
                            <td>{{ $new->id }}</td>
                            <td>{{ $new->news }}</td>
                            <td>{{ $new->content_news }}</td>
                            <td>
                                <a href="{{ route('news.edit', $new->id) }}">edit</a>
                                <a href="{{ route('news.delete' , $new->id) }}">delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </thead>
                </table>
            </form>
        @endif
    </div>

@endsection
