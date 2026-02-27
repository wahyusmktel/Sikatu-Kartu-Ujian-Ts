<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\AdminSettings;

class SettingsComposer
{
    public function compose(View $view)
    {
        $setting = AdminSettings::where('status', true)->first();
        $view->with('setting', $setting);
    }
}