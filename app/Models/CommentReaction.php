<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentReaction extends Model
{
    /**
     * The emoji reactions visitors may choose from.
     *
     * @var array<int, string>
     */
    public const EMOJIS = ['👍', '❤️', '😂', '🎉'];

    protected $fillable = [
        'comment_id', 'session_id', 'emoji',
    ];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
