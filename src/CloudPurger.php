<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use putyourlightson\blitz\drivers\purgers\BaseCachePurger;
use yii\base\Event;

class CloudPurger extends BaseCachePurger
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('blitz', 'Cloud Purger');
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
    public function purgeSite(int $siteId, callable $setProgressHandler = null, bool $queue = true): void
    {
    }

    /**
     * @inheritdoc
     */
    public function purgeUrisWithProgress(array $siteUris, callable $setProgressHandler = null): void
    {
    }
}
