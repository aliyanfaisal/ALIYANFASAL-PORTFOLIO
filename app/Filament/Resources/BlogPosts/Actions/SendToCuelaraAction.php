<?php

namespace App\Filament\Resources\BlogPosts\Actions;

use App\Jobs\PushBlogPostToCuelara;
use App\Models\BlogPost;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class SendToCuelaraAction
{
    public static function make(): Action
    {
        return Action::make('sendToCuelara')
            ->label(fn (BlogPost $record): string => $record->cuelara_synced_at ? 'Resend to Cuelara' : 'Send to Cuelara')
            ->icon('heroicon-o-paper-airplane')
            ->requiresConfirmation()
            ->modalDescription(fn (BlogPost $record): string => $record->cuelara_synced_at
                ? 'Already sent to Cuelara on '.$record->cuelara_synced_at->toDayDateTimeString().'. Resending will update the post there.'
                : 'Push this post to Cuelara now.')
            ->action(function (BlogPost $record): void {
                if (! config('services.cuelara.url') || ! config('services.cuelara.token')) {
                    Notification::make()
                        ->title('Cuelara is not configured')
                        ->body('Set CUELARA_API_URL and CUELARA_API_TOKEN in the environment.')
                        ->danger()
                        ->send();

                    return;
                }

                PushBlogPostToCuelara::dispatch($record, force: true);

                Notification::make()
                    ->title('Post queued for Cuelara')
                    ->success()
                    ->send();
            });
    }
}
