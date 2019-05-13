@extends('layouts.app')
@section('title')
	{{ $video->title }}
@endsection

@section('content')
@section('og-tags')
	<meta property="og:url"                content="{{ url('/videos/' . $video->uid) }}" />
	<meta property="og:type"               content="article" />
	<meta property="og:title"              content="{{ $video->title }} " />
	<meta property="og:video"              content="{{ $video->getStreamUrl($video->enc_video_filename) }}" />
	<meta property="og:image"              content="{{ $video->getThumbnail($video->enc_video_filename) }}" />

	@if($video->description)
		<meta property="og:description"        content="{{$video->description}}" />
	@endif
@endsection
	<div class="container">
	    <div class="row">
	        <div class="col-md-8 col-md-offset-2">
				@if ($video->isPrivate() && Auth::check() && $video->ownerByUser(Auth::user()))
					<div class="alert alert-info">Your video is currently private. Only you can see it.</div>
				@endif
				@if ($video->isProcessed() && $video->canBeAccessed(Auth::user()))
					<video-player
						video-uuid="{{ $video->uuid }}"
						video-url="{{ $video->getStreamUrl($video->enc_video_filename) }}"
						thumbnail-url="{{ $video->getThumbnail($video->enc_video_filename) }}"></video-player>
				@endif
				@if (!$video->isProcessed())
					<div class="video-placeholder">
						<div class="video-placeholder__header">
							This video is processing. Come back a little bit later.
						</div>
					</div>
				@elseif (!$video->canBeAccessed(Auth::user()))
					<div class="video-placeholder">
						<div class="video-placeholder__header">
							This video is private.
						</div>
					</div>
				@endif
	            <div class="panel panel-default">
	                <div class="panel-body">
	                    <h4>{{ $video->title }}</h4>
						<div class="pull-right">
							<div class="video__views">
								{{ $video->viewCount() }} {{ str_plural('view', $video->viewCount()) }}
							</div>
						</div>
	                </div>
	            </div>
				@if($video->caption)
					<div class="panel panel-default">
		                <div class="panel-body">
		                    {!! nl2br(e($video->caption)) !!}
		                </div>
		            </div>
				@endif

					<div class="panel-heading">
						<div class="row form-group">
							<div class="col-8 col-md-8">
								<input disabled type="text" value="{{url()->current()}}" id="myInput" class="form-control">
							</div>
							<div class="col-4">
								<button class="btn btn-primary" onclick="myFunction()">Copy URL</button>
							</div>
						</div>
					</div>
					<div class="row post-share ">
						<div class="col-2 col-lg-3 col-lg-offset-3">
							<div class="title">
								<h3>Share On:</h3>
							</div>
						</div>
						<div class="col-4 col-lg-8">
							<div class="col-3 col-lg-3">
								<a href="http://www.facebook.com/sharer.php?u={{url()->current()}}" target="_blank" rel="nofollow"><img src="{{ asset('images/facebook.png') }}" class="socials"></a>
							</div>
							<div class="col-3 col-lg-3">
								<a href="https://plus.google.com/share?url={{url()->current()}}" target="_blank" rel="nofollow"><img src="{{ asset('images/google.png') }}" class="socials"></a>
							</div>
							<div class="col-3 col-lg-3">
								<a href="http://twitter.com/share?text={{ $video->title }}&url={{url()->current()}}" target="_blank" rel="nofollow"><img src="{{ asset('images/twitter.png') }}" class="socials"></a>
							</div>
							<div class="col-3 col-lg-3">
								<a href="http://www.reddit.com/submit?url={{url()->current()}}" target="_blank" rel="nofollow"><img src="{{ asset('images/reddit.png') }}" class="socials"></a>
							</div>
						</div>

					</div>
			</div>
	    </div>
	</div>
@endsection

@section('css')
	<style>
		.post-share .socials img {
			max-height: 50px!important;
		}
	</style>
@endsection
