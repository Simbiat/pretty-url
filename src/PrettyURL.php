<?php
declare(strict_types = 1);

namespace Simbiat\HTTP;

/**
 * Function transliterates lots of characters and makes a safe and pretty URL.
 */
class PrettyURL
{
    private static string $url_unsafe = '\+\*\'\(\);/\?:@=&"<>#%{}\|\\\\\^~\[]`';
    private static array $replaces = [];
    
    /**
     * Function transliterates lots of characters and makes a safe and pretty URL.
     *
     * @param string $string     String to process
     * @param string $whitespace Symbol to replace whitespace with
     * @param bool   $url_safe   If set to `true`, some characters will be removed as well, because they can "break" the URL. Some of them are valid for a URI, but they are not good for SEO links.
     * @param array  $list       Optional replacement list, that will override the default one
     *
     * @return string
     */
    public static function pretty(string $string, string $whitespace = '-', bool $url_safe = true, array $list = []): string
    {
        #If no replacement list is provided, load the default one, but only if it has not been loaded already
        if (\count($list) === 0) {
            try {
                if (\count(self::$replaces) === 0) {
                    self::$replaces = \json_decode(\file_get_contents(__DIR__.'/map.json'), true, 512, \JSON_THROW_ON_ERROR);
                }
                $list = self::$replaces;
            } catch (\Throwable) {
                $list = [];
            }
        }
        $new_string = \str_replace(\array_keys($list), $list, $string);
        $new_string = \preg_replace('/\s+/', $whitespace, $new_string);
        if ($url_safe) {
            $new_string = \preg_replace('[^a-zA-Z\d'.$whitespace.']', '', $new_string);
        } else {
            $new_string = \preg_replace('[^a-zA-Z\d'.self::$url_unsafe.$whitespace.']', '', $new_string);
        }
        return $new_string;
    }
}
