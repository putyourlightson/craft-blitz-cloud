<?php

/**
 * Tests URL prefixes.
 */

use putyourlightson\blitzcloud\CloudPurger;

test('Prefixes are converted from URLs', function() {
    $purger = new CloudPurger();
    $urls = [
        'https://example.com',
        'https://example.com/foo',
        'https://example.com/foo/bar/',
        'https://example.com/foo/bar/baz?x=1&y=2',
    ];

    expect($purger->getPrefixesFromUrls($urls))
        ->toBe([
            '/',
            '/foo',
            '/foo/bar/',
            '/foo/bar/baz?x=1&y=2',
        ]);
});
