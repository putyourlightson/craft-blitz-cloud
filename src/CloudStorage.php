<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use Craft;
use putyourlightson\blitz\drivers\storage\YiiCacheStorage;

class CloudStorage extends YiiCacheStorage
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('blitz', 'Cloud Cache Storage');
    }

    /**
     * @inheritdoc
     */
    public bool $compressCachedValues = false;

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        return null;
    }
}
