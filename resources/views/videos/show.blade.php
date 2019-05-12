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
								<input disabled type="text" value="{{ $video->getStreamUrl($video->enc_video_filename) }}" id="myInput" class="form-control">
							</div>
							<div class="col-4">
								<button class="btn btn-primary" onclick="myFunction()">Copy URL</button>
							</div>
						</div>
					</div>

			 </div>
	    </div>
	</div>
@endsection
