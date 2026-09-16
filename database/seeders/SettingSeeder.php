<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(['id' => 1], [
            'site_name' => 'Aliyan Faisal',
            'site_description' => 'Aliyan Faisal is a full-stack web developer specializing in Laravel, WordPress, WooCommerce and AI-powered web applications.',
            'contact_email' => 'aliyanfaisal15@gmail.com',
            'github_url' => 'https://github.com/aliyanfaisal',
            'linkedin_url' => 'https://www.linkedin.com/in/aliyan-faisal-5162261b7/',
            'fiverr_url' => 'https://www.fiverr.com/aliyanfaisal',
            'upwork_url' => 'https://www.upwork.com/freelancers/~01f763ee3322eda908',
        ]);
    }
}
