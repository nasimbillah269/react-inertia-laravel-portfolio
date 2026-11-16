@extends(adminTheme().'layouts.app')
@section('title')<title>{{ websiteTitle('Dashboard') }}</title>@endsection
@section('contents')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Portfolio Dashboard</h3>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-2 text-md-right">
        <a class="btn btn-primary" href="{{ route('index') }}" target="_blank"><i class="fa fa-globe"></i> View Website</a>
        <a class="btn btn-outline-primary" href="{{ route('admin.portfolio.settings') }}"><i class="fa fa-cog"></i> Settings</a>
    </div>
</div>
@include(adminTheme().'alerts')

<div class="row">
    @php($colors = ['#7c3aed', '#2563eb', '#db2777', '#0891b2', '#ea580c', '#16a34a', '#9333ea'])
    @foreach($counts as $key => $c)
    <div class="col-xl-3 col-md-4 col-sm-6">
        <a href="{{ $key === 'blogs' ? route('admin.posts') : route('admin.portfolio.index', $key) }}">
        <div class="card" style="border-left:4px solid {{ $colors[$loop->index % count($colors)] }}">
            <div class="card-body">
                <h2 class="mb-0" style="color:{{ $colors[$loop->index % count($colors)] }}">{{ $c['count'] }}</h2>
                <span class="text-muted">{{ $c['title'] }}</span>
            </div>
        </div>
        </a>
    </div>
    @endforeach
    <div class="col-xl-3 col-md-4 col-sm-6">
        <a href="{{ route('admin.portfolio.messages') }}">
        <div class="card" style="border-left:4px solid #dc2626">
            <div class="card-body">
                <h2 class="mb-0" style="color:#dc2626">{{ $unread }}</h2>
                <span class="text-muted">Unread Messages</span>
            </div>
        </div>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header"><h4 class="card-title">Latest Messages</h4></div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead><tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th><th></th></tr></thead>
            <tbody>
            @forelse($messages as $m)
                <tr style="{{ $m->is_read ? '' : 'font-weight:bold' }}">
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->email }}</td>
                    <td>{{ Str::limit($m->message, 60) }}</td>
                    <td>{{ $m->created_at->diffForHumans() }}</td>
                    <td><a class="btn btn-sm btn-info" href="{{ route('admin.portfolio.messageShow', $m->id) }}"><i class="fa fa-eye"></i></a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No messages yet.</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
