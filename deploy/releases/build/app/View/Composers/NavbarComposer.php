<?php

namespace App\View\Composers;

use Illuminate\View\View;

class NavbarComposer
{
    public function compose(View $view): void
    {
        if (!auth()->check()) {
            return;
        }

        $user = auth()->user();

        $view->with([
            "notificationCount" => $user->unreadNotifications()->count(),
            "latestNotifications" => $user->notifications()
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }
}
