<?php
 
namespace AllYoullNeed\AdvancedControls;
 
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use AllYoullNeed\AdvancedControls\View\Components\Alert;
use AllYoullNeed\AdvancedControls\View\Components\Avatar;
use AllYoullNeed\AdvancedControls\View\Components\Badge;
use AllYoullNeed\AdvancedControls\View\Components\Blank;
use AllYoullNeed\AdvancedControls\View\Components\Button;
use AllYoullNeed\AdvancedControls\View\Components\Card;
use AllYoullNeed\AdvancedControls\View\Components\Carousel;
use AllYoullNeed\AdvancedControls\View\Components\Checkbox;
use AllYoullNeed\AdvancedControls\View\Components\Checkboxes;
use AllYoullNeed\AdvancedControls\View\Components\Collapse;
use AllYoullNeed\AdvancedControls\View\Components\Dropdown;
use AllYoullNeed\AdvancedControls\View\Components\Indicator;
use AllYoullNeed\AdvancedControls\View\Components\Input;
use AllYoullNeed\AdvancedControls\View\Components\Loading;
use AllYoullNeed\AdvancedControls\View\Components\Menu;
use AllYoullNeed\AdvancedControls\View\Components\MenuItem;
use AllYoullNeed\AdvancedControls\View\Components\Modal;
use AllYoullNeed\AdvancedControls\View\Components\Password;
use AllYoullNeed\AdvancedControls\View\Components\Pin;
use AllYoullNeed\AdvancedControls\View\Components\RadialProgress;
use AllYoullNeed\AdvancedControls\View\Components\Radio;
use AllYoullNeed\AdvancedControls\View\Components\Radios;
use AllYoullNeed\AdvancedControls\View\Components\Range;
use AllYoullNeed\AdvancedControls\View\Components\Rating;
use AllYoullNeed\AdvancedControls\View\Components\RawSelect;
use AllYoullNeed\AdvancedControls\View\Components\Row;
use AllYoullNeed\AdvancedControls\View\Components\Select;
use AllYoullNeed\AdvancedControls\View\Components\Skeleton;
use AllYoullNeed\AdvancedControls\View\Components\SkewedGallery;
use AllYoullNeed\AdvancedControls\View\Components\Slide;
use AllYoullNeed\AdvancedControls\View\Components\SlideShow;
use AllYoullNeed\AdvancedControls\View\Components\Stack;
use AllYoullNeed\AdvancedControls\View\Components\StackElement;
use AllYoullNeed\AdvancedControls\View\Components\Star;
use AllYoullNeed\AdvancedControls\View\Components\Tab;
use AllYoullNeed\AdvancedControls\View\Components\Tabs;
use AllYoullNeed\AdvancedControls\View\Components\Table;
use AllYoullNeed\AdvancedControls\View\Components\TextArea;
use AllYoullNeed\AdvancedControls\View\Components\ThemeToggle;
use AllYoullNeed\AdvancedControls\View\Components\Timeline;
use AllYoullNeed\AdvancedControls\View\Components\TimelineEvent;
use AllYoullNeed\AdvancedControls\View\Components\Toast;
use AllYoullNeed\AdvancedControls\View\Components\Toggle;

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

        Blade::component($prefix . 'alert'          , Alert::class);
        Blade::component($prefix . 'avatar'         , Avatar::class);
        Blade::component($prefix . 'badge'          , Badge::class);
        Blade::component($prefix . 'button'         , Button::class);
        Blade::component($prefix . 'card'           , Card::class);
        Blade::component($prefix . 'carousel'       , Carousel::class);
        Blade::component($prefix . 'checkbox'       , Checkbox::class);
        Blade::component($prefix . 'checkboxes'     , Checkboxes::class);
        Blade::component($prefix . 'collapse'       , Collapse::class);
        Blade::component($prefix . 'dropdown'       , Dropdown::class);
        Blade::component($prefix . 'indicator'      , Indicator::class);
        Blade::component($prefix . 'input'          , Input::class);
        Blade::component($prefix . 'link'           , Link::class);
        Blade::component($prefix . 'loading'        , Loading::class);
        Blade::component($prefix . 'menu'           , Menu::class);
        Blade::component($prefix . 'menuItem'       , MenuItem::class);
        Blade::component($prefix . 'modal'          , Modal::class);
        Blade::component($prefix . 'password'       , Password::class);
        Blade::component($prefix . 'pin'            , Pin::class);
        Blade::component($prefix . 'radial-progress', RadialProgress::class);
        Blade::component($prefix . 'radio'          , Radio::class);
        Blade::component($prefix . 'radios'         , Radios::class);
        Blade::component($prefix . 'range'          , Range::class);
        Blade::component($prefix . 'rating'         , Rating::class);
        Blade::component($prefix . 'raw-select'     , RawSelect::class);
        Blade::component($prefix . 'row'            , Row::class);
        Blade::component($prefix . 'select'         , Select::class);
        Blade::component($prefix . 'skeleton'       , Skeleton::class);
        Blade::component($prefix . 'skewed-gallery' , SkewedGallery::class);
        Blade::component($prefix . 'slide'          , Slide::class);
        Blade::component($prefix . 'slideshow'      , SlideShow::class);
        Blade::component($prefix . 'stack'          , Stack::class);
        Blade::component($prefix . 'stack-element'  , StackElement::class);
        Blade::component($prefix . 'star'           , Star::class);
        Blade::component($prefix . 'switch'         , Toggle::class);
        Blade::component($prefix . 'tab'            , Tab::class);
        Blade::component($prefix . 'tabs'           , Tabs::class);
        Blade::component($prefix . 'table'          , Table::class);
        Blade::component($prefix . 'textarea'       , TextArea::class);
        Blade::component($prefix . 'theme-toggle'   , ThemeToggle::class);
        Blade::component($prefix . 'timeline'       , Timeline::class);
        Blade::component($prefix . 'timeline-event' , TimelineEvent::class);
        Blade::component($prefix . 'toast'          , Toast::class);
        Blade::component($prefix . 'toggle'         , Toggle::class);
    }
}