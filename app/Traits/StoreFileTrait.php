<?php

namespace App\Traits;

trait StoreFileTrait
{
    function uploadImage($folder, $image) {
        $image->store('/', $folder);
        $filename = $image->hashName();
        return $filename;
    }
}
