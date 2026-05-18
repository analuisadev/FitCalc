<?php

namespace Helper;

use finfo;

class FileHelper
{
    public function saveProfilePhoto(array $profilePhoto)
    {
        if ($profilePhoto['error'] !== UPLOAD_ERR_OK)
            return false;

        if ($profilePhoto['size'] > 5 * 1024 * 1024)
            return false;

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($profilePhoto['tmp_name']);
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];

        if (!array_key_exists($mime, $allowed))
            return false;

        if (!getimagesize($profilePhoto['tmp_name']))
            return false;

        $ext = $allowed[$mime];
        $filename = uniqid('photo_', true) . '.' . $ext;

        $uploadDir = __DIR__ . '/../storage/uploads/images/';

        if (!is_dir($uploadDir))
            mkdir($uploadDir, 0755, true);

        if (!move_uploaded_file($profilePhoto['tmp_name'], $uploadDir . $filename))
            return false;

        return $filename;
    }
}