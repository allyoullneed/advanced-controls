<?php
 
namespace AllYouNeed\AdvancedControls;
 
use Illuminate\Support\ServiceProvider;
 
final class AdvancedControlsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // if ($this->app->runningInConsole()) {
        //     $this->commands(
        //         commands: [
        //             DataTransferObjectMakeCommand::class,
        //         ],
        //     );
        // }
    }
}