<?php

namespace App\Filament\Resources\AutomationLogs\Tables;

use App\Models\AutomationLog;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AutomationLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('run_at')
                    ->label('Run at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('slot')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('category')
                    ->placeholder('—'),
                TextColumn::make('topic')
                    ->placeholder('—')
                    ->limit(40)
                    ->tooltip(fn (AutomationLog $record) => $record->topic),
                TextColumn::make('blog_url')
                    ->label('Blog')
                    ->formatStateUsing(fn (?string $state) => filled($state) ? 'View' : null)
                    ->url(fn (?string $state) => filled($state) ? Str::sanitizeUrl($state) : null)
                    ->openUrlInNewTab()
                    ->placeholder('—'),
                TextColumn::make('linkedin_post_url')
                    ->label('LinkedIn')
                    ->formatStateUsing(fn (?string $state) => filled($state) ? 'View' : null)
                    ->url(fn (?string $state) => filled($state) ? Str::sanitizeUrl($state) : null)
                    ->openUrlInNewTab()
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'blog_failed', 'linkedin_failed' => 'danger',
                        'partial_success' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('word_count')
                    ->label('Words')
                    ->numeric()
                    ->placeholder('—'),
            ])
            ->defaultSort('run_at', 'desc')
            ->recordActions([
                Action::make('viewError')
                    ->label('View error')
                    ->icon(Heroicon::OutlinedExclamationTriangle)
                    ->color('danger')
                    ->visible(fn (AutomationLog $record) => filled($record->error_message))
                    ->modalHeading('Error detail')
                    ->schema([
                        TextEntry::make('error_message')
                            ->hiddenLabel()
                            ->prose(),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
            ]);
    }
}
