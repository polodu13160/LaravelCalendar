<?php

namespace App\Http\Controllers;

use PDO;
use Sabre\DAV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServeurControllers
{
    public function handle(){
        // Now we're creating a whole bunch of objects
        $rootDirectory = new DAV\FS\Directory(public_path('Sabre'));
        $pdo = DB::getPdo();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $authBackend = new \Sabre\DAV\Auth\Backend\PDO($pdo);
        $principalBackend = new \Sabre\DAVACL\PrincipalBackend\PDO($pdo);
        $carddavBackend = new \Sabre\CardDAV\Backend\PDO($pdo);
        $caldavBackend = new \Sabre\CalDAV\Backend\PDO($pdo);

        $logger = new \Monolog\Logger('SabreDav');
        $logger->pushHandler(new \Monolog\Handler\RotatingFileHandler(__DIR__ . '/sabredav.log', 3, \Monolog\Logger::DEBUG, true, 0600));

        $nodes = [
            // /principals
            new \Sabre\CalDAV\Principal\Collection($principalBackend),
            // /calendars
            new \Sabre\CalDAV\CalendarRoot($principalBackend, $caldavBackend),
            // /addressbook
            // new \Sabre\CardDAV\AddressBookRoot($principalBackend, $carddavBackend),
        ];

        $server = new \Sabre\DAV\Server($nodes);

        $server->setBaseUri('/sabredav');
        $server->setLogger($logger);

        // Plugins
        // $server->addPlugin(new \Sabre\DAV\Auth\Plugin($authBackend));
        $server->addPlugin(new \Sabre\DAV\Browser\Plugin());
        $server->addPlugin(new \Sabre\DAV\Sync\Plugin());
        $server->addPlugin(new \Sabre\DAV\Sharing\Plugin());
        // $server->addPlugin(new \Sabre\DAVACL\Plugin());

        // CalDAV plugins
        $server->addPlugin(new \Sabre\CalDAV\Plugin());
        $server->addPlugin(new \Sabre\CalDAV\Schedule\Plugin());
        $server->addPlugin(new \Sabre\CalDAV\SharingPlugin());
        $server->addPlugin(new \Sabre\CalDAV\ICSExportPlugin());


        // And off we go!
        $server->start();

    }

}
