
<?php
if (!function_exists('format_currency_vnd')) {
    function format_currency_vnd($amount) {
        $formatter = new \NumberFormatter('vi_VN', \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, 'VND');
    }
}
