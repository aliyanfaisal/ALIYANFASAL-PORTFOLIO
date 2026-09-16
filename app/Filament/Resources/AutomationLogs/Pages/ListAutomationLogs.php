<?php

namespace App\Filament\Resources\AutomationLogs\Pages;

use App\Filament\Resources\AutomationLogs\AutomationLogResource;
use Filament\Resources\Pages\ListRecords;

class ListAutomationLogs extends ListRecords
{
    protected static string $resource = AutomationLogResource::class;
}
