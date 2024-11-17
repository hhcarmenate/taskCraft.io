<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;
use Illuminate\Translation\PotentiallyTranslatedString;

class TaskDateFormat implements ValidationRule
{
    protected string $format;

    public function __construct(string $format = 'm/d/Y')
    {
        $this->format = $format;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $date = Carbon::createFromFormat($this->format, $value);
            if (!$date || $date->format($this->format) !== $value) {
                $fail("The $attribute does not match the format {$this->format}.");
            }
        } catch (\Exception $e) {
            $fail("The $attribute does not match the format {$this->format}.");
        }
    }
}
