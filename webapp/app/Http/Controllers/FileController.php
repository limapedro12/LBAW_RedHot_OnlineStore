<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    static $default = 'default.png';
    static $diskName = 'images';

    static $systemTypes = [
        'profile' => ['png', 'jpg', 'jpeg', 'gif'],
        'product' => ['png', 'jpg', 'jpeg', 'gif'],
    ];

    private static function isValidType(string $type)
    {
        return array_key_exists($type, self::$systemTypes);
    }

    private static function defaultAsset(string $type)
    {
        return asset($type . '/' . self::$default);
    }

    private static function getFileName(string $type, int $id)
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

    static function get(string $type, int $id)
    {
        if (!self::isValidType($type)) {
            return self::defaultAsset($type);
        }

        $fileName = self::getFileName($type, $id);

        if ($fileName) {
            return asset($fileName);
        }

        return self::defaultAsset($type);
    }

    function upload(Request $request, string $type, int $id)
    {
        $file = $request->file('file');
        $requestType = $request->type;
        $extension = $file->getClientOriginalExtension();

        $fileName = $type . '/' . $file->hashName();

        $request->file->storeAs($requestType, $fileName, self::$diskName);

        return $fileName;
    }

    public static function delete(string $hash)
    {
        error_log('Deleting file: ' . $hash);
        Storage::disk(self::$diskName)->delete($hash);
        error_log('Deleted file: ' . $hash);
    }
}
