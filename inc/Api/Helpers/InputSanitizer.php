<?php
/**
 * @package n9-reviews
 */

function n9_sanitize(string $type, $value)
{
    if ('text' === $type) {
        return sanitize_text_field($value);
    } elseif ('textarea' === $type) {
        return sanitize_textarea_field($value);
    } else {
        //default
        return $value;
    }
}
