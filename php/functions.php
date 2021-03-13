<?php

function anyEmptyElement(array $elements): bool {
    $empty = false;

    foreach ($elements as $element) {
        if (empty($element)) {
            $empty = true;
            break;
        }
    }

    return $empty;
}