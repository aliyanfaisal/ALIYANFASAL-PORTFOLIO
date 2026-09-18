@props(['comment', 'post', 'isReply' => false])

@php
    $sessionId = session()->getId();
    $isOwner = $comment->isOwnedBySession($sessionId);
    $reactionCounts = $comment->reactions->groupBy('emoji')->map->count();
    $myReaction = $comment->reactions->firstWhere('session_id', $sessionId)?->emoji;

    $editBag = "comment-edit-{$comment->id}";
    $replyBag = "comment-reply-{$comment->id}";
    $editErrors = $errors->getBag($editBag);
    $replyErrors = $errors->getBag($replyBag);
@endphp

<div
    id="comment-{{ $comment->id }}"
    x-data="{ editing: {{ $editErrors->any() ? 'true' : 'false' }}, replying: {{ $replyErrors->any() ? 'true' : 'false' }} }"
    class="scroll-mt-28 {{ $isReply ? 'mt-4 border-l-2 border-zinc-100 pl-4 dark:border-white/5' : '' }}"
>
    <div x-show="!editing" class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-white/10 dark:bg-zinc-900">
        <div class="flex items-center justify-between gap-3">
            <p class="font-semibold text-zinc-900 dark:text-white">{{ $comment->name }}</p>
            <time class="shrink-0 text-xs text-zinc-400">
                {{ $comment->created_at->format('F j, Y') }}
                @if ($comment->wasEdited())
                    &middot; edited
                @endif
            </time>
        </div>

        <p class="mt-2 whitespace-pre-line text-sm text-zinc-600 dark:text-zinc-300">{{ $comment->body }}</p>

        <div
            x-data="{
                counts: {{ \Illuminate\Support\Js::from($reactionCounts) }},
                mine: {{ \Illuminate\Support\Js::from($myReaction) }},
                react(emoji) {
                    fetch({{ \Illuminate\Support\Js::from(route('blog.comments.reactions.store', [$post, $comment])) }}, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ emoji }),
                    })
                        .then((response) => response.json())
                        .then((data) => { this.counts = data.counts; this.mine = data.mine; })
                        .catch(() => {});
                },
            }"
            class="mt-3 flex flex-wrap items-center gap-1.5"
        >
            @foreach (\App\Models\CommentReaction::EMOJIS as $emoji)
                <button
                    type="button"
                    @click="react('{{ $emoji }}')"
                    aria-label="React with {{ $emoji }}"
                    class="inline-flex items-center gap-1 rounded-full border px-2.5 py-1 text-xs transition"
                    :class="mine === '{{ $emoji }}' ? 'border-indigo-400 bg-indigo-500/10 text-indigo-500 dark:text-indigo-400' : 'border-zinc-200 text-zinc-500 hover:border-indigo-300 dark:border-white/10 dark:text-zinc-400'"
                >
                    <span>{{ $emoji }}</span>
                    <span x-show="counts['{{ $emoji }}']" x-text="counts['{{ $emoji }}']"></span>
                </button>
            @endforeach
        </div>

        <div class="mt-3 flex items-center gap-4 text-xs font-medium">
            @unless ($isReply)
                <button type="button" @click="replying = !replying" class="text-zinc-500 transition hover:text-indigo-500 dark:text-zinc-400 dark:hover:text-indigo-400">
                    Reply
                </button>
            @endunless

            @if ($isOwner)
                <button type="button" @click="editing = true" class="text-zinc-500 transition hover:text-indigo-500 dark:text-zinc-400 dark:hover:text-indigo-400">
                    Edit
                </button>

                <form method="POST" action="{{ route('blog.comments.destroy', [$post, $comment]) }}" onsubmit="return confirm('Delete this comment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-zinc-500 transition hover:text-red-500 dark:text-zinc-400 dark:hover:text-red-400">
                        Delete
                    </button>
                </form>
            @endif
        </div>
    </div>

    <form
        x-show="editing"
        x-cloak
        method="POST"
        action="{{ route('blog.comments.update', [$post, $comment]) }}"
        class="space-y-3 rounded-2xl border border-zinc-200 bg-white p-5 dark:border-white/10 dark:bg-zinc-900"
    >
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $editErrors->any() ? old('name') : $comment->name }}" required
               class="w-full rounded-lg border border-zinc-300 bg-transparent px-3 py-2 text-sm text-zinc-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-white/15 dark:text-white">
        @error('name', $editBag) <p class="text-xs text-red-500">{{ $message }}</p> @enderror

        <textarea name="body" rows="3" required
                  class="w-full rounded-lg border border-zinc-300 bg-transparent px-3 py-2 text-sm text-zinc-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-white/15 dark:text-white">{{ $editErrors->any() ? old('body') : $comment->body }}</textarea>
        @error('body', $editBag) <p class="text-xs text-red-500">{{ $message }}</p> @enderror

        <div class="flex items-center gap-2">
            <button type="submit" class="rounded-full bg-zinc-900 px-4 py-2 text-xs font-semibold text-white transition hover:bg-indigo-600 dark:bg-white dark:text-zinc-900 dark:hover:bg-indigo-400">
                Save
            </button>
            <button type="button" @click="editing = false" class="rounded-full border border-zinc-300 px-4 py-2 text-xs font-medium text-zinc-600 dark:border-white/15 dark:text-zinc-300">
                Cancel
            </button>
        </div>
    </form>

    @unless ($isReply)
        <form
            x-show="replying"
            x-cloak
            method="POST"
            action="{{ route('blog.comments.reply', [$post, $comment]) }}"
            class="mt-3 space-y-3 rounded-2xl border border-zinc-200 bg-zinc-50 p-5 dark:border-white/10 dark:bg-white/[0.03]"
        >
            @csrf

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <input type="text" name="name" placeholder="Name" value="{{ $replyErrors->any() ? old('name') : '' }}" required
                           class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-white/15 dark:bg-zinc-900 dark:text-white">
                    @error('name', $replyBag) <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email" value="{{ $replyErrors->any() ? old('email') : '' }}" required
                           class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-white/15 dark:bg-zinc-900 dark:text-white">
                    @error('email', $replyBag) <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <textarea name="body" rows="3" placeholder="Write a reply..." required
                          class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-white/15 dark:bg-zinc-900 dark:text-white">{{ $replyErrors->any() ? old('body') : '' }}</textarea>
                @error('body', $replyBag) <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="cf-turnstile" x-init="$watch('replying', (value) => value && window.renderTurnstileWhenReady($el))"></div>
            @error('cf-turnstile-response', $replyBag) <p class="text-xs text-red-500">{{ $message }}</p> @enderror

            <div class="flex items-center gap-2">
                <button type="submit" class="rounded-full bg-zinc-900 px-4 py-2 text-xs font-semibold text-white transition hover:bg-indigo-600 dark:bg-white dark:text-zinc-900 dark:hover:bg-indigo-400">
                    Post Reply
                </button>
                <button type="button" @click="replying = false" class="rounded-full border border-zinc-300 px-4 py-2 text-xs font-medium text-zinc-600 dark:border-white/15 dark:text-zinc-300">
                    Cancel
                </button>
            </div>
        </form>

        @if ($comment->replies->isNotEmpty())
            <div class="space-y-4">
                @foreach ($comment->replies as $reply)
                    <x-comment :comment="$reply" :post="$post" :is-reply="true" />
                @endforeach
            </div>
        @endif
    @endunless
</div>
