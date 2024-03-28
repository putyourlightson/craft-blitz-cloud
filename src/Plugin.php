<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use craft\base\Plugin as BasePlugin;
use craft\events\RegisterComponentTypesEvent;
use putyourlightson\blitz\helpers\CachePurgerHelper;
use putyourlightson\blitz\helpers\CacheStorageHelper;
use yii\base\Event;

class Plugin extends BasePlugin
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        Event::on(CacheStorageHelper::class, CacheStorageHelper::EVENT_REGISTER_STORAGE_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = CloudStorage::class;
            }
        );

        Event::on(CachePurgerHelper::class, CachePurgerHelper::EVENT_REGISTER_PURGER_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = CloudPurger::class;
            }
        );
    }
}
