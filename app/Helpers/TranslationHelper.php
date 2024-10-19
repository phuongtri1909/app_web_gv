<?php

if (! function_exists('translate')) {
    function translate($model, $attribute, $fallback = null) {
        return $model->getTranslation($attribute, app()->getLocale(), false) ?: $fallback;
    }
}
