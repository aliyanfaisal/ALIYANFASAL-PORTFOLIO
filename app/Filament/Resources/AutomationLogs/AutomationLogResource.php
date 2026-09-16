<?php

namespace App\Filament\Resources\AutomationLogs;

use App\Filament\Resources\AutomationLogs\Pages\ListAutomationLogs;
use App\Filament\Resources\AutomationLogs\Tables\AutomationLogsTable;
use App\Models\AutomationLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AutomationLogResource extends Resource
{
    protected static ?string $model = AutomationLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static string|UnitEnum|null $navigationGroup = 'Blog';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return AutomationLogsTable::configure($table);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAutomationLogs::route('/'),
        ];
    }
}
