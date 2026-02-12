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

        $view = view('mgahed-laravel-starter::admin.system-settings.cover', [
            'settings' => $settings,
            'logoUrl' => $this->logoUrl($settings->logo_path),
        ]);

        if ($request->query('format') === 'pdf' && class_exists('Dompdf\\Dompdf')) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($view->render());
            $dompdf->setPaper('A4', 'portrait');
			$dompdf->setBaseHost($settings->website);
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="haccp-cover.pdf"',
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

    private function defaultSettings(): array
    {
        return [
            'company_name' => 'Darezini Naturdarme',
            'general_manager' => 'Darezini Mohamad',
            'health_approval_number' => 'DE NW20176 EG',
            'full_address' => 'Industrie Str. 23, 32825 Blomberg, Deutschland',
            'landline' => '+4952354750547',
            'mobile' => '+491789208986',
            'whatsapp_enabled' => true,
            'website' => 'DAREZINI.COM',
            'tax_id' => '313/5064/3253',
            'vat_no' => 'DE 325100294',
            'eori_no' => 'DE361415158134250',
        ];
    }
}

