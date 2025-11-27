<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Support;

final class QueryStringBuilder
{
    /**
     * Build a dot-notation flattened query string from a nested array.
     * Example: ['a' => ['b' => 1]] => 'a.b=1'.
     */
    public static function build(array $params, string $prefix = ''): string
    {
        $pairs = [];

        foreach ($params as $key => $value) {
            $new_key = $prefix === '' ? (string) $key : $prefix . '.' . (string) $key;

            if (is_array($value)) {
                $nested = self::build($value, $new_key);

                if ($nested !== '') {
                    $pairs[] = $nested;
                }
            } else {
                $pairs[] = $new_key . '=' . (string) $value;
            }
        }

        return $pairs ? implode('&', $pairs) : '';
    }
}
