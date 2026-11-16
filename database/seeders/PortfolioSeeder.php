<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Experience;
use App\Models\PortfolioSetting;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

/**
 * Demo content matching the design. Run: php artisan db:seed --class=PortfolioSeeder
 * Everything can be edited later from Admin > Portfolio.
 */
class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'hero_greeting' => "Hello, I'm",
            'hero_name' => 'Nasim Billah',
            'hero_title' => 'Full Stack Developer',
            'hero_typing_words' => 'Full Stack Developer, React Developer, Laravel Developer, Next.js Developer',
            'hero_description' => 'I build modern, scalable and high-performance web applications with Laravel, React and Next.js.',
            'hero_tagline' => 'Code • Innovate • Inspire',
            'hero_floating_skills' => 'laravel,nextjs,react,php',
            'about_title' => 'Turning Ideas into|Powerful',
            'about_highlight' => 'Digital Solutions',
            'hero_image' => 'uploads/portfolio/demo/assets/hero-me.png', // transparent cut-out
            'hero_bg' => 'uploads/portfolio/demo/assets/hero-bg.jpg',
            'about_image' => 'uploads/portfolio/demo/assets/about.jpg',
            'about_text' => "I'm a passionate Full Stack Developer with expertise in Laravel, React, and modern technologies. I love solving complex problems and building products that make an impact.",
            'about_points' => "5+ Years of Development Experience\nClean & Maintainable Code\nAlways Learning New Technologies",
            'signature' => 'Nasim Billah',
            'skills_subtitle' => 'A modern tech stack to build scalable and innovative solutions.',
            'services_text' => 'I offer a range of development services to help you turn your ideas into reality.',
            'projects_subtitle' => 'Some of my recent work that showcases my skills and creativity.',
            'facts_subtitle' => 'Numbers that reflect my journey and dedication.',
            'contact_title' => "Let's Work Together",
            'contact_text' => "Have a project in mind? Let's discuss how I can help you.",
            'contact_email' => 'hello@example.com',
            'whatsapp_number' => '', // set in admin to show the floating WhatsApp button
            'whatsapp_message' => 'Hi! I visited your portfolio and would like to discuss a project.',
            'social_github' => 'https://github.com/',
            'social_linkedin' => 'https://linkedin.com/',
            'social_youtube' => 'https://youtube.com/',
            'social_twitter' => 'https://x.com/',
            'site_logo_text' => 'DevNasim',
            'footer_tagline' => 'Build Better. Grow Bigger.',
            'copyright' => '© ' . date('Y') . ' DevNasim. All rights reserved.',
            'meta_title' => 'Nasim Billah - Full Stack Developer',
        ];
        foreach ($settings as $k => $v) {
            if (PortfolioSetting::where('key', $k)->doesntExist()) {
                PortfolioSetting::put($k, $v);
            }
        }

        if (Skill::count() === 0) {
            $skills = [
                ['Laravel', 'laravel', '#ff2d20'], ['React', 'react', '#61dafb'], ['Next.js', 'nextjs', '#ffffff'],
                ['PHP', 'php', '#8892bf'], ['MySQL', 'mysql', '#4479a1'], ['JavaScript', 'javascript', '#f7df1e'],
                ['TypeScript', 'typescript', '#3178c6'], ['Tailwind CSS', 'tailwind', '#38bdf8'],
                ['Bootstrap', 'bootstrap', '#7952b3'], ['Git', 'git', '#f05032'],
            ];
            foreach ($skills as $i => [$name, $icon, $color]) {
                Skill::create(['name' => $name, 'icon' => $icon, 'color' => $color, 'level' => 90, 'sort_order' => $i, 'image' => 'uploads/portfolio/demo/assets/skill-' . $icon . '.png']);
            }
        }

        if (Service::count() === 0) {
            $services = [
                ['Web Development', 'web', 'Modern & responsive website with latest technologies.'],
                ['App Development', 'mobile', 'Cross-platform mobile apps with React Native.'],
                ['API Development', 'api', 'Secure and scalable APIs for your business.'],
                ['E-commerce Solution', 'cart', 'Powerful online store with advanced features.'],
                ['UI/UX Design', 'design', 'Beautiful and user-friendly interface design.'],
                ['SEO & Digital Marketing', 'seo', 'Grow your business online.'],
            ];
            foreach ($services as $i => [$t, $icon, $d]) {
                Service::create(['title' => $t, 'icon' => $icon, 'short_description' => $d, 'sort_order' => $i, 'image' => 'uploads/portfolio/demo/assets/icon-' . $icon . '.png']);
            }
        }

        if (Project::count() === 0) {
            $projects = [
                ['E-Commerce Platform', 'Laravel, React', 'Web App'],
                ['Food Delivery App', 'React Native, API', 'Mobile App'],
                ['Service Booking App', 'React, Next.js', 'Web App'],
                ['Chat Application', 'Laravel, WebSocket', 'Web App'],
            ];
            foreach ($projects as $i => [$t, $tags, $cat]) {
                Project::create([
                    'title' => $t, 'slug' => \Str::slug($t), 'tags' => $tags, 'category' => $cat, 'featured' => true,
                    'short_description' => "A modern {$t} built with {$tags}.",
                    'description' => "<p>A full featured {$t} built with {$tags}. Replace this text from the admin panel.</p>",
                    'sort_order' => $i,
                    'image' => 'uploads/portfolio/demo/assets/project-' . ($i + 1) . '.jpg',
                ]);
            }
        }

        if (Experience::count() === 0) {
            Experience::create(['title' => 'Senior Full Stack Developer', 'company' => 'Tech Company', 'type' => 'work', 'start_date' => '2022', 'description' => 'Building scalable web applications with Laravel and React.']);
            Experience::create(['title' => 'Web Developer', 'company' => 'Digital Agency', 'type' => 'work', 'start_date' => '2019', 'end_date' => '2022', 'description' => 'Developed websites and e-commerce solutions for clients.', 'sort_order' => 1]);
            Experience::create(['title' => 'B.Sc in Computer Science', 'company' => 'University', 'type' => 'education', 'start_date' => '2015', 'end_date' => '2019', 'sort_order' => 2]);
        }

        if (Testimonial::count() === 0) {
            Testimonial::create(['name' => 'Rakib Hosain', 'designation' => 'CEO, Nature-IT', 'rating' => 5, 'image' => 'uploads/portfolio/demo/client.jpg', 'message' => 'Nasim Billah is an exceptional developer. His work quality, communication and dedication are outstanding.']);
            Testimonial::create(['name' => 'Sarah Ahmed', 'designation' => 'Founder, ShopBD', 'rating' => 5, 'message' => 'Delivered our platform on time with great attention to detail. Highly recommended!', 'sort_order' => 1]);
            Testimonial::create(['name' => 'Tanvir Rahman', 'designation' => 'Product Manager, SoftBD', 'rating' => 5, 'message' => 'Great communication and clean, maintainable code. Our app performance improved a lot.', 'sort_order' => 2]);
            Testimonial::create(['name' => 'Nusrat Jahan', 'designation' => 'Founder, StyleHub', 'rating' => 5, 'message' => 'Built our e-commerce store exactly as we imagined. Very professional work.', 'sort_order' => 3]);
            Testimonial::create(['name' => 'Arif Hasan', 'designation' => 'CTO, CloudNest', 'rating' => 5, 'message' => 'Reliable, fast and always ready to help. Will definitely work together again.', 'sort_order' => 4]);
        }

        if (Achievement::count() === 0) {
            $facts = [
                ['50+', 'Projects Completed', 'trophy', 'about'], ['3K+', 'Happy Clients', 'users', 'about'],
                ['5.0', 'Client Rating', 'star', 'about'], ['24/7', 'Support', 'clock', 'about'],
                ['50+', 'Projects', 'rocket', 'facts'], ['3K+', 'Clients', 'users', 'facts'],
                ['5+', 'Years', 'globe', 'facts'], ['100%', 'Satisfaction', 'heart', 'facts'],
            ];
            foreach ($facts as $i => [$v, $t, $icon, $loc]) {
                Achievement::create(['value' => $v, 'title' => $t, 'icon' => $icon, 'location' => $loc, 'sort_order' => $i, 'image' => $loc === 'about' ? 'uploads/portfolio/demo/assets/icon-' . $icon . '.png' : null]);
            }
        }
    }
}
