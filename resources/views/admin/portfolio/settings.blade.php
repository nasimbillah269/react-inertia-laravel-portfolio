@extends(adminTheme().'layouts.app')
@section('title')<title>{{ websiteTitle('Portfolio Settings') }}</title>@endsection
@section('contents')
<div class="content-header row">
    <div class="content-header-left col-12 mb-2">
        <h3 class="content-header-title mb-0">Portfolio Settings</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Portfolio Settings</li>
        </ol>
    </div>
</div>

@include(adminTheme().'alerts')
@if($errors->any())
<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('admin.portfolio.settingsUpdate') }}" enctype="multipart/form-data">
    @csrf
    @foreach($groups as $group => $fields)
    <div class="card">
        <div class="card-header" style="background:#7c3aed;padding:12px 20px"><h4 class="mb-0" style="color:#fff">{{ $group }}</h4></div>
        <div class="card-body pt-2">
            <div class="row">
            @foreach($fields as $key => $def)
                @php([$type, $label] = $def)
                <div class="{{ $type === 'textarea' ? 'col-12' : 'col-md-6' }} form-group">
                    <label for="{{ $key }}">{{ $label }}</label>
                    @if($type === 'textarea')
                        <textarea name="{{ $key }}" id="{{ $key }}" rows="3" class="form-control">{{ old($key, $values[$key] ?? '') }}</textarea>
                    @elseif($type === 'image' || $type === 'file')
                        @if(!empty($values[$key]))
                            <div class="mb-1">
                                @if($type === 'image')
                                    <img src="{{ asset($values[$key]) }}" style="max-height:90px;border-radius:6px;background:#1e1b4b;padding:4px">
                                @else
                                    <a href="{{ asset($values[$key]) }}" target="_blank"><i class="fa fa-file"></i> Current file</a>
                                @endif
                                <label class="ml-1"><input type="checkbox" name="remove_{{ $key }}" value="1"> Remove</label>
                            </div>
                        @endif
                        <input type="file" name="{{ $key }}" id="{{ $key }}" class="form-control" @if($type === 'image') accept="image/*" @endif>
                    @else
                        <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ old($key, $values[$key] ?? '') }}" class="form-control">
                    @endif
                </div>
            @endforeach
            </div>
        </div>
    </div>
    @endforeach
    <button class="btn btn-success btn-lg mb-3"><i class="fa fa-save"></i> Save Settings</button>
</form>
@endsection
