@extends(adminTheme().'layouts.app')
@section('title')<title>{{ websiteTitle('Message') }}</title>@endsection
@section('contents')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2"><h3 class="content-header-title mb-0">Message from {{ $item->name }}</h3></div>
    <div class="content-header-right col-md-6 col-12 mb-2 text-md-right">
        <a class="btn btn-outline-primary" href="{{ route('admin.portfolio.messages') }}"><i class="fa fa-arrow-left"></i> Back</a>
        <a class="btn btn-primary" href="mailto:{{ $item->email }}"><i class="fa fa-reply"></i> Reply by email</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><b>Name:</b> {{ $item->name }}</p>
    <p><b>Email:</b> {{ $item->email }}</p>
    @if($item->subject)<p><b>Subject:</b> {{ $item->subject }}</p>@endif
    <p><b>Date:</b> {{ $item->created_at->format('d M Y, h:i A') }}</p>
    <hr>
    <p style="white-space:pre-line">{{ $item->message }}</p>
</div></div>
@endsection
