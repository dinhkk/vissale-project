<?php

function includedPhone($str)
{
    $cont = str_replace(array(
        '.',
        '-',
        ','
    ), '', $str);
    $cont = preg_replace('/\s+/', '', $cont);
    if (preg_match("/[0-9]{9,13}/", $cont, $matches)) {
        return $matches[0];
    }
    return false;
}

$list_comments = array(
    '0911.222.333',
    '09.1111.2222',
    '09.123             45678',
    '0911 222 333',
    '09 2222 3333',
    '0909,888,999',
    '09-1111-2222',
    '09 1111.2222',
    '09-1111.2222',
    '0911112222'
);

foreach ($list_comments as $comment){
    $phone = includedPhone($comment);
    if ($phone){
        echo "Comment: {$comment} included phone={$phone}" . PHP_EOL;
    }
    else {
        echo "Comment: {$comment} NOT included phone" . PHP_EOL;
    }
}