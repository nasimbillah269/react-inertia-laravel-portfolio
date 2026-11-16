<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\PortfolioSetting;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Config-driven CRUD for every portfolio section + the settings page.
 */
class PortfolioController extends Controller
{
    /** Icon keys understood by the React frontend (resources/js/Portfolio/icons.jsx). */
    public const ICONS = [
        'laravel', 'react', 'nextjs', 'php', 'mysql', 'javascript', 'typescript', 'tailwind', 'bootstrap', 'git',
        'nodejs', 'vue', 'html', 'css', 'python', 'docker', 'figma', 'wordpress', 'mongodb', 'redux',
        'web', 'mobile', 'api', 'cart', 'design', 'seo', 'code', 'server', 'cloud', 'shield',
        'rocket', 'users', 'globe', 'heart', 'trophy', 'star', 'clock', 'briefcase', 'graduation',
    ];

    protected function sections(): array
    {
        $icons = array_combine(self::ICONS, self::ICONS);

        return [
            'skills' => [
                'model' => Skill::class, 'title' => 'Skills', 'singular' => 'Skill',
                'columns' => ['name' => 'Name', 'icon' => 'Icon', 'level' => 'Level %'],
                'fields' => [
                    'name' => ['type' => 'text', 'label' => 'Name', 'rules' => 'required|max:100'],
                    'icon' => ['type' => 'select', 'label' => 'Icon', 'options' => $icons, 'rules' => 'nullable|max:50'],
                    'image' => ['type' => 'image', 'label' => 'Custom Icon Image (overrides icon)'],
                    'color' => ['type' => 'color', 'label' => 'Icon Color', 'rules' => 'nullable|max:20'],
                    'level' => ['type' => 'number', 'label' => 'Level (%)', 'rules' => 'nullable|integer|min:0|max:100'],
                ],
            ],
            'services' => [
                'model' => Service::class, 'title' => 'Services', 'singular' => 'Service',
                'columns' => ['title' => 'Title', 'icon' => 'Icon', 'short_description' => 'Short Description'],
                'fields' => [
                    'title' => ['type' => 'text', 'label' => 'Title', 'rules' => 'required|max:150'],
                    'icon' => ['type' => 'select', 'label' => 'Icon', 'options' => $icons, 'rules' => 'nullable|max:50'],
                    'image' => ['type' => 'image', 'label' => 'Custom Icon Image (overrides icon)'],
                    'short_description' => ['type' => 'textarea', 'label' => 'Short Description', 'rules' => 'nullable|max:500'],
                    'description' => ['type' => 'editor', 'label' => 'Details', 'rules' => 'nullable'],
                ],
            ],
            'projects' => [
                'model' => Project::class, 'title' => 'Projects', 'singular' => 'Project',
                'columns' => ['image' => 'Image', 'title' => 'Title', 'tags' => 'Tags', 'featured' => 'Featured'],
                'fields' => [
                    'title' => ['type' => 'text', 'label' => 'Title', 'rules' => 'required|max:191'],
                    'category' => ['type' => 'text', 'label' => 'Category (e.g. Web App)', 'rules' => 'nullable|max:100'],
                    'tags' => ['type' => 'text', 'label' => 'Tags (comma separated: Laravel, React)', 'rules' => 'nullable|max:191'],
                    'image' => ['type' => 'image', 'label' => 'Thumbnail / Screenshot'],
                    'short_description' => ['type' => 'textarea', 'label' => 'Short Description', 'rules' => 'nullable|max:500'],
                    'description' => ['type' => 'editor', 'label' => 'Full Description', 'rules' => 'nullable'],
                    'client' => ['type' => 'text', 'label' => 'Client', 'rules' => 'nullable|max:150'],
                    'live_url' => ['type' => 'text', 'label' => 'Live URL', 'rules' => 'nullable|url|max:191'],
                    'github_url' => ['type' => 'text', 'label' => 'GitHub URL', 'rules' => 'nullable|url|max:191'],
                    'featured' => ['type' => 'checkbox', 'label' => 'Featured (show on home page)'],
                ],
            ],
            'experiences' => [
                'model' => Experience::class, 'title' => 'Experience & Education', 'singular' => 'Experience',
                'columns' => ['title' => 'Title', 'company' => 'Company / Institute', 'type' => 'Type', 'start_date' => 'From', 'end_date' => 'To'],
                'fields' => [
                    'title' => ['type' => 'text', 'label' => 'Role / Degree', 'rules' => 'required|max:150'],
                    'company' => ['type' => 'text', 'label' => 'Company / Institute', 'rules' => 'nullable|max:150'],
                    'type' => ['type' => 'select', 'label' => 'Type', 'options' => ['work' => 'Work', 'education' => 'Education'], 'rules' => 'required|in:work,education'],
                    'start_date' => ['type' => 'text', 'label' => 'From (e.g. Jan 2021)', 'rules' => 'nullable|max:50'],
                    'end_date' => ['type' => 'text', 'label' => 'To (leave empty = Present)', 'rules' => 'nullable|max:50'],
                    'description' => ['type' => 'textarea', 'label' => 'Description', 'rules' => 'nullable|max:2000'],
                ],
            ],
            'testimonials' => [
                'model' => Testimonial::class, 'title' => 'Testimonials', 'singular' => 'Testimonial',
                'columns' => ['image' => 'Photo', 'name' => 'Name', 'designation' => 'Designation', 'rating' => 'Rating'],
                'fields' => [
                    'name' => ['type' => 'text', 'label' => 'Client Name', 'rules' => 'required|max:100'],
                    'designation' => ['type' => 'text', 'label' => 'Designation (e.g. CEO, Company)', 'rules' => 'nullable|max:150'],
                    'image' => ['type' => 'image', 'label' => 'Photo'],
                    'message' => ['type' => 'textarea', 'label' => 'Message', 'rules' => 'required|max:2000'],
                    'rating' => ['type' => 'number', 'label' => 'Rating (1-5)', 'rules' => 'nullable|integer|min:1|max:5'],
                ],
            ],
            'achievements' => [
                'model' => Achievement::class, 'title' => 'Facts & Numbers', 'singular' => 'Fact',
                'columns' => ['value' => 'Value', 'title' => 'Title', 'icon' => 'Icon', 'location' => 'Show In'],
                'fields' => [
                    'value' => ['type' => 'text', 'label' => 'Value (e.g. 50+)', 'rules' => 'required|max:30'],
                    'title' => ['type' => 'text', 'label' => 'Title (e.g. Projects Completed)', 'rules' => 'required|max:100'],
                    'icon' => ['type' => 'select', 'label' => 'Icon', 'options' => $icons, 'rules' => 'nullable|max:50'],
                    'image' => ['type' => 'image', 'label' => 'Custom Icon Image (overrides icon)'],
                    'location' => ['type' => 'select', 'label' => 'Show In', 'options' => ['both' => 'About + Facts', 'about' => 'About section only', 'facts' => 'Facts section only'], 'rules' => 'required|in:both,about,facts'],
                ],
            ],
        ];
    }

