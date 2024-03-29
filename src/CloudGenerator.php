<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use Craft;
use putyourlightson\blitz\Blitz;
use putyourlightson\blitz\drivers\generators\HttpGenerator;

/**
 * This generator extends the HTTP generator but does not use a token parameter.
 * If the refresh mode clears the cache, then the generator acts like a warmer.
 * If the refresh mode expires the cache, then the generator purges each URL before
 * warming it.
 */
class CloudGenerator extends HttpGenerator
{
    use CloudTrait;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('blitz', 'Cloud Cache Generator');
    }

    /**
     * Generates site URIs with progress, without a token, chunking the URLs and
     * purging them first if necessary.
     */
    public function generateUrisWithProgress(array $siteUris, callable $setProgressHandler = null): void
    {
        $urls = $this->getUrlsToGenerate($siteUris, false);
        $total = count($urls);
        $count = 0;

        if (Blitz::$plugin->settings->shouldClearOnRefresh()) {
            $this->generateUrlsWithProgress($urls, $setProgressHandler, $count, $total);

            return;
        }

        $chunkedUrls = CloudHelper::getChunked($urls);

        foreach ($chunkedUrls as $urls) {
            CloudHelper::purgeUrls($urls);

            $this->generateUrlsWithProgress($urls, $setProgressHandler, $count, $total);
        }
    }
}
