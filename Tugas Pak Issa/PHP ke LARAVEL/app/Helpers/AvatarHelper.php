<?php
namespace App\Helpers;

class AvatarHelper
{
    public static function getUserInitials($username)
    {
        $words = explode(' ', $username);
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(mb_substr($word, 0, 1));
                if (strlen($initials) >= 2) break;
            }
        }

        if (strlen($initials) < 1) {
            $initials = strtoupper(mb_substr($username, 0, 1));
        }

        return $initials;
    }

    public static function getRandomColor($username)
    {
        $seed = crc32($username);
        srand($seed);

        $colors = [
            '#f44336', '#e91e63', '#9c27b0', '#673ab7', '#3f51b5',
            '#2196f3', '#03a9f4', '#00bcd4', '#009688', '#4caf50',
            '#8bc34a', '#cddc39', '#ffc107', '#ff9800', '#ff5722'
        ];

        $colorIndex = rand(0, count($colors) - 1);
        return $colors[$colorIndex];
    }
}
