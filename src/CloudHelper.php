<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use craft\cloud\HeaderEnum;
use craft\cloud\Helper;

class CloudHelper
{
    /**
     * The maximum number of prefixes that can be sent in a purge API call.
     * https://developers.cloudflare.com/cache/how-to/purge-cache/purge_by_prefix/
     */
    private const MAX_PREFIXES_PER_API_CALL = 30;

    /**
     * Returns a prefix from a URL.
     */
    public static function getPrefixFromUrl(string $url): string
    {
        $queryString = parse_url($url, PHP_URL_QUERY);
        $prefix = parse_url($url, PHP_URL_PATH);
        $prefix .= $queryString ? '?' . $queryString : '';

        return $prefix ?: '/';
    }

    /**
     * Returns prefixes from URLs.
     */
    public static function getPrefixesFromUrls(array $urls): array
    {
        $prefixes = [];

        foreach ($urls as $url) {
            $prefixes[] = self::getPrefixFromUrl($url);
        }

        return $prefixes;
    }

    /**
     * Returns a chunked array of values, using the max prefixes per API call as the length.
     */
    public static function getChunked(array $values): array
    {
        return array_chunk($values, self::MAX_PREFIXES_PER_API_CALL);
    }

    /**
     * Purges the provided URLs.
     *
     * @param string[] $urls
     */
    public static function purgeUrls(array $urls): void
    {
        self::sendPurgeRequest(self::getPrefixesFromUrls($urls));
    }

    /**
     * Sends a purge request to the API for the provided prefixes.
     *
     * @param string[] $prefixes
     */
    public static function sendPurgeRequest(array $prefixes): void
    {
        Helper::makeGatewayApiRequest([
            HeaderEnum::CACHE_PURGE_PREFIX->value => implode(',', $prefixes),
        ]);
    }
}
