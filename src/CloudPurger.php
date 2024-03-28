<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use Craft;
use craft\cloud\HeaderEnum;
use craft\cloud\Helper;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use putyourlightson\blitz\drivers\purgers\BaseCachePurger;
use putyourlightson\blitz\helpers\SiteUriHelper;
use yii\base\Event;

class CloudPurger extends BaseCachePurger
{
    /**
     * The maximum number of prefixes that can be purged in a single API call.
     * https://developers.cloudflare.com/cache/how-to/purge-cache/purge_by_prefix/
     */
    private const MAX_PREFIXES_PER_API_CALL = 30;

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
    public function init(): void
    {
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['blitz-cloud'] = __DIR__ . '/templates/';
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function purgeAll(callable $setProgressHandler = null, bool $queue = true): void
    {
        $this->sendRequest(['/']);
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

        $this->sendRequest([$site->getBaseUrl()]);
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

        $chunkedSiteUris = array_chunk($siteUris, self::MAX_PREFIXES_PER_API_CALL);

        foreach ($chunkedSiteUris as $siteUriChunk) {
            $this->sendRequest(SiteUriHelper::getUrlsFromSiteUris($siteUriChunk));

            $count = $count + count($siteUriChunk);

            if (is_callable($setProgressHandler)) {
                $progressLabel = Craft::t('blitz', $label, ['total' => $total]);
                call_user_func($setProgressHandler, $count, $total, $progressLabel);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function test(): bool
    {
        if (Helper::isCraftCloud()) {
            return true;
        }

        $this->addError('test', 'This purger can only be used on Craft Cloud.');

        return false;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('blitz-cloud/settings', [
            'purger' => $this,
        ]);
    }

    /**
     * Sends a request to the API.
     */
    private function sendRequest(array $urls): void
    {
        $prefixes = [];
        foreach ($urls as $url) {
            $prefixes[] = preg_replace('/^https?:\/\//im', '', $url);
        }

        Helper::makeGatewayApiRequest([
            HeaderEnum::CACHE_PURGE_PREFIX->value => implode(',', $prefixes),
        ]);
    }
}
