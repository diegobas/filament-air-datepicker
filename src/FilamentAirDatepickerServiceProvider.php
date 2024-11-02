<?php

namespace DiegoBas\FilamentAirDatepicker;

use DiegoBas\FilamentAirDatepicker\Commands\FilamentAirDatepickerCommand;
use DiegoBas\FilamentAirDatepicker\Testing\TestsFilamentAirDatepicker;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentAirDatepickerServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-air-datepicker';

    public static string $viewNamespace = 'filament-air-datepicker';

    public function boot()
    {
        parent::boot();

        $languages = $this->package->basePath('/../resources/lang/');
        if (file_exists($languages . app()->getLocale())) {
            $languages .= app()->getLocale();
        } else {
            $languages .= 'en';
        }

        FilamentAsset::registerScriptData([
            'locale' => include $languages . '/air-datepicker.php',
        ]);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('diegobas/filament-air-datepicker');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-air-datepicker/{$file->getFilename()}"),
                ], 'filament-air-datepicker-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFilamentAirDatepicker);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'diegobas/filament-air-datepicker';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            AlpineComponent::make('filament-air-datepicker', __DIR__ . '/../resources/dist/filament-air-datepicker.js'),
            Css::make('filament-air-datepicker-styles', __DIR__ . '/../resources/dist/filament-air-datepicker.css'),
            //Js::make('filament-air-datepicker-scripts', __DIR__ . '/../resources/dist/filament-air-datepicker.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FilamentAirDatepickerCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_filament-air-datepicker_table',
        ];
    }
}