    protected function section(string $key): array
    {
        $sections = $this->sections();
        abort_unless(isset($sections[$key]), 404);

        return $sections[$key] + ['key' => $key];
    }

    public function dashboard()
    {
        $counts = [];
        foreach ($this->sections() as $key => $s) {
            $counts[$key] = ['title' => $s['title'], 'count' => $s['model']::count()];
        }
        $counts['blogs'] = ['title' => 'Blog Posts', 'count' => \App\Models\Post::where('type', 1)->where('status', 'active')->count()];
        $unread = ContactMessage::where('is_read', false)->count();
        $messages = ContactMessage::latest()->limit(6)->get();
        $projects = Project::orderBy('sort_order')->orderByDesc('id')->limit(4)->get();

        return view('admin.portfolio.dashboard', compact('counts', 'unread', 'messages', 'projects'));
    }

    // ----------------------------------------------------------------- CRUD

    public function index(Request $r, string $section)
    {
        $s = $this->section($section);
        $query = $s['model']::query();
        if ($r->search) {
            $first = array_key_first($s['fields']);
            $query->where($first, 'LIKE', '%' . $r->search . '%');
        }
        $items = $query->orderBy('sort_order')->orderByDesc('id')->paginate(25)->appends($r->only('search'));

        return view('admin.portfolio.index', compact('s', 'items'));
    }

