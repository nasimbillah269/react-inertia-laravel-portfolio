<?php

namespace App\Http\Controllers\Welcome;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\PortfolioSetting;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    protected function img(?string $path): ?string
    {
        return $path ? asset($path) : null;
    }

    protected function projectData(Project $p, bool $full = false): array
    {
        $data = [
            'id' => $p->id,
            'title' => $p->title,
            'slug' => $p->slug,
            'category' => $p->category,
            'tags' => $p->tagList(),
            'image' => $this->img($p->image),
            'short_description' => $p->short_description,
            'live_url' => $p->live_url,
            'github_url' => $p->github_url,
        ];
        if ($full) {
            $data += ['description' => $p->description, 'client' => $p->client, 'date' => $p->created_at?->format('F Y')];
        }

        return $data;
    }

    protected function blogData(Post $b, bool $full = false): array
    {
        $data = [
            'id' => $b->id,
            'title' => $b->name,
            'slug' => $b->slug,
            'excerpt' => Str::limit(strip_tags($b->short_description ?: $b->description), 140),
            'image' => asset($b->image()),
            'date' => $b->created_at?->format('M d, Y'),
        ];
        if ($full) {
            $data['description'] = $b->description;
            $data['author'] = $b->user?->name;
        }

        return $data;
    }

    protected function meta(string $title = null, string $description = null, string $image = null): array
    {
        $s = PortfolioSetting::allAsArray();
        $site = $s['meta_title'] ?? ($s['hero_name'] ?? 'Portfolio');

        return [
            'title' => $title ? $title . ' | ' . $site : $site,
            'description' => $description ?: ($s['meta_description'] ?? ($s['hero_description'] ?? '')),
            'image' => $image ?: $this->img($s['hero_image'] ?? null),
            'url' => url()->current(),
        ];
    }

    public function home()
    {
        $achievements = Achievement::active()->get(['id', 'title', 'value', 'icon', 'image', 'location'])
            ->map(fn ($a) => tap($a, fn ($a) => $a->image = $this->img($a->image)));
        $skills = Skill::active()->get();

        return Inertia::render('Home', [
            'meta' => $this->meta(),
            // hero floating badges reuse the skill icon images, keyed by icon name
            'badgeImages' => $skills->filter(fn ($s) => $s->icon && $s->image)->mapWithKeys(fn ($s) => [$s->icon => $this->img($s->image)]),
            'skills' => $skills->map(fn ($s) => [
                'id' => $s->id, 'name' => $s->name, 'icon' => $s->icon, 'color' => $s->color,
                'image' => $this->img($s->image), 'level' => $s->level,
            ]),
            'services' => Service::active()->get()->map(fn ($s) => [
                'id' => $s->id, 'title' => $s->title, 'icon' => $s->icon,
                'image' => $this->img($s->image), 'short_description' => $s->short_description,
            ]),
            'projects' => Project::active()->where('featured', true)->limit(8)->get()->map(fn ($p) => $this->projectData($p)),
            'experiences' => Experience::active()->get(['id', 'title', 'company', 'type', 'start_date', 'end_date', 'description']),
            'testimonials' => Testimonial::active()->get()->map(fn ($t) => [
                'id' => $t->id, 'name' => $t->name, 'designation' => $t->designation,
                'image' => $this->img($t->image), 'message' => $t->message, 'rating' => $t->rating,
            ]),
            'aboutStats' => $achievements->whereIn('location', ['both', 'about'])->values(),
            'facts' => $achievements->whereIn('location', ['both', 'facts'])->values(),
            'blogs' => Post::where('type', 1)->where('status', 'active')->latest()->limit(3)->get()->map(fn ($b) => $this->blogData($b)),
        ]);
    }

    public function projects(Request $r)
    {
        $projects = Project::active()->get();

        return Inertia::render('Projects', [
            'meta' => $this->meta('Projects'),
            'projects' => $projects->map(fn ($p) => $this->projectData($p)),
            'categories' => $projects->pluck('category')->filter()->unique()->values(),
        ]);
    }

    public function projectShow(string $slug)
    {
        $project = Project::where('status', true)->where('slug', $slug)->firstOrFail();

        return Inertia::render('ProjectDetail', [
            'meta' => $this->meta($project->title, $project->short_description, $this->img($project->image)),
            'project' => $this->projectData($project, true),
            'related' => Project::active()->where('id', '!=', $project->id)->limit(3)->get()->map(fn ($p) => $this->projectData($p)),
        ]);
    }

    public function blogs(Request $r)
    {
        $blogs = Post::where('type', 1)->where('status', 'active')
            ->when($r->search, fn ($q) => $q->where('name', 'like', '%' . $r->search . '%'))
            ->latest()->paginate(9)->withQueryString();

        return Inertia::render('Blogs', [
            'meta' => $this->meta('Blog'),
            'blogs' => $blogs->through(fn ($b) => $this->blogData($b)),
            'search' => $r->search,
        ]);
    }

    public function blogShow(string $slug)
    {
        $blog = Post::where('type', 1)->where('status', 'active')->where('slug', $slug)->firstOrFail();
        $blog->increment('view');

        return Inertia::render('BlogDetail', [
            'meta' => $this->meta($blog->seo_title ?: $blog->name, $blog->seo_desc, asset($blog->image())),
            'blog' => $this->blogData($blog, true),
            'recent' => Post::where('type', 1)->where('status', 'active')->where('id', '!=', $blog->id)
                ->latest()->limit(4)->get()->map(fn ($b) => $this->blogData($b)),
        ]);
    }

    public function contact(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'nullable|max:191',
            'message' => 'required|max:5000',
        ]);
        ContactMessage::create($data + ['ip' => $r->ip()]);

        return back()->with('success', 'Thank you! Your message has been sent.');
    }
}
