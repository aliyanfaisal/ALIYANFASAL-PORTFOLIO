<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\AutomationLogs\Pages\ListAutomationLogs;
use App\Models\AutomationLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AutomationLogResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_logs_ordered_by_run_at_descending(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $older = AutomationLog::create([
            'run_at' => now()->subDay(),
            'slot' => '08:00',
            'status' => 'success',
        ]);
        $newer = AutomationLog::create([
            'run_at' => now(),
            'slot' => '20:00',
            'status' => 'success',
        ]);

        Livewire::actingAs($admin)
            ->test(ListAutomationLogs::class)
            ->assertCanSeeTableRecords([$newer, $older], inOrder: true);
    }

    public function test_view_error_action_is_only_visible_when_an_error_message_is_present(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $failed = AutomationLog::create([
            'run_at' => now(),
            'slot' => '12:00',
            'status' => 'blog_failed',
            'error_message' => 'OpenAI API timeout after 30s.',
        ]);
        $succeeded = AutomationLog::create([
            'run_at' => now(),
            'slot' => '16:00',
            'status' => 'success',
        ]);

        Livewire::actingAs($admin)
            ->test(ListAutomationLogs::class)
            ->assertTableActionVisible('viewError', $failed)
            ->assertTableActionHidden('viewError', $succeeded);
    }
}
