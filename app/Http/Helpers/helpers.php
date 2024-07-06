<?php

function format_uang($number) {
    return 'Rp. ' . number_format($number, 0, ',', '.');
}
