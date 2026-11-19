<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Memastikan alamat email akun internal menggunakan domain resmi Gunadarma.
 */
class GunadarmaEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || !preg_match('/^[^@\s]+@gunadarma\.ac\.id$/i', trim($value))) {
            $fail('Akun internal hanya menerima email dengan domain @gunadarma.ac.id.');
        }
    }
}
