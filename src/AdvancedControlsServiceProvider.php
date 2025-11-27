<?php
 
namespace AllYouNeed\AdvancedControls;
 
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

use AllYouNeed\AdvancedControls\View\Components\Button;
use AllYouNeed\AdvancedControls\View\Components\Collapse;
use AllYouNeed\AdvancedControls\View\Components\Link;
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
        $prefix = config('prefix');

        // Blade
        Blade::component($prefix . 'button'      , Button::class);
        Blade::component($prefix . 'collapse'    , Collapse::class);
        Blade::component($prefix . 'link'        , Link::class);
        Blade::component($prefix . 'theme-toggle', ThemeToggle::class);


    }
}