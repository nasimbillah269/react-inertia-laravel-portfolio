@extends(adminTheme().'layouts.app')
@section('title')<title>{{ websiteTitle('Contact Messages') }}</title>@endsection
@section('contents')
<div class="content-header row">
    <div class="content-header-left col-12 mb-2">
        <h3 class="content-header-title mb-0">Contact Messages</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Messages</li>
        </ol>
    </div>
</div>
@include(adminTheme().'alerts')
<div class="card"><div class="card-body">
    <form class="mb-2" action="{{ route('admin.portfolio.messages') }}">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name or email">
            <button class="btn btn-success"><i class="fa fa-search"></i> Search</button>
        </div>
    </form>
    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead><tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th><th style="width:110px">Action</th></tr></thead>
        <tbody>
        @forelse($items as $m)
            <tr style="{{ $m->is_read ? '' : 'font-weight:bold' }}">
                <td>{{ $m->name }} @unless($m->is_read)<span class="badge badge-primary">New</span>@endunless</td>
                <td>{{ $m->email }}</td>
                <td>{{ Str::limit($m->message, 80) }}</td>
                <td>{{ $m->created_at->format('d M Y, h:i A') }}</td>
                <td>
                    <a href="{{ route('admin.portfolio.messageShow', $m->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                    <form action="{{ route('admin.portfolio.messageDelete', $m->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">No messages yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
    {{ $items->links() }}
</div></div>
@endsection
