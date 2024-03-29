<?php

/**
 * Tests converting URLs to prefixes.
 */

use putyourlightson\blitzcloud\CloudHelper;

test('URLs are correctly converted to prefixes', function() {
    $urls = [
        'https://example.com',
        'https://example.com/foo',
        'https://example.com/foo/bar/',
        'https://example.com/foo/bar/baz?x=1&y=2',
    ];

    expect(CloudHelper::getPrefixesFromUrls($urls))
        ->toBe([
            '/',
            '/foo',
            '/foo/bar/',
            '/foo/bar/baz?x=1&y=2',
        ]);
});
