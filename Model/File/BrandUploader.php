<?php

namespace Dmatthew\Brand\Model\File;

use Magento\MediaStorage\Model\File\Uploader;
use Magento\MediaStorage\Model\File\Validator\NotProtectedExtension;

class BrandUploader extends Uploader
{

    public function __construct(
        $fileId,
        \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDb,
        \Magento\MediaStorage\Helper\File\Storage $coreFileStorage,
        NotProtectedExtension $validator
    ) {
        if (count($fileId) > 0 && isset($_FILES[$fileId]) && is_array($_FILES[$fileId])) {
            foreach ($_FILES[$fileId] as $key => $filePart) {
                if(is_array($filePart) && isset($filePart['brand_image'])){
                    $_FILES[$fileId][$key] = $filePart['brand_image'];
                }
            }
        }

        parent::__construct($fileId, $coreFileStorageDb, $coreFileStorage, $validator);
    }

}