<?php

declare(strict_types=1);

return [
    /* PASSWORD ALGORITHM, SEE https://www.php.net/manual/en/function.password-hash.php FOR MORE INFO */
    'algorithm' => PASSWORD_BCRYPT,

    /* PASSWORD ALPHABET */

    //NUMBERS ONLY ALPHABET
    'alphabet' => '0123456789',

    //"WORD SAFE" ALPHABET
    //'alphabet' => '256789BCDFGHJKMNPQRSTVXW',

    //ALPHANUM ALPHABET
    //'alphabet' => '0123456789ABCDEFGHIJKLMNOPQRSTUV';

    /* PASSWORD LENGTH */
    'length' => 6,

    /* PASSWORD EXPIRY */
    'expiry' => 600
];
