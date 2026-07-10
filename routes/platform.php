<?php

declare(strict_types=1);

use App\Orchid\Screens\Admin\Banners\Main\MainBannersEditScreen;
use App\Orchid\Screens\Admin\Banners\Main\MainBannersListScreen;
use App\Orchid\Screens\Admin\News\NewsCreateScreen;
use App\Orchid\Screens\Admin\News\NewsEditScreen;
use App\Orchid\Screens\Admin\News\NewsListScreen;
use App\Orchid\Screens\Admin\Orders\OrdersEditScreen;
use App\Orchid\Screens\Admin\Orders\OrdersListScreen;
use App\Orchid\Screens\Admin\Timeslot\TimeslotCreateScreen;
use App\Orchid\Screens\Admin\Timeslot\TimeslotEditScreen;
use App\Orchid\Screens\Admin\Timeslot\TimeslotListScreen;
use App\Orchid\Screens\Admin\Tours\ToursCreateScreen;
use App\Orchid\Screens\Admin\Tours\ToursEditScreen;
use App\Orchid\Screens\Admin\Tours\ToursListScreen;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;
use App\Orchid\Screens\Admin\Banners\Main\MainBannersCreateScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

//Route::screen('idea', Idea::class, 'platform.screens.idea');

// news
Route::screen('/news', NewsListScreen::class)->name('news.list')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Blog'), route('news.list')));

Route::screen('/news/create', NewsCreateScreen::class)->name('news.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('news.list')
        ->push(__('Create news'), route('news.list')));

Route::screen('/news/{id}/edit', NewsEditScreen::class)
    ->name('news.edit')
    ->breadcrumbs(fn(Trail $trail, $id) => $trail
        ->parent('news.list', $id)
        ->push('Edit news', route('news.edit', $id)));

// main banners

Route::screen('/banners/main/list', MainBannersListScreen::class)->name('main.banners')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Main banners list'), route('main.banners')));

Route::screen('/banners/main/create', MainBannersCreateScreen::class)->name('main.banners.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('main.banners')
        ->push(__('Create main banners'), route('main.banners')));

Route::screen('/banners/main/{id}/edit', MainBannersEditScreen::class)
    ->name('main.banners.edit')
    ->breadcrumbs(fn(Trail $trail, $id) => $trail
        ->parent('main.banners', $id)
        ->push('Edit Banner', route('main.banners.edit', $id)));
// Tours

Route::screen('/tours/list', ToursListScreen::class)->name('tours.list')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Tours list'), route('tours.list')));

Route::screen('/tours/create', ToursCreateScreen::class)->name('tours.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('tours.list')
        ->push(__('Create tour'), route('tours.list')));


Route::screen('/tours/{id}/edit', ToursEditScreen::class)
    ->name('tour.edit')
    ->breadcrumbs(fn(Trail $trail, $id) => $trail
        ->parent('tours.list', $id)
        ->push('Edit tour', route('tour.edit', $id)));

// timeslot

Route::screen('/timeslot/list', TimeslotListScreen::class)->name('timeslot.list')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Timeslots'), route('timeslot.list')));

Route::screen('/timeslot/create', TimeslotCreateScreen::class)->name('timeslot.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('timeslot.list')
        ->push(__('Create new Timeslot'), route('timeslot.create')));


Route::screen('/timeslot/{id}/edit', TimeslotEditScreen::class)->name('timeslot.edit')
    ->breadcrumbs(fn(Trail $trail, $id) => $trail
        ->parent('timeslot.list')
        ->push(__('Edit Timeslot'), route('timeslot.edit', $id)));

// Orders

Route::screen('/orders/list', OrdersListScreen::class)->name('orders.list')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Orders'), route('orders.list')));

Route::screen('/orders/{id}/edit', OrdersEditScreen::class)->name('orders.edit')
    ->breadcrumbs(fn(Trail $trail, $id) => $trail
        ->parent('orders.list')
        ->push(__('View Order'), route('orders.edit', $id)));


// Tour stop list

Route::screen('/tour_stops/list', \App\Orchid\Screens\Admin\Stoplist\StoplistScreen::class)->name('tour_stops.list')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Stop list'), route('tour_stops.list')));


Route::screen('/tour_stops/create', \App\Orchid\Screens\Admin\Stoplist\StoplistCreateScreen::class)->name('tour_stops.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('tour_stops.list')
        ->push(__('Create Stop list'), route('tour_stops.create')));

Route::screen('/tour_stops/{id}/edit', \App\Orchid\Screens\Admin\Stoplist\StoplistEditScreen::class)->name('tour_stops.edit')
    ->breadcrumbs(fn(Trail $trail, $id) => $trail
        ->parent('tour_stops.list')
        ->push(__('Edit Stop list'), route('tour_stops.edit', $id)));

Route::screen('/tour_stops/edit', \App\Orchid\Screens\Admin\Assets\AssetsEditScreen::class)->name('assets.edit')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Edit Assets'), route('assets.edit')));
