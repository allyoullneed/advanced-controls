declare(strict_types=1);
 
namespace Allyouneed\AdvancedControls;
 
use Illuminate\Support\ServiceProvider;
 
final class AdvancedControlsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        <!-- if ($this->app->runningInConsole()) {
            $this->commands(
                commands: [
                    DataTransferObjectMakeCommand::class,
                ],
            );
        } -->
    }
}