<?php

use Composer\InstalledVersions;

$installedVersion = InstalledVersions::getPrettyVersion('nnjeim/world') ?? '2.0.0';
$releasePreview = str_starts_with($installedVersion, 'dev-');
$packageVersion = $releasePreview ? '2.0.0' : ltrim($installedVersion, 'v');

return [
    'package_version' => $packageVersion,
    'release_preview' => $releasePreview,
    'release_url' => $releasePreview
        ? 'https://github.com/nnjeim/world/tree/'.InstalledVersions::getReference('nnjeim/world')
        : 'https://github.com/nnjeim/world/releases/tag/'.$packageVersion,
    'documentation_url' => 'https://github.com/nnjeim/world/blob/master/docs/2.0/README.md',
    'upgrade_url' => 'https://github.com/nnjeim/world/blob/master/docs/2.0/UPGRADE.md',
    'legacy_documentation_url' => 'https://github.com/nnjeim/world/blob/master/docs/1.x/README.md',
    'install_command' => 'composer require nnjeim/world:^2.0',
];
