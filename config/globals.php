<?php
const APP_URL = 'http://127.0.0.1:8000';
const UI_IMAGES_END_POINT = APP_URL . '/storage/ui-images/';
const ui_images_end_point = APP_URL . '/storage/ui-images/';
const images_end_points = APP_URL . '/storage/uploads/';
const IMAGES_END_POINT = '';

return [
    'images_end_point' => '',
    'IMAGES_END_POINT' => '',
    // 'images_end_point' => env('APP_URL') . '/storage/uploads/',
    'ui_images_end_point' => env('APP_URL') . '/storage/ui-images/',
];
