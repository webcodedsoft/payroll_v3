<?php

class Classes_Generators
{

    public static function AlphaNumeric($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'),  range('A', 'Z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }


    public static function Numeric($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range(0, 9),  range(0, 9));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

}