    public function create(string $section)
    {
        $s = $this->section($section);
        $item = new $s['model'](['status' => true]);

        return view('admin.portfolio.form', compact('s', 'item'));
    }

    public function edit(string $section, int $id)
    {
        $s = $this->section($section);
        $item = $s['model']::findOrFail($id);

        return view('admin.portfolio.form', compact('s', 'item'));
    }

    public function store(Request $r, string $section)
    {
        $s = $this->section($section);

        return $this->save($r, $s, new $s['model']());
    }

    public function update(Request $r, string $section, int $id)
    {
        $s = $this->section($section);

        return $this->save($r, $s, $s['model']::findOrFail($id));
    }

    public function destroy(string $section, int $id)
    {
        $s = $this->section($section);
        $item = $s['model']::findOrFail($id);
        foreach ($s['fields'] as $name => $f) {
            if ($f['type'] === 'image') {
                $this->deleteFile($item->$name);
            }
        }
        $item->delete();

        return redirect()->route('admin.portfolio.index', $section)->with('success', $s['singular'] . ' deleted');
    }

    protected function save(Request $r, array $s, $item)
    {
        $rules = ['sort_order' => 'nullable|integer'];
        foreach ($s['fields'] as $name => $f) {
            if ($f['type'] === 'image') {
                $rules[$name] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096';
            } elseif (isset($f['rules'])) {
                $rules[$name] = $f['rules'];
            }
        }
        $r->validate($rules);

        foreach ($s['fields'] as $name => $f) {
            if ($f['type'] === 'image') {
                if ($r->hasFile($name)) {
                    $this->deleteFile($item->$name);
                    $item->$name = $this->upload($r->file($name), $s['key']);
                } elseif ($r->boolean('remove_' . $name)) {
                    $this->deleteFile($item->$name);
                    $item->$name = null;
                }
            } elseif ($f['type'] === 'checkbox') {
                $item->$name = $r->boolean($name);
            } else {
                $item->$name = $r->input($name);
            }
        }

        if ($s['key'] === 'projects') {
            $base = Str::slug($r->title) ?: 'project';
            $slug = $base;
            $i = 1;
            while (Project::where('slug', $slug)->where('id', '!=', $item->id ?? 0)->exists()) {
                $slug = $base . '-' . (++$i);
            }
            $item->slug = $slug;
        }

        $item->sort_order = (int) $r->input('sort_order', 0);
        $item->status = $r->boolean('status');
        $item->save();

        return redirect()->route('admin.portfolio.edit', [$s['key'], $item->id])->with('success', $s['singular'] . ' saved');
    }

    // ------------------------------------------------------------- Settings

