<?php
 
namespace AllYouNeed\AdvancedControls;
 
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

use AllYouNeed\AdvancedControls\View\Components\Button;
use AllYouNeed\AdvancedControls\View\Components\Tabs;
use AllYouNeed\AdvancedControls\View\Components\ThemeToggle;
 
final class AdvancedControlsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
        //     $this->commands(
        //         commands: [
        //             DataTransferObjectMakeCommand::class,
        //         ],
        //     );
        }
        else {
            $this->registerComponents();
        }   
    }
    public function registerComponents()
    {
        // // No matter if components has custom prefix or not,
        // // we also register below alias to avoid naming collision,
        // // because they are used inside some Mary's components itself.
        // Blade::component('mary-button', Button::class);

        $prefix = config('prefix');

        // Blade
        Blade::component($prefix . 'button', Button::class);
        //Blade::component($prefix . 'tabs', Tabs::class);
        Blade::component($prefix . 'theme-toggle', ThemeToggle::class);

        // Livewire
        Livewire::addLocation(
             viewPath: resource_path('views/admin/components')
        );
    }
}