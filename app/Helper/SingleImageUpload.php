<?php
namespace App\Helper;

use Ramsey\Uuid\Uuid;

trait SingleImageUpload{
    protected function imageUpload($request, $fieldName)
    {
        $image = $request->file($fieldName);

        $fileName = $image->getClientOriginalName();
        $fileExtension = $image->getClientOriginalExtension();
        $fileSize = $image->getSize();

        if (in_array($fileExtension, array("jpg", "jpeg", "png")) == false ) {
            return $this->errorResponse('Sorry! only image file is allowed', 400);
        }

        if ($fileSize > 1572864) {
            return $this->errorResponse('Sorry! only image file with size smaller than 1,5 Mb is allowed', 400);
        }

        $uuid = $this->attributes['uuid'] = Uuid::uuid4()->toString();
        $imageName = 'image-' . $uuid . '.' . $fileExtension;

        return [$image, $imageName];
    }
}