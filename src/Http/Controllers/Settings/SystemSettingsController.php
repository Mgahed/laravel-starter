<?php

namespace Mgahed\LaravelStarter\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Mgahed\LaravelStarter\Models\Admin\Settings\SystemSetting;

class SystemSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $settings = SystemSetting::first();
        if (!$settings) {
            $settings = SystemSetting::create($this->defaultSettings());
        }

        return view('mgahed-laravel-starter::admin.system-settings.index', [
            'settings' => $settings,
            'logoUrl' => $this->logoUrl($settings->logo_path),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'general_manager' => ['required', 'string', 'max:255'],
            'health_approval_number' => ['required', 'string', 'max:255'],
            'full_address' => ['required', 'string'],
            'landline' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'tax_id' => ['nullable', 'string', 'max:255'],
            'vat_no' => ['nullable', 'string', 'max:255'],
            'eori_no' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
        ]);

        $settings = SystemSetting::first();
        if (!$settings) {
            $settings = SystemSetting::create($this->defaultSettings());
        }

        $validated['whatsapp_enabled'] = $request->boolean('whatsapp_enabled');

        if ($request->hasFile('logo')) {
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('system-settings', 'public');
			unset($validated['logo']);
        }

        $settings->update($validated);

        return redirect()->route('system-settings.index')
            ->with('success', 'System settings updated successfully.');
    }

    public function cover(Request $request)
    {
        $settings = SystemSetting::first();
        if (!$settings) {
            $settings = SystemSetting::create($this->defaultSettings());
        }

        $isPdf = $request->query('format') === 'pdf';
        $logoUrl = $this->logoUrl($settings->logo_path);
        $logoFilePath = $this->logoFilePath($settings->logo_path);

        $view = view('mgahed-laravel-starter::admin.system-settings.cover', [
            'settings' => $settings,
            'logoUrl' => $logoUrl,
            'logoFilePath' => $logoFilePath,
            'isPdf' => $isPdf,
        ]);

        if ($isPdf && class_exists('Dompdf\\Dompdf')) {
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $options->set('chroot', [public_path(), storage_path('app/public')]);

            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($view->render());
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="cover.pdf"',
            ]);
        }

        return $view;
    }

    private function logoUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    private function logoFilePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return public_path('storage/' . $path);
    }

    private function defaultSettings(): array
    {
        return [
            'company_name' => 'Mgahed',
            'general_manager' => 'Abdelrhman Mgahed',
            'health_approval_number' => 'EG',
            'full_address' => 'Egypt',
            'landline' => '+201228954237',
            'mobile' => '+201228954237',
            'whatsapp_enabled' => true,
            'website' => 'https://mgahed.com',
            'tax_id' => '3',
            'vat_no' => 'EG',
            'eori_no' => 'EG',
        ];
    }
}

