<?php

use App\Models\Document;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('documents:check-expirations', function () {

    $count = Document::query()
        ->get()
        ->filter(fn (Document $document) => $document->estaPorVencer() || $document->estaVencido())
        ->count();

    Log::info('SGDV expiration check executed.', [
        'documents' => $count,
    ]);

    $this->info("Documents requiring attention: {$count}");

})->purpose('Check expiring vehicle documents');

Schedule::command('documents:check-expirations')
    ->dailyAt('08:00');
