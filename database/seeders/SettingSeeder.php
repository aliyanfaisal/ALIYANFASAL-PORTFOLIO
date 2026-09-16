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
            'site_description' => 'Aliyan Faisal builds custom Laravel & WordPress web apps, WooCommerce stores, and AI-powered chatbots & automation for clients worldwide. 5+ years experience.',
            'contact_email' => 'aliyanfaisal15@gmail.com',
            'github_url' => 'https://github.com/aliyanfaisal',
            'linkedin_url' => 'https://www.linkedin.com/in/aliyan-faisal-5162261b7/',
            'fiverr_url' => 'https://www.fiverr.com/aliyanfaisal',
            'upwork_url' => 'https://www.upwork.com/freelancers/~01f763ee3322eda908',
        ]);
    }
}
