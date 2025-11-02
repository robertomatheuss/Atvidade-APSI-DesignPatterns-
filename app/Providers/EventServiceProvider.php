use App\Events\StockPriceChanged;
use App\Listeners\SmsPriceObserver;
use App\Listeners\EmailPriceObserver;
use App\Listeners\DashboardPriceObserver;

protected $listen = [
    StockPriceChanged::class => [
        SmsPriceObserver::class,
        EmailPriceObserver::class,
        DashboardPriceObserver::class,
    ],
];
