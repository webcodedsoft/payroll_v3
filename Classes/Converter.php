<?php

class Classes_Converter
{
    public static function TimeConvert($since){
        
            $time_ago = strtotime($since);
            $current_time = time();
            $time_diff = $current_time - $time_ago;
            $seconds = $time_diff;
            $minutes = round($seconds / 60);
            $hours = round($seconds / 3600);
            $days = round($seconds / 86400);
            $weeks = round($seconds / 604800);
            $months = round($seconds / 2629440);
            $years = round($seconds / 31553280);

            if ($seconds <= 60) {

                return "Just Now";
            } elseif ($minutes <= 60) {

                if ($minutes == 1) {
                    return "One minutes ago";
                } else {

                    return "$minutes minutes ago";
                }
            } elseif ($hours <= 24) {
                if ($hours == 1) {
                    return "an hour ago";
                } else {

                    return "$hours hrs ago";
                }
            } elseif ($days <= 7) {

                if ($days == 1) {
                    return 'yesterday';
                } else {
                    return "$days days ago";
                }
            } elseif ($weeks <= 4.3) {

                if ($weeks == 1) {
                    return "a week ago";
                } else {

                    return "$weeks weeks ago";
                }
            } elseif ($months <= 12) {
                if ($months == 1) {

                    return "a month ago";
                } else {
                    return "$months months ago";
                }
            } else {

                if ($years == 1) {

                    return "one year ago";
                } else {

                    return "$years years ago";
                }
            }
        }

    

        //From MB, GB to bytes
    public static function FileSize(string $filesize): ?int {
       
            $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
            $number = substr($filesize, 0, -2);
            $suffix = strtoupper(substr($filesize, -2));

            //B or no suffix
            if (is_numeric(substr($suffix, 0, 1))) {
                return preg_replace('/[^\d]/', '', $filesize);
            }

            $exponent = array_flip($units)[$suffix] ?? null;
            if ($exponent === null) {
                return null;
            }

            return $number * (1024 ** $exponent);
       
    }


    //From bytes to MB, GB
    public static function file_size($size)
    {
        if ($size >= 1073741824) {
            $size = number_format($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) {
            $size = number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            $size = number_format($size / 1024, 2) . ' KB';
        } elseif ($size > 1) {
            $size = $size . ' Bytes';
        } elseif ($size == 1) {
            $size = $size . ' Byte';
        } else {
            $size = '0 Bytes';
        }
        return $size;
    }
}
