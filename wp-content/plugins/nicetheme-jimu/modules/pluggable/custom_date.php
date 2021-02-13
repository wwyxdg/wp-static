<?php

/*
            /$$
    /$$    /$$$$
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/
================================
        Keep calm and get rich.
                    Is the best.

    @Author: Dami
    @Date:   2019-08-02 11:36:30
    @Last Modified by:   Dami
    @Last Modified time: 2019-08-02 21:38:32

*/

if (!function_exists('timeago')) {
    function timeago($time)
    {
        $from = strtotime($time);
        $to = current_time('timestamp');

        if (($to - $from) > DAY_IN_SECONDS) {
            return date('Y-m-d H:i', $from);
        } else {
            return human_time_diff($from, $to).'前';
        }
    }
}
