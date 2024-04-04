<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use Craft;
use putyourlightson\blitz\drivers\storage\BaseCacheStorage;
use putyourlightson\blitz\models\SiteUriModel;

/**
 * The cache storage method for Craft Cloud essentially is a dummy, since cache
 * storage is handled by Cloudflare.
 */
class CloudStorage extends BaseCacheStorage
{
    use CloudTrait;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('blitz', 'Craft Cloud Storage');
    }

    public function get(SiteUriModel $siteUri): ?string
    {
        return null;
    }

    public function save(string $value, SiteUriModel $siteUri, int $duration = null, bool $allowEncoding = true): void
    {
    }

    public function deleteUris(array $siteUris): void
    {
    }

    public function deleteAll(): void
    {
    }
}
