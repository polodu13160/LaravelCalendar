<?php

namespace App\Providers;

use App\Auth\AuthBackend;
use App\Http\Services\LaravelSabre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Sabre\CalDAV\Backend\PDO;
use Sabre\CalDAV\CalendarRoot;
use Sabre\CalDAV\Plugin as CalDAVPlugin;
// use Sabre\CardDAV\Plugin as CardDAVPlugin;
use Sabre\DAV\Auth\Plugin as AuthPlugin;
use Sabre\DAV\Browser\Plugin as BrowserPlugin;
use Sabre\DAVACL\PrincipalBackend\PDO as PrincipalBackend;
use Sabre\DAVACL\PrincipalCollection;

class DAVServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function boot(): void
    {
        LaravelSabre::nodes(function () {
            return $this->nodes();
        });
        LaravelSabre::plugins(function () {
            return $this->plugins();

        });

    }

    private function nodes(): array
    {
        $pdo = DB::getPdo();
        $principalBackend = new PrincipalBackend($pdo);
        $calendarBackend = new PDO($pdo);

        return [
            new PrincipalCollection($principalBackend),
            new CalendarRoot($principalBackend, $calendarBackend),
        ];
    }

    private function plugins()
    {
        // Authentication backend
        // $authBackend = new AuthBackend();
        // yield new AuthPlugin($authBackend);

        // CardDAV plugin
        yield new CalDAVPlugin();

        yield new BrowserPlugin();
    }
}
