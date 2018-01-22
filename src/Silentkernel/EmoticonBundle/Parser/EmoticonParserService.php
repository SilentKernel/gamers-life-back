<?php
/**
 * Created by PhpStorm.
 * User: Silent
 * Date: 04/08/2015
 * Time: 01:01
 */

namespace Silentkernel\EmoticonBundle\Parser;


class EmoticonParserService
{
    const img1 = '<img class="emoticon" alt="';
    const img2 = '" src="/bundles/silentkernelemoticon/images/';
    const img3 = '.png">';

    const input = array(
        ":)",

        ":*",

        ";)",
        ";p",

        ":D",
        ":d",

        ":P",
        ":p",

        ":(",

        ":'(",

        "&lt;3",
        "&lt;/3"
    );

    const output = array(
        self::img1 . ":)" . self::img2 . "smile" . self::img3,

        self::img1 . ":*" . self::img2 . "kissing" . self::img3,

        self::img1 . ";)" . self::img2 . "wink" . self::img3,
        self::img1 . ";p" . self::img2 . "stuck_out_tongue_winking_eye" . self::img3,

        self::img1 . ":D" . self::img2 . "smiley" . self::img3,
        self::img1 . ":D" . self::img2 . "smiley" . self::img3,

        self::img1 . ":P" . self::img2 . "stuck_out_tongue" . self::img3,
        self::img1 . ":P" . self::img2 . "stuck_out_tongue" . self::img3,

        self::img1 . ":(" . self::img2 . "frowning" . self::img3,

        self::img1 . ":'(" . self::img2 . "sob" . self::img3,

        self::img1 . "Coeur" . self::img2 . "heart" . self::img3,
        self::img1 . "Coeur brisé" . self::img2 . "broken_heart" . self::img3
    );

    private $markDown;

    public function __construct($mardown)
    {
        $this->markDown = $mardown;
    }

    public function parse($data)
    {
        // This does not clean HTML SO AN OTHER FILTER SHOULD DO IT BEFORE !!!!
        return str_replace(self::input, self::output, $data);
    }
}
