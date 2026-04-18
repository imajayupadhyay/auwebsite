<?php

namespace App\Support;

class GoogleDrive
{
    public static function extractFileId(?string $input): ?string
    {
        if (blank($input)) {
            return null;
        }

        $input = trim($input);

        // drive.google.com/file/d/{ID}/...
        if (preg_match('#drive\.google\.com/file/d/([a-zA-Z0-9_-]+)#', $input, $m)) {
            return $m[1];
        }

        // drive.google.com/open?id={ID}
        if (preg_match('#drive\.google\.com/open\?.*id=([a-zA-Z0-9_-]+)#', $input, $m)) {
            return $m[1];
        }

        // docs.google.com/uc?id={ID}
        if (preg_match('#docs\.google\.com/uc\?.*id=([a-zA-Z0-9_-]+)#', $input, $m)) {
            return $m[1];
        }

        // Bare file ID (only alphanumeric/dash/underscore, at least 10 chars)
        if (preg_match('/^[a-zA-Z0-9_-]{10,}$/', $input)) {
            return $input;
        }

        return null;
    }
}