    public static function settingGroups(): array
    {
        return [
            'Hero Section' => [
                'hero_greeting' => ['text', "Greeting (e.g. Hello, I'm)"],
                'hero_name' => ['text', 'Full Name'],
                'hero_typing_words' => ['text', 'Typing animation titles (comma separated, e.g. Full Stack Developer, React Developer). Empty = Title'],
                'hero_title' => ['text', 'Title (e.g. Full Stack Developer)'],
                'hero_description' => ['textarea', 'Short Intro'],
                'hero_image' => ['image', 'Profile Image (transparent PNG recommended)'],
                'hero_bg' => ['image', 'Hero Background Image (wide, e.g. 1800x580)'],
                'hero_tagline' => ['text', 'Tagline (e.g. Code • Innovate • Inspire)'],
                'hero_floating_skills' => ['text', 'Floating tech badges (comma separated icon keys: laravel,nextjs,react,php)'],
                'cv_file' => ['file', 'CV / Resume (PDF)'],
            ],
            'About Section' => [
                'about_title' => ['text', 'Title (use | for a line break, e.g. Turning Ideas into|Powerful)'],
                'about_highlight' => ['text', 'Highlighted text (e.g. Powerful Digital Solutions)'],
                'about_text' => ['textarea', 'About Text'],
                'about_points' => ['textarea', 'Bullet points (one per line)'],
                'about_image' => ['image', 'About Image / Video Thumbnail'],
                'about_video' => ['text', 'Video URL (YouTube, optional)'],
                'signature' => ['text', 'Signature Text'],
                'signature_image' => ['image', 'Signature Image (transparent PNG, overrides text)'],
            ],
            'Section Texts' => [
                'skills_subtitle' => ['text', 'Skills subtitle'],
                'services_text' => ['textarea', 'Services intro text'],
                'projects_subtitle' => ['text', 'Projects subtitle'],
                'facts_subtitle' => ['text', 'Facts subtitle'],
                'contact_title' => ['text', 'Contact title (e.g. Let\'s Work Together)'],
                'contact_text' => ['text', 'Contact subtitle'],
            ],
            'Contact & Social' => [
                'contact_email' => ['text', 'Email'],
                'contact_phone' => ['text', 'Phone'],
                'whatsapp_number' => ['text', 'WhatsApp Number with country code (e.g. 8801712345678). Empty = button opens the contact form'],
                'whatsapp_message' => ['text', 'WhatsApp pre-filled message'],
                'contact_address' => ['text', 'Address'],
                'social_github' => ['text', 'GitHub URL'],
                'social_linkedin' => ['text', 'LinkedIn URL'],
                'social_youtube' => ['text', 'YouTube URL'],
                'social_twitter' => ['text', 'X / Twitter URL'],
                'social_facebook' => ['text', 'Facebook URL'],
            ],
            'Site' => [
                'site_logo_text' => ['text', 'Logo Text (e.g. DevNasim)'],
                'site_logo' => ['image', 'Logo Image (optional, overrides text)'],
                'footer_tagline' => ['text', 'Footer tagline'],
                'copyright' => ['text', 'Copyright text'],
                'meta_title' => ['text', 'SEO Title'],
                'meta_description' => ['textarea', 'SEO Description'],
            ],
        ];
    }

    public function settings()
    {
        $groups = self::settingGroups();
        $values = PortfolioSetting::allAsArray();

        return view('admin.portfolio.settings', compact('groups', 'values'));
    }

    public function settingsUpdate(Request $r)
    {
        $r->validate([
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'hero_image' => 'nullable|image|max:4096',
            'about_image' => 'nullable|image|max:4096',
            'site_logo' => 'nullable|image|max:2048',
            'signature_image' => 'nullable|image|max:2048',
            'hero_bg' => 'nullable|image|max:6144',
        ]);
        $current = PortfolioSetting::allAsArray();

        foreach (self::settingGroups() as $fields) {
            foreach ($fields as $key => [$type]) {
                if (in_array($type, ['image', 'file'])) {
                    if ($r->hasFile($key)) {
                        $this->deleteFile($current[$key] ?? null);
                        PortfolioSetting::put($key, $this->upload($r->file($key), 'settings'));
                    } elseif ($r->boolean('remove_' . $key)) {
                        $this->deleteFile($current[$key] ?? null);
                        PortfolioSetting::put($key, null);
                    }
                } else {
                    PortfolioSetting::put($key, $r->input($key));
                }
            }
        }

        return back()->with('success', 'Settings saved');
    }

    // ------------------------------------------------------------- Messages

    public function messages(Request $r)
    {
        $items = ContactMessage::latest()
            ->when($r->search, fn ($q) => $q->where('name', 'like', "%{$r->search}%")->orWhere('email', 'like', "%{$r->search}%"))
            ->paginate(25);

        return view('admin.portfolio.messages', compact('items'));
    }

    public function messageShow(int $id)
    {
        $item = ContactMessage::findOrFail($id);
        $item->update(['is_read' => true]);

        return view('admin.portfolio.message', compact('item'));
    }

    public function messageDelete(int $id)
    {
        ContactMessage::findOrFail($id)->delete();

        return redirect()->route('admin.portfolio.messages')->with('success', 'Message deleted');
    }

    // -------------------------------------------------------------- Helpers

    protected function upload($file, string $folder): string
    {
        $dir = 'uploads/portfolio/' . $folder;
        $name = Str::random(8) . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . strtolower($file->getClientOriginalExtension());
        $file->move(public_path($dir), $name);

        return $dir . '/' . $name;
    }

    protected function deleteFile(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/portfolio/') && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
