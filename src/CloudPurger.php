<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use Craft;
use putyourlightson\blitz\drivers\purgers\BaseCachePurger;
use putyourlightson\blitz\helpers\SiteUriHelper;

class CloudPurger extends BaseCachePurger
{
    use CloudTrait;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('blitz', 'Craft Cloud Purger');
    }

    /**
     * @inheritdoc
     */
    public function shouldPurgeAfterRefresh(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function purgeAll(callable $setProgressHandler = null, bool $queue = true): void
    {
        CloudHelper::sendPurgeRequest('/');
    }

    /**
     * @inheritdoc
     */
    public function purgeSite(int $siteId, callable $setProgressHandler = null, bool $queue = true): void
    {
        $site = Craft::$app->getSites()->getSiteById($siteId);

        if ($site === null) {
            return;
        }

        CloudHelper::purgeUrls($site->getBaseUrl());
    }

    /**
     * @inheritdoc
     */
    public function purgeUrisWithProgress(array $siteUris, callable $setProgressHandler = null): void
    {
        $count = 0;
        $total = count($siteUris);
        $label = 'Purging {total} pages';

        if (is_callable($setProgressHandler)) {
            $progressLabel = Craft::t('blitz', $label, ['total' => $total]);
            call_user_func($setProgressHandler, $count, $total, $progressLabel);
        }

        $urls = SiteUriHelper::getUrlsFromSiteUris($siteUris);
        $chunkedUrls = CloudHelper::getChunked($urls);

        foreach ($chunkedUrls as $urls) {
            CloudHelper::purgeUrls($urls);

            $count = $count + count($urls);

            if (is_callable($setProgressHandler)) {
                $progressLabel = Craft::t('blitz', $label, ['total' => $total]);
                call_user_func($setProgressHandler, $count, $total, $progressLabel);
            }
        }
    }
}
