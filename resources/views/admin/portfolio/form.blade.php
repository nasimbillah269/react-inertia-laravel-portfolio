@extends(adminTheme().'layouts.app')
@section('title')<title>{{ websiteTitle(($item->exists ? 'Edit ' : 'Add ') . $s['singular']) }}</title>@endsection
@section('contents')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">{{ $item->exists ? 'Edit' : 'Add' }} {{ $s['singular'] }}</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index', $s['key']) }}">{{ $s['title'] }}</a></li>
            <li class="breadcrumb-item active">{{ $item->exists ? 'Edit' : 'Add' }}</li>
        </ol>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-2 text-md-right">
        <a class="btn btn-outline-primary" href="{{ route('admin.portfolio.index', $s['key']) }}"><i class="fa fa-arrow-left"></i> Back</a>
        @if($item->exists)
        <a class="btn btn-primary" href="{{ route('admin.portfolio.create', $s['key']) }}"><i class="fa fa-plus"></i> Add New</a>
        @endif
    </div>
</div>

@include(adminTheme().'alerts')
@if($errors->any())
<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form method="POST" enctype="multipart/form-data"
      action="{{ $item->exists ? route('admin.portfolio.update', [$s['key'], $item->id]) : route('admin.portfolio.store', $s['key']) }}">
    @csrf
    @if($item->exists) @method('PUT') @endif
    <div class="row">
        <div class="col-md-8">
            <div class="card"><div class="card-body">
            @foreach($s['fields'] as $name => $f)
                @if($f['type'] === 'image' || $f['type'] === 'checkbox') @continue @endif
                <div class="form-group">
                    <label for="{{ $name }}">{{ $f['label'] }} @if(str_contains($f['rules'] ?? '', 'required'))<span class="text-danger">*</span>@endif</label>
                    @switch($f['type'])
                        @case('textarea')
                            <textarea name="{{ $name }}" id="{{ $name }}" rows="4" class="form-control">{{ old($name, $item->$name) }}</textarea>
                            @break
                        @case('editor')
                            <textarea name="{{ $name }}" id="{{ $name }}" class="form-control tinyEditor">{{ old($name, $item->$name) }}</textarea>
                            @break
                        @case('select')
                            <select name="{{ $name }}" id="{{ $name }}" class="form-control">
                                @if(!str_contains($f['rules'] ?? '', 'required'))<option value="">— None —</option>@endif
                                @foreach($f['options'] as $val => $lbl)
                                    <option value="{{ $val }}" @selected(old($name, $item->$name) == $val)>{{ ucfirst($lbl) }}</option>
                                @endforeach
                            </select>
                            @break
                        @case('number')
                            <input type="number" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $item->$name) }}" class="form-control">
                            @break
                        @case('color')
                            <input type="color" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $item->$name ?: '#8b5cf6') }}" class="form-control" style="height:42px;max-width:120px">
                            @break
                        @default
                            <input type="text" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $item->$name) }}" class="form-control">
                    @endswitch
                </div>
            @endforeach
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card"><div class="card-body">
                @foreach($s['fields'] as $name => $f)
                    @if($f['type'] === 'image')
                    <div class="form-group">
                        <label>{{ $f['label'] }}</label>
                        @if($item->$name)
                            <div class="mb-1"><img src="{{ asset($item->$name) }}" style="max-width:100%;max-height:160px;border-radius:6px"></div>
                            <label class="d-block"><input type="checkbox" name="remove_{{ $name }}" value="1"> Remove image</label>
                        @endif
                        <input type="file" name="{{ $name }}" accept="image/*" class="form-control">
                    </div>
                    @elseif($f['type'] === 'checkbox')
                    <div class="form-group">
                        <label><input type="checkbox" name="{{ $name }}" value="1" @checked(old($name, $item->$name))> {{ $f['label'] }}</label>
                    </div>
                    @endif
                @endforeach
                <div class="form-group">
                    <label>Sort Order <small>(smaller shows first)</small></label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="form-control">
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="status" value="1" @checked(old('status', $item->status))> Active</label>
                </div>
                <button class="btn btn-success btn-block"><i class="fa fa-save"></i> Save</button>
            </div></div>
        </div>
    </div>
</form>
@endsection
