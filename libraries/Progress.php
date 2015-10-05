<?php

namespace Joelvardy;

class Progress
{

    /**
     * Taken from: http://stackoverflow.com/a/27147177
     */
    public static function bar($done, $total)
    {
        $percent = ceil(($done / $total) * 100);
        $bar = '[' . ($percent > 0 ? str_repeat('=', $percent - 1) : '') . '>';
        $bar .= str_repeat(' ', 100 - $percent) . "] - $percent% - $done/$total";
        print "\033[0G$bar"; // Note the \033[0G. Put the cursor at the beginning of the line
        if ($done >= $total) {
            print "\n";
        }
    }

}
