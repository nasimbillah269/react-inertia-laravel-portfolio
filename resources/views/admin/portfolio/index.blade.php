@extends(adminTheme().'layouts.app')
@section('title')<title>{{ websiteTitle($s['title']) }}</title>@endsection
@section('contents')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">{{ $s['title'] }}</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $s['title'] }}</li>
        </ol>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-2 text-md-right">
        <a class="btn btn-primary" href="{{ route('admin.portfolio.create', $s['key']) }}"><i class="fa fa-plus"></i> Add {{ $s['singular'] }}</a>
    </div>
</div>

@include(adminTheme().'alerts')

<div class="card">
    <div class="card-body">
        <form class="mb-2" action="{{ route('admin.portfolio.index', $s['key']) }}">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search...">
                <button class="btn btn-success"><i class="fa fa-search"></i> Search</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        @foreach($s['columns'] as $label)<th>{{ $label }}</th>@endforeach
                        <th style="width:80px">Order</th>
                        <th style="width:90px">Status</th>
                        <th style="width:140px">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        @foreach($s['columns'] as $col => $label)
                            <td>
                                @if(($s['fields'][$col]['type'] ?? '') === 'image')
                                    @if($item->$col)<img src="{{ asset($item->$col) }}" style="height:45px;max-width:80px;object-fit:cover;border-radius:4px">@else — @endif
                                @elseif(($s['fields'][$col]['type'] ?? '') === 'checkbox')
                                    {!! $item->$col ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-secondary">No</span>' !!}
                                @else
                                    {{ Str::limit(strip_tags((string) $item->$col), 70) ?: '—' }}
                                @endif
                            </td>
                        @endforeach
                        <td>{{ $item->sort_order }}</td>
                        <td>{!! $item->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.portfolio.edit', [$s['key'], $item->id]) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('admin.portfolio.destroy', [$s['key'], $item->id]) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this item?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ count($s['columns']) + 4 }}" class="text-center">No {{ strtolower($s['title']) }} found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection
