<?php

namespace Helpers;

class ValidationHelper
{
    /**
     * @param array $rules
     * @param array $data
     * @return array
     */
    public static function validate(array $rules, array $data): array
    {
        $errors = [];

        foreach ($rules as $field => $conditions) {
            $value = $data[$field] ?? null;

            $isRequired = in_array('required', $conditions, true) || ($conditions['required'] ?? false);

            if ($isRequired && ($value === null || $value === '')) {
                $errors[$field] = "Field '$field' is required";
                continue;
            }

            // Skip empty not required field
            if ($value === null) {
                continue;
            }

            $type = $conditions['type'] ?? '';

            // Check min/max for string
            if ($type === 'string') {
                $length = mb_strlen((string) $value);

                if (isset($conditions['min']) && $length < $conditions['min']) {
                    $errors[$field] = "Field '$field' is too short (min: {$conditions['min']})";
                }

                if (isset($conditions['max']) && $length > $conditions['max']) {
                    $errors[$field] = "Field '$field' is too long (max: {$conditions['max']})";
                }
            }

            // Check min/max for numeric
            if ($type === 'numeric') {
                if (!is_numeric($value)) {
                    $errors[$field] = "Field '$field' must be a number";
                } else {
                    if (isset($conditions['min']) && $value < $conditions['min']) {
                        $errors[$field] = "Field '$field' must be at least {$conditions['min']}";
                    }
                    if (isset($conditions['max']) && $value > $conditions['max']) {
                        $errors[$field] = "Field '$field' must be no more than {$conditions['max']}";
                    }
                }
            }
        }

        return $errors;
    }
}
