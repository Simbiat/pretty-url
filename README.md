# PrettyURL

```php
\Simbiat\HTTP\PrettyURL::pretty(string $string, string $whitespace = '-', bool $url_safe = true);
```

Function transliterates lots of characters and makes a safe and pretty URL. This is intended more as a SEO thing, rather than sanitization.

Includes the majority (if not all) of diacritics (accented characters), cyrillic, hiragana, katakana, arabic, chinese characters. They are replaced by Latin characters or combinations that are representing how they are pronounced, officially romanized or the closest neighbors in terms of how a character is drawn.

It also allows replacing whitespace characters with a character of your choosing (hyphen as default).

If `$url_safe` is set to `true`, some characters will be removed as well, because they can "break" the URL. Some of them are valid for a URI, but they are not good for SEO links.
