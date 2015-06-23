<?php

    class okey {

        public static function mtt($mid, $svid) {
            return "{$mid}|{$svid}|mtt";
        }

        public static function warning() {
            return 'warning';
        }

        public static function pv() {
            return date("Y-m-d") . '|pv';
        }

    }
    