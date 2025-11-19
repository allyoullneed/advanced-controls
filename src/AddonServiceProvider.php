<?php



use Illuminate\Support\Facades\Blade;
use AdvancedControls\Components\ThemeToggle;

class AddonServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        $this->registerComponents();
        // $this->registerBladeDirectives();

        // $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // // Publishing is only necessary when using the CLI.
        // if ($this->app->runningInConsole()) {
        //     $this->bootForConsole();
        // }
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

    public function registerBladeDirectives(): void
    {
        $this->registerScopeDirective();
    }

    public function registerScopeDirective(): void
    {
        /**
         * All credits from this blade directive goes to Konrad Kalemba.
         * Just copied and modified for my very specific use case.
         *
         * https://github.com/konradkalemba/blade-components-scoped-slots
         */
        Blade::directive('scope', function ($expression) {
            // Split the expression by `top-level` commas (not in parentheses)
            $directiveArguments = preg_split("/,(?![^\(\(]*[\)\)])/", $expression);
            $directiveArguments = array_map('trim', $directiveArguments);

            [$name, $functionArguments] = $directiveArguments;

            // Build function "uses" to inject extra external variables
            $uses = Arr::except(array_flip($directiveArguments), [$name, $functionArguments]);
            $uses = array_flip($uses);
            array_push($uses, '$__env');
            array_push($uses, '$__bladeCompiler');
            $uses = implode(',', $uses);

            /**
             *  Slot names can`t contains dot , eg: `user.city`.
             *  So we convert `user.city` to `user___city`
             *
             *  Later, on component it will be replaced back.
             */
            $name = str_replace('.', '___', $name);

            return "<?php \$__bladeCompiler = \$__bladeCompiler ?? null; \$loop = null; \$__env->slot({$name}, function({$functionArguments}) use ({$uses}) { \$loop = (object) \$__env->getLoopStack()[0] ?>";
        });

        Blade::directive('endscope', function () {
            return '<?php }); ?>';
        });
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/advancedcontrols.php', 'advancedcontrols');

        // Register the service the package provides.
        $this->app->singleton('advancedcontrols', function ($app) {
            return new AdvancedControls();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['advanced-controls'];
    }

    /**
     * Console-specific booting.
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/advanced-controls.php' => config_path('advanced-controls.php'),
        ], 'advanced-controls.config');

        //$this->commands([MaryInstallCommand::class, MaryBootcampCommand::class]);
    }
}
