<?php

namespace App\Enums;

enum ImageMimeType: string
{
    case JPG = 'jpg';
    case JPEG = 'jpeg';
    case PNG =  'png';
    case BMP = 'bmp';
    case GIF = 'gif';
    case SVG = 'svg';
    case WEBP =  'webp';
}
