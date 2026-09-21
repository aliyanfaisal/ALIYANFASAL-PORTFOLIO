<?php

namespace App\Filament\Resources\BlogPosts\Pages;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use App\Jobs\PushBlogPostToCuelara;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditBlogPost extends EditRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sendToCuelara')
                ->label('Send to Cuelara')
                ->icon('heroicon-o-paper-airplane')
                ->requiresConfirmation()
                ->modalDescription('Push this post to Cuelara now. If it was already sent, it will be updated there.')
                ->action(function (): void {
                    if (! config('services.cuelara.url') || ! config('services.cuelara.token')) {
                        Notification::make()
                            ->title('Cuelara is not configured')
                            ->body('Set CUELARA_API_URL and CUELARA_API_TOKEN in the environment.')
                            ->danger()
                            ->send();

                        return;
                    }

                    PushBlogPostToCuelara::dispatch($this->getRecord(), force: true);

                    Notification::make()
                        ->title('Post queued for Cuelara')
                        ->success()
                        ->send();
                }),
            DeleteAction::make(),
        ];
    }
}
