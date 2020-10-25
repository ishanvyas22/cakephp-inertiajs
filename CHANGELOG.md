# Release Notes

## [Unreleased](https://github.com/ishanvyas22/cakephp-inertiajs/compare/1.2.0...master)

## [1.2.0 (2020-10-25)](https://github.com/ishanvyas22/cakephp-inertiajs/compare/1.1.3...1.2.0)

### Added
- Set flash data automatically into view variables ([#9](https://github.com/ishanvyas22/cakephp-inertiajs/pull/9))
- Lazy evaluate props ([#10](https://github.com/ishanvyas22/cakephp-inertiajs/pull/10))

### Changed
- Use `Psr\Http\Message\ResponseInterface` instead of `Cake\Http\Response` concrete class ([ab61375](https://github.com/ishanvyas22/cakephp-inertiajs/commit/ab61375e19cdc7612b434de8b3cf78be6788ec26))

## [1.1.3 (2020-10-21)](https://github.com/ishanvyas22/cakephp-inertiajs/compare/1.1.2...1.1.3)

### Fixed
- Do not set `InertiaJsonView` when status is 404 or 500 ([#8](https://github.com/ishanvyas22/cakephp-inertiajs/pull/8))

## [1.1.2 (2020-10-11)](https://github.com/ishanvyas22/cakephp-inertiajs/compare/1.1.1...1.1.2)

### Changed
- Revamp documentation ([#7](https://github.com/ishanvyas22/cakephp-inertiajs/pull/7))

## [1.1.1 (2020-09-24)](https://github.com/ishanvyas22/cakephp-inertiajs/compare/1.1.0...1.1.1)

### Changed
- Remove vendor/bin from composer.json used in alias ([b042f11](https://github.com/ishanvyas22/cakephp-inertiajs/commit/b042f11d5e462d95b459f1abd20bbfe71c8e19a5))

### Fixed
- Error in render: "SyntaxError: Unexpected end of JSON input" ([e8769f4](https://github.com/ishanvyas22/cakephp-inertiajs/commit/e8769f4ca0da17dffa5248cbbf425fa4e8e3da4c))

## [1.1.0 (2020-08-30)](https://github.com/ishanvyas22/cakephp-inertiajs/compare/1.0.0...1.1.0)

### Added
- Added issue and feature request templates ([807d935](https://github.com/ishanvyas22/cakephp-inertiajs/commit/807d935df1465eb642b958287c5488a12140d39d))
- Added CakePHP badge in `README.md` file ([f70fa5b](https://github.com/ishanvyas22/cakephp-inertiajs/commit/f70fa5b1cbf7fe3ae20b9154d9c9361d19e21534))
- Added steps to how to override root template in `README.md` file ([0a416db](https://github.com/ishanvyas22/cakephp-inertiajs/commit/0a416db2024f0b51b7c9848e7cbb9beeee4c5eba))
- Added test to check status code is 303 when using redirect for `PUT` method ([cffba95](https://github.com/ishanvyas22/cakephp-inertiajs/commit/cffba95c365b770fa9da0c2cbc93fdf31afa1678))
- Added `AssetMix` helper of AssetMix plugin into `InertiaWebView` ([9b97a15](https://github.com/ishanvyas22/cakephp-inertiajs/commit/9b97a15ec9216f42078b2f5da5fc25bf87272d79))
- Added sample html content as a example in README.md file ([bbcc61f](https://github.com/ishanvyas22/cakephp-inertiajs/commit/bbcc61fb53505f2a7565ab4e83888f7e604c30da))

### Changed
- Use InertiaHelper to generate root template `<div>` tag ([#4](https://github.com/ishanvyas22/cakephp-inertiajs/pull/4))

### Removed
- Removed unused `webroot/` directory ([063b812](https://github.com/ishanvyas22/cakephp-inertiajs/commit/063b8129b79be87c01bb6bf672c54b6cdd0e0de7))

## [1.0.0 (2020-08-29)](https://github.com/ishanvyas22/cakephp-inertiajs/compare/0.1.1...1.0.0)

### Added
- Added tests ([#1](https://github.com/ishanvyas22/cakephp-inertiajs/pull/1))
- Added `.editorconfig` file ([3ebed1b](https://github.com/ishanvyas22/cakephp-inertiajs/pull/2/commits/3ebed1baa8e2e28499bc9a2a88467fcdd6c62dad))
- Added `cakephp/cakephp-codesniffer` as a dev dependency ([#2](https://github.com/ishanvyas22/cakephp-inertiajs/pull/2))
- Added `phpstan` as a dev dependency ([#2](https://github.com/ishanvyas22/cakephp-inertiajs/pull/2))
- Added `.travis.yml` for travis CI ([#2](https://github.com/ishanvyas22/cakephp-inertiajs/pull/2))
- Set `Vary`, `X-Inertia` headers in response when when returning json response ([a0cbe5d](https://github.com/ishanvyas22/cakephp-inertiajs/pull/3/commits/a0cbe5d588b97a09e81e1b25180057ec186d73d5), [7a2397d](https://github.com/ishanvyas22/cakephp-inertiajs/commit/7a2397d6229143f7b96224d789fb9f23e0f2fda2))
- Added AssetMix plugin as a dependency ([75505fb](https://github.com/ishanvyas22/cakephp-inertiajs/pull/3/commits/75505fb79f424c316039a1b0ee90560828a7a398), [ee74e89](https://github.com/ishanvyas22/cakephp-inertiajs/pull/3/commits/ee74e892e843129bbd0185c6bebf7eaeda447b66))
- Added `CHANGELOG.md` file ([52aabd4](https://github.com/ishanvyas22/cakephp-inertiajs/pull/3/commits/52aabd4444e7a07906bd7db8fa4e1bb9152c1fff))

### Changed
- Changed package name from `inertia-cakephp` to `cakephp/inertiajs` ([363d215](https://github.com/ishanvyas22/cakephp-inertiajs/commit/363d215ccd875b7f660edb4c838ab7fc3d08070b))
- Renamed `InertiaResponse` to `InertiaResponseTrait` ([#2](https://github.com/ishanvyas22/cakephp-inertiajs/pull/2))
- Changed `LICENSE` file ([8ac849d](https://github.com/ishanvyas22/cakephp-inertiajs/pull/2/commits/8ac849d7c353597816ff907c3705ad538fd70611))

### Removed
- Remove `webpack.mix.js` file ([581f8cc](https://github.com/ishanvyas22/cakephp-inertiajs/pull/3/commits/581f8ccb056bd6b8e6d62ef948311960e38b9c1b))
- Drop unused `InertiaComponent` ([c4f7f9b](https://github.com/ishanvyas22/cakephp-inertiajs/pull/3/commits/c4f7f9be770390d45d39e3f6c27aded68fd8b20e))

## [0.1.1 (2019-10-02)](https://github.com/ishanvyas22/cakephp-inertiajs/compare/0.1.0...0.1.1)

### Added
- REAME.md format changes

## [0.1.0 (2019-10-02)](https://github.com/ishanvyas22/cakephp-inertiajs/releases/tag/0.1.0)

Initial Release
