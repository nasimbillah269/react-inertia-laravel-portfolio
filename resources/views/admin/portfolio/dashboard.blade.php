@extends(adminTheme().'layouts.app')
@section('title')<title>{{ websiteTitle('Dashboard') }}</title>@endsection
@section('contents')
@php
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    // key => [icon, gradient from, gradient to, link]
    $meta = [
        'projects'     => ['fa-briefcase',    '#8b5cf6', '#6d28d9', route('admin.portfolio.index', 'projects')],
        'skills'       => ['fa-code',         '#6366f1', '#4338ca', route('admin.portfolio.index', 'skills')],
        'services'     => ['fa-layer-group',  '#0ea5e9', '#0369a1', route('admin.portfolio.index', 'services')],
        'testimonials' => ['fa-comment-dots', '#ec4899', '#be185d', route('admin.portfolio.index', 'testimonials')],
        'achievements' => ['fa-trophy',       '#f59e0b', '#d97706', route('admin.portfolio.index', 'achievements')],
        'blogs'        => ['fa-pen-nib',      '#10b981', '#047857', route('admin.posts')],
        'experiences'  => ['fa-route',        '#14b8a6', '#0f766e', route('admin.portfolio.index', 'experiences')],
    ];
@endphp

@include(adminTheme().'alerts')

{{-- Welcome banner --}}
<div class="ad-hero">
    <span class="ad-hero-art">&lt;/&gt;</span>
    <small><i class="far fa-calendar"></i> {{ now()->format('l, d F Y') }}</small>
    <h2>{{ $greeting }}, {{ Str::before(Auth::user()->name, ' ') ?: Auth::user()->name }} 👋</h2>
    <p>Here's what's happening with your portfolio. Keep your projects, skills and blog fresh to impress every visitor.</p>
    <div class="ad-hero-actions">
        <a class="light" href="{{ route('index') }}" target="_blank"><i class="fas fa-globe"></i> View Website</a>
        <a class="ghost" href="{{ route('admin.portfolio.settings') }}"><i class="fas fa-sliders"></i> Site Settings</a>
        <a class="ghost" href="{{ route('admin.portfolio.messages') }}"><i class="fas fa-inbox"></i> Inbox
            @if($unread)<span class="badge" style="background:#fff;color:#6d28d9">{{ $unread }}</span>@endif
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="ad-stats">
    @foreach(['projects', 'skills', 'services', 'testimonials', 'achievements', 'blogs'] as $key)
        @php([$icon, $c1, $c2, $link] = $meta[$key])
        <a class="ad-stat" href="{{ $link }}" style="--c1: {{ $c1 }}; --c2: {{ $c2 }}">
            <span class="ad-stat-icon"><i class="fas {{ $icon }}"></i></span>
            <div>
                <strong>{{ $counts[$key]['count'] }}</strong>
                <span>{{ $counts[$key]['title'] }}</span>
            </div>
            <i class="fas fa-arrow-right go"></i>
        </a>
    @endforeach
    <a class="ad-stat" href="{{ route('admin.portfolio.messages') }}" style="--c1: #f43f5e; --c2: #be123c">
        <span class="ad-stat-icon"><i class="fas fa-envelope-open-text"></i></span>
        <div>
            <strong>{{ $unread }}</strong>
            <span>Unread Messages</span>
        </div>
        <i class="fas fa-arrow-right go"></i>
    </a>
    <a class="ad-stat" href="{{ route('admin.portfolio.settings') }}" style="--c1: #64748b; --c2: #334155">
        <span class="ad-stat-icon"><i class="fas fa-user-astronaut"></i></span>
        <div>
            <strong style="font-size:16px">Hero &amp; About</strong>
            <span>Profile, CV, socials</span>
        </div>
        <i class="fas fa-arrow-right go"></i>
    </a>
</div>

<div class="ad-grid">
    {{-- Latest messages --}}
    <div class="ad-panel">
        <div class="ad-panel-head">
            <h4><i class="fas fa-inbox" style="color:#7c3aed;margin-right:8px"></i>Latest Messages</h4>
            <a href="{{ route('admin.portfolio.messages') }}">View all <i class="fas fa-arrow-right"></i></a>
        </div>
        @forelse($messages as $m)
            <a class="ad-msg" href="{{ route('admin.portfolio.messageShow', $m->id) }}">
                <span class="ad-avatar">{{ strtoupper(mb_substr($m->name, 0, 1)) }}</span>
                <div class="ad-msg-body">
                    <strong>{{ $m->name }} <small style="color:#7a7fa3;font-weight:400">· {{ $m->email }}</small></strong>
                    <p>{{ Str::limit($m->message, 90) }}</p>
                </div>
                <time>{{ $m->created_at->diffForHumans(null, true) }}</time>
                @unless($m->is_read)<span class="ad-dot" title="Unread"></span>@endunless
            </a>
        @empty
            <div class="ad-empty">
                <i class="fas fa-inbox"></i>
                No messages yet. They'll appear here when someone uses your contact form.
            </div>
        @endforelse
    </div>

    {{-- Quick actions --}}
    <div class="ad-panel">
        <div class="ad-panel-head">
            <h4><i class="fas fa-bolt" style="color:#7c3aed;margin-right:8px"></i>Quick Actions</h4>
        </div>
        <div class="ad-actions">
            <a class="ad-action" href="{{ route('admin.portfolio.create', 'projects') }}"><i class="fas fa-briefcase"></i>Add Project</a>
            <a class="ad-action" href="{{ route('admin.postsAction', ['create']) }}"><i class="fas fa-pen-nib"></i>Write Blog Post</a>
            <a class="ad-action" href="{{ route('admin.portfolio.create', 'skills') }}"><i class="fas fa-code"></i>Add Skill</a>
            <a class="ad-action" href="{{ route('admin.portfolio.create', 'testimonials') }}"><i class="fas fa-comment-dots"></i>Add Testimonial</a>
            <a class="ad-action" href="{{ route('admin.portfolio.create', 'services') }}"><i class="fas fa-layer-group"></i>Add Service</a>
            <a class="ad-action" href="{{ route('admin.portfolio.settings') }}"><i class="fas fa-user-pen"></i>Edit Profile</a>
        </div>
    </div>
</div>

{{-- Recent projects --}}
<div class="ad-panel" style="margin-bottom:22px">
    <div class="ad-panel-head">
        <h4><i class="fas fa-briefcase" style="color:#7c3aed;margin-right:8px"></i>Recent Projects</h4>
        <a href="{{ route('admin.portfolio.index', 'projects') }}">Manage projects <i class="fas fa-arrow-right"></i></a>
    </div>
    @if($projects->count())
        <div class="ad-projects">
            @foreach($projects as $p)
                <a class="ad-project" href="{{ route('admin.portfolio.edit', ['projects', $p->id]) }}">
                    <div class="ad-project-img">
                        @if($p->image)<img src="{{ asset($p->image) }}" alt="{{ $p->title }}">@endif
                    </div>
                    <div class="ad-project-body">
                        <strong>{{ $p->title }}</strong>
                        @foreach(array_slice($p->tagList(), 0, 3) as $tag)<span class="ad-tag">{{ $tag }}</span>@endforeach
                        @unless($p->status)<span class="ad-tag" style="background:#ffe4e6;color:#be123c">Hidden</span>@endunless
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="ad-empty"><i class="fas fa-briefcase"></i>No projects yet. <a href="{{ route('admin.portfolio.create', 'projects') }}">Add your first project</a>.</div>
    @endif
</div>
@endsection
