<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class UserComposer
{
    public function compose(View $view)
    {
        // Mengambil user yang saat ini autentik melalui guard 'admin'
        $user = Auth::guard('admin')->user();

        // Mengirimkan data user ke semua views
        $view->with('user', $user);
    }
}
