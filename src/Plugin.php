<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use craft\base\Plugin as BasePlugin;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use putyourlightson\blitz\helpers\CacheGeneratorHelper;
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

        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['blitz-cloud'] = __DIR__ . '/templates/';
            }
        );

        // TODO: prevent normal cache purging

        Event::on(CacheStorageHelper::class, CacheStorageHelper::EVENT_REGISTER_STORAGE_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = CloudStorage::class;
            }
        );

        Event::on(CacheGeneratorHelper::class, CacheGeneratorHelper::EVENT_REGISTER_GENERATOR_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = CloudGenerator::class;
            }
        );

        Event::on(CachePurgerHelper::class, CachePurgerHelper::EVENT_REGISTER_PURGER_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = CloudPurger::class;
            }
        );
    }
}
