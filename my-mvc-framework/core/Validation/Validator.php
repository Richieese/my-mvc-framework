<?php

declare(strict_types=1);

namespace Core\Validation;

class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $ruleString) {
            $value    = $data[$field] ?? '';
            $ruleList = explode('|', $ruleString);
            $label    = ucfirst(str_replace('_', ' ', $field));

            foreach ($ruleList as $rule) {

                if ($rule === 'required' && trim((string) $value) === '') {
                    $this->errors[$field] = "{$label} is required.";
                    break;
                }

                if ($rule === 'integer') {
                    if (!preg_match('/^\d+$/', trim((string) $value))) {
                        $this->errors[$field] = "Please enter a valid whole number for {$label}.";
                        break;
                    }
                }

                if ($rule === 'numeric') {
                    if (!is_numeric(trim((string) $value))) {
                        $this->errors[$field] = "Please enter a valid amount for {$label}.";
                        break;
                    }
                }

                if (str_starts_with($rule, 'min:')) {
                    $min = (float) substr($rule, 4);
                    if (is_numeric($value) && (float) $value < $min) {
                        $this->errors[$field] = "{$label} must be at least {$min}.";
                        break;
                    }
                }

                if (str_starts_with($rule, 'max:')) {
                    $max = (float) substr($rule, 4);
                    if (is_numeric($value) && (float) $value > $max) {
                        $this->errors[$field] = "{$label} must not exceed {$max}.";
                        break;
                    }
                }

                if (str_starts_with($rule, 'maxlen:')) {
                    $maxLen = (int) substr($rule, 7);
                    if (strlen((string) $value) > $maxLen) {
                        $this->errors[$field] = "{$label} must not exceed {$maxLen} characters.";
                        break;
                    }
                }

                if ($rule === 'alpha' && !ctype_alpha(str_replace(' ', '', (string) $value))) {
                    $this->errors[$field] = "{$label} must contain letters only.";
                    break;
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
