<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use Craft;
use putyourlightson\blitz\drivers\storage\YiiCacheStorage;

/**
 * The cache storage method for Craft Cloud, which extends the Yii cache storage
 * and disabled the ability to compress cached values.
 *
 * @property-read null|string $settingsHtml
 */
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
    public function getSettingsHtml(): ?string
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function canCompressCachedValues(): bool
    {
        return false;
    }
}
