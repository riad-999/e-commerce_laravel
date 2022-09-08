<?php
// const IMAGES_END_POINT = asset('storage/uploads/');
// const UI_IMAGES_END_POINT = './storage/';
const IMAGES_END_POINT = '';
const APP_URL = 'http://127.0.0.1:8000';

return [
    'images_end_point' => '',
    // 'images_end_point' => asset('storage/uploads/'),
    'ui_images_end_point' => env('APP_URL') . '/storage/ui-images/'
];