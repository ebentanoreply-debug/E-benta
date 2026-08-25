<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:init-db', function () {
    $this->info('Running database migrations...');
    $this->call('migrate', ['--force' => true]);

    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('users') && User::count() === 0) {
            $this->info('Database is empty. Seeding initial data...');
            $this->call('db:seed', ['--force' => true]);
            $this->info('Database seeded successfully!');
        } else {
            $this->info('Database already contains records. Skipping seeder.');
        }
    } catch (\Throwable $e) {
        $this->warn('Seeding skipped or encountered a notice: ' . $e->getMessage());
    }
})->purpose('Run migrations and seed the database only once if empty');
