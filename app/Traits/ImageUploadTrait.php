<?php

namespace App\Traits;

trait ImageUploadTrait
{
    public function CategoryImageUpload($img)//taking input image as parameter
    {
        $picName = time().random_int(1000, 9999).'.'.$img->extension();
        $img->move(public_path('uploads'), $picName);
        return $picName;
    }

}
