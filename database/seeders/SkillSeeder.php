<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'PHP / Laravel', 'category' => 'Backend', 'proficiency' => 95],
            ['name' => 'AI Integration (OpenAI, Claude, Gemini, Groq)', 'category' => 'AI & Automation', 'proficiency' => 90],
            ['name' => 'WordPress', 'category' => 'CMS', 'proficiency' => 90],
            ['name' => 'Tailwind CSS / Bootstrap', 'category' => 'Frontend', 'proficiency' => 85],
            ['name' => 'Server Configuration & Linux', 'category' => 'DevOps', 'proficiency' => 80],

            ['name' => 'REST & GraphQL APIs', 'category' => 'Backend', 'proficiency' => 90],
            ['name' => 'AI Workflow Automation', 'category' => 'AI & Automation', 'proficiency' => 85],
            ['name' => 'WooCommerce', 'category' => 'CMS', 'proficiency' => 88],
            ['name' => 'JavaScript / jQuery / Vue', 'category' => 'Frontend', 'proficiency' => 75],
            ['name' => 'Git & Version Control', 'category' => 'DevOps', 'proficiency' => 90],

            ['name' => 'Debugging', 'category' => 'Backend', 'proficiency' => 92],
            ['name' => 'AI Chatbot Development', 'category' => 'AI & Automation', 'proficiency' => 88],
            ['name' => 'WordPress Plugin Development', 'category' => 'CMS', 'proficiency' => 90],
            ['name' => 'React', 'category' => 'Frontend', 'proficiency' => 70],
            ['name' => 'CI/CD & Deployment', 'category' => 'DevOps', 'proficiency' => 80],

            ['name' => 'MySQL', 'category' => 'Backend', 'proficiency' => 88],
            ['name' => 'Prompt Engineering', 'category' => 'AI & Automation', 'proficiency' => 85],
            ['name' => 'Elementor Pro', 'category' => 'CMS', 'proficiency' => 90],
            ['name' => 'Alpine.js', 'category' => 'Frontend', 'proficiency' => 85],
            ['name' => 'Nginx / Apache', 'category' => 'DevOps', 'proficiency' => 82],
        ];

        Skill::query()->delete();

        foreach ($skills as $i => $skill) {
            $skill['sort_order'] = $i;
            Skill::create($skill);
        }
    }
}
