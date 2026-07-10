<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [

            Menu::make('Blog')
                ->icon('bs.newspaper')
                ->title('Content')
                ->route('news.list'),

            Menu::make('Main banners')
                ->icon('bs.fullscreen')
                ->route('main.banners'),

            Menu::make('Tours')
                ->icon('bs.backpack4')
                ->title('Catalog')
                ->route('tours.list'),

            Menu::make('Timeslots')
                ->icon('bs.calendar-date')
                ->route('timeslot.list'),

            Menu::make('Stoplist')
                ->icon('bs.ban')
                ->route('tour_stops.list'),

            Menu::make('Orders')
                ->icon('bs.graph-up')
                ->route('orders.list'),

            Menu::make('Assets')
                ->title('resources')
                ->icon('bs.code-slash')
                ->route('assets.edit'),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),


        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
