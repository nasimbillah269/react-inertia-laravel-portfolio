<?php

namespace App\Http\Middleware;

use App\Models\PortfolioSetting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Props shared with every portfolio page.
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $settings = PortfolioSetting::allAsArray();

        // turn stored file paths into absolute URLs for the frontend
        foreach (['hero_image', 'about_image', 'cv_file', 'site_logo', 'signature_image', 'hero_bg'] as $fileKey) {
            if (!empty($settings[$fileKey])) {
                $settings[$fileKey] = asset($settings[$fileKey]);
            }
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? ['id' => $user->id, 'name' => $user->name, 'admin' => (bool) $user->admin] : null,
            ],
            'settings' => $settings,
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];
    }
}
