<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;

class FileController extends Controller
{
    static $default = 'default.jpg';
    static $diskName = 'images';

    static $systemTypes = [
        'profile' => ['png', 'jpg', 'jpeg', 'gif'],
        'product' => ['png', 'jpg', 'jpeg', 'gif'],
    ];

    private static function isValidType (String $type)
    {
        return array_key_exists($type, self::$systemTypes);
    }

    private static function defaultAsset (String $type)
    {
        return asset($type . '/' . self::$default);
    }

    private static function getFileName (String $type, int $id)
    {
        $fileName = null;

        switch ($type) {
            case 'profile':
                $fileName = User::find($id)->profile_image;
                break;
            case 'product':
                $fileName = Product::find($id)->product_image;
                break;
        }

        return $fileName;
    }

    static function get (String $type, int $userId)
    {
        if (!self::isValidType($type)) {
            return self::defaultAsset($type);
        }

        $fileName = self::getFileName($type, $userId);
        if ($fileName) {
            return asset($type . '/' . $fileName);
        }

        return self::defaultAsset($type);
    }
}
