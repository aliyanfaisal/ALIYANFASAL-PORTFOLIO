<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class NoContactInfo implements ValidationRule
{
    /**
     * Patterns that flag contact info, links, or embedded markup/scripts, keyed by
     * the human-readable label used in the failure message.
     *
     * @var array<string, string>
     */
    protected array $patterns = [
        'an email address' => '/[^\s@]+@[^\s@]+\.[a-z]{2,}/i',
        'a phone number' => '/(\+?\d[\d\-.\s()]{6,}\d)/',
        'a link' => '/(https?:\/\/|www\.|\b[a-z0-9-]+\.(?:com|net|org|io|co|info|biz|me|dev|xyz|online|shop|app|ai|us|uk|ca)\b)/i',
        'a script or markup tag' => '/<\s*[a-z!\/][^>]*>/i',
    ];

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            return;
        }

        foreach ($this->patterns as $label => $pattern) {
            if (preg_match($pattern, $value) === 1) {
                $fail("The :attribute must not contain {$label}.");

                return;
            }
        }
    }
}
