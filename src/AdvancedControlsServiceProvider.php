<?php
 
namespace AllYouNeed\AdvancedControls;
 
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use AllYouNeed\AdvancedControls\View\Components\Alert;
use AllYouNeed\AdvancedControls\View\Components\Avatar;
use AllYouNeed\AdvancedControls\View\Components\Badge;
use AllYouNeed\AdvancedControls\View\Components\Blank;
use AllYouNeed\AdvancedControls\View\Components\Button;
use AllYouNeed\AdvancedControls\View\Components\Card;
use AllYouNeed\AdvancedControls\View\Components\Checkbox;
use AllYouNeed\AdvancedControls\View\Components\Checkboxes;
use AllYouNeed\AdvancedControls\View\Components\Collapse;
use AllYouNeed\AdvancedControls\View\Components\Dropdown;
use AllYouNeed\AdvancedControls\View\Components\Indicator;
use AllYouNeed\AdvancedControls\View\Components\Input;
use AllYouNeed\AdvancedControls\View\Components\Link;
use AllYouNeed\AdvancedControls\View\Components\Menu;
use AllYouNeed\AdvancedControls\View\Components\MenuItem;
use AllYouNeed\AdvancedControls\View\Components\Modal;
use AllYouNeed\AdvancedControls\View\Components\Password;
use AllYouNeed\AdvancedControls\View\Components\Pin;
use AllYouNeed\AdvancedControls\View\Components\Radio;
use AllYouNeed\AdvancedControls\View\Components\Radios;
use AllYouNeed\AdvancedControls\View\Components\Rating;
use AllYouNeed\AdvancedControls\View\Components\RawSelect;
use AllYouNeed\AdvancedControls\View\Components\Select;
use AllYouNeed\AdvancedControls\View\Components\Skeleton;
use AllYouNeed\AdvancedControls\View\Components\Stack;
use AllYouNeed\AdvancedControls\View\Components\StackElement;
use AllYouNeed\AdvancedControls\View\Components\Tab;
use AllYouNeed\AdvancedControls\View\Components\Tabs;
use AllYouNeed\AdvancedControls\View\Components\TextArea;
use AllYouNeed\AdvancedControls\View\Components\ThemeToggle;
use AllYouNeed\AdvancedControls\View\Components\Toast;
use AllYouNeed\AdvancedControls\View\Components\Toggle;

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
            \Blade::directive('renderif', function ($expression) {
                return "<?php if (" . $expression . "): ?>";
            });
            Blade::directive('endrenderif', function ($expression) {
                return "<?php endif; ?>";
            });
        }   
    }
    public function registerComponents()
    {
        $prefix = config('prefix');

        Blade::component($prefix . 'alert'        , Alert::class);
        Blade::component($prefix . 'avatar'       , Avatar::class);
        Blade::component($prefix . 'badge'        , Badge::class);
        Blade::component($prefix . 'button'       , Button::class);
        Blade::component($prefix . 'card'         , Card::class);
        Blade::component($prefix . 'checkbox'     , Checkbox::class);
        Blade::component($prefix . 'checkboxes'   , Checkboxes::class);
        Blade::component($prefix . 'collapse'     , Collapse::class);
        Blade::component($prefix . 'dropdown'     , Dropdown::class);
        Blade::component($prefix . 'indicator'    , Indicator::class);
        Blade::component($prefix . 'input'        , Input::class);
        Blade::component($prefix . 'link'         , Link::class);
        Blade::component($prefix . 'menu'         , Menu::class);
        Blade::component($prefix . 'menuItem'     , MenuItem::class);
        Blade::component($prefix . 'modal'        , Modal::class);
        Blade::component($prefix . 'password'     , Password::class);
        Blade::component($prefix . 'pin'          , Pin::class);
        Blade::component($prefix . 'radio'        , Radio::class);
        Blade::component($prefix . 'radios'       , Radios::class);
        Blade::component($prefix . 'rating'       , Rating::class);
        Blade::component($prefix . 'raw-select'   , RawSelect::class);
        Blade::component($prefix . 'select'       , Select::class);
        Blade::component($prefix . 'skeleton'     , Skeleton::class);
        Blade::component($prefix . 'stack'        , Stack::class);
        Blade::component($prefix . 'stack-element', StackElement::class);
        Blade::component($prefix . 'switch'       , Toggle::class);
        Blade::component($prefix . 'tab'          , Tab::class);
        Blade::component($prefix . 'tabs'         , Tabs::class);
        Blade::component($prefix . 'textarea'     , TextArea::class);
        Blade::component($prefix . 'theme-toggle' , ThemeToggle::class);
        Blade::component($prefix . 'toast'        , Toast::class);
        Blade::component($prefix . 'toggle'       , Toggle::class);
    }
}