<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\cloud\HeaderEnum;
use craft\cloud\Helper;
use craft\cloud\StaticCache;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use putyourlightson\blitz\Blitz;
use putyourlightson\blitz\helpers\CacheGeneratorHelper;
use putyourlightson\blitz\helpers\CachePurgerHelper;
use putyourlightson\blitz\helpers\CacheStorageHelper;
use yii\base\Event;
use yii\web\Response;

class Plugin extends BasePlugin
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        $this->registerStorageType();
        $this->registerGeneratorType();
        $this->registerPurgerType();
        $this->registerTemplateRoots();

        if (Helper::isCraftCloud()) {
            $this->disableBlitzComments();

            if (Blitz::$plugin->cachePurger instanceof CloudPurger) {
                $this->preventCloudPurgeCache();
            }
        }
    }

    /**
     * Registers the storage type.
     */
    private function registerStorageType(): void
    {
        Event::on(CacheStorageHelper::class, CacheStorageHelper::EVENT_REGISTER_STORAGE_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = CloudStorage::class;
            }
        );
    }

    /**
     * Registers the generator type.
     */
    private function registerGeneratorType(): void
    {
        Event::on(CacheGeneratorHelper::class, CacheGeneratorHelper::EVENT_REGISTER_GENERATOR_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = CloudGenerator::class;
            }
        );
    }

    /**
     * Registers the purger type.
     */
    private function registerPurgerType(): void
    {
        Event::on(CachePurgerHelper::class, CachePurgerHelper::EVENT_REGISTER_PURGER_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = CloudPurger::class;
            }
        );
    }

    /**
     * Registers template roots for the plugin.
     */
    private function registerTemplateRoots(): void
    {
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['blitz-cloud'] = __DIR__ . '/templates/';
            }
        );
    }

    /**
     * Disables Blitz comments, since Cloud gzip encodes response content before
     * they would be added.
     */
    private function disableBlitzComments(): void
    {
        Event::on(Response::class, Response::EVENT_BEFORE_SEND,
            function() {
                Blitz::$plugin->settings->outputComments = false;
                Blitz::$plugin->generateCache->options->outputComments = false;
            }
        );
    }

    /**
     * Prevents Cloud from purging the cache by removing the cache purge tag
     * response header, when appropriate.
     *
     * @see StaticCache::addCachePurgeTagsToResponse()
     */
    private function preventCloudPurgeCache(): void
    {
        // Allow purging via the cache utility.
        $request = Craft::$app->getRequest();
        $actionSegments = $request->getIsActionRequest() ? $request->getActionSegments() : null;
        if ($actionSegments === ['utilities', 'clear-caches-perform-action']) {
            return;
        }

        Event::on(Response::class, Response::EVENT_AFTER_PREPARE,
            function(Event $event) {
                /** @var Response|null $response */
                $response = $event->sender;
                $response->getHeaders()->remove(HeaderEnum::CACHE_PURGE_TAG->value);
            },
            // Prepend the event, so it is triggered as early as possible.
            append: false,
        );
    }
}
