<?php
 
namespace AllYouNeed\AdvancedControls;
 
use Illuminate\Support\ServiceProvider;
use AllYouNeed\AdvancedControls\Components\ThemeToggle;
 
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
        // // Just rename <x-icon> provided by BladeUI Icons to <x-svg> to not collide with ours
        // Blade::component('BladeUI\Icons\Components\Icon', 'svg');

        // // No matter if components has custom prefix or not,
        // // we also register below alias to avoid naming collision,
        // // because they are used inside some Mary's components itself.
        // Blade::component('mary-button', Button::class);

        $prefix = config('prefix');

        // Blade
        Blade::component($prefix . 'theme-toggle', ThemeToggle::class);
    }
}