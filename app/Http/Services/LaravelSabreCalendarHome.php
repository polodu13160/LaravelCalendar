<?php

namespace App\Http\Services;

use App\Models\Events;
use Sabre\CalDAV\Plugin;
use Sabre\DAV\Exception;
use Sabre\CalDAV\CalendarHome;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Sabre\CalDAV\Backend\BackendInterface;
use Sabre\DAV\Exception\InvalidResourceType;
use Sabre\CalDAV\Xml\Property\SupportedCalendarComponentSet;

class LaravelSabreCalendarHome
{
    public $pdo;
    public $calendarTableName;
    public $calendarInstancesTableName;
    public $propertyMap = array(
        "{DAV:}displayname" => "displayname",
        "{urn:ietf:params:xml:ns:caldav}calendar-description" => "description",
        "{urn:ietf:params:xml:ns:caldav}calendar-timezone" => "timezone",
        "{http://apple.com/ns/ical/}calendar-order" => "calendarorder",
        "{http://apple.com/ns/ical/}calendar-color" => "calendarcolor"
    );

    public function __construct()
    {
        
        $this->calendarTableName = 'calendars';
        $this->calendarInstancesTableName = 'calendarinstances';
        $this->propertyMap= [
            "{DAV:}displayname" => "displayname",
            "{urn:ietf:params:xml:ns:caldav}calendar-description" => "description",
            "{urn:ietf:params:xml:ns:caldav}calendar-timezone" => "timezone",
            "{http://apple.com/ns/ical/}calendar-order" => "calendarorder",
            "{http://apple.com/ns/ical/}calendar-color" => "calendarcolor"
        ];
        $this->setPdo();
    }
    public function setPdo()
    {
        $this->pdo = DB::getPDO();
    }



   
    public function createPrincipal($type, $name, $userOrTeams){

    }

    public function createCalendarTeamOrUser($type,$name, $userOrTeams)
    {
        if ($type =='CalendarTeam'){
            $properties = ["{DAV:}displayname" => $userOrTeams->name];
            
            return $this->createCalendar($userOrTeams->principal()->first()->uri, $name, $properties);
            
        }
        else if ($type =='CalendarUser'){
           
            $properties = ["{DAV:}displayname" => $userOrTeams->username];
            
            return $this->createCalendar($userOrTeams->principal()->first()->uri, $name, $properties);
            
        }
        else{
            throw new InvalidResourceType('Vous ne pouvez pas créer de calendrier');
        }
    }
    public function createCalendar($principalUri, $calendarUri, array $properties)
    {

        $fieldNames = [
            'principaluri',
            'uri',
            'transparent',
            'calendarid',
        ];
        $values = [
            ':principaluri' => $principalUri,
            ':uri' => $calendarUri,
            ':transparent' => 0,
        ];

        $sccs = '{urn:ietf:params:xml:ns:caldav}supported-calendar-component-set';
        if (!isset($properties[$sccs])) {
            // Default value
            $components = 'VEVENT,VTODO';
        } else {
            if (!($properties[$sccs] instanceof SupportedCalendarComponentSet)) {
                throw new Exception('The ' . $sccs . ' property must be of type: \Sabre\CalDAV\Xml\Property\SupportedCalendarComponentSet');
            }
            $components = implode(',', $properties[$sccs]->getValue());
        }
        $transp = '{' . Plugin::NS_CALDAV . '}schedule-calendar-transp';
        if (isset($properties[$transp])) {
            $values[':transparent'] = 'transparent' === $properties[$transp]->getValue() ? 1 : 0;
        }
        DB::table($this->calendarTableName)->insert([
            'synctoken' => 1,
            'components' => $components,
        ]);

        $calendarId = $this->pdo->lastInsertId(
            $this->calendarTableName . '_id_seq'
        );

        $values[':calendarid'] = $calendarId;

        foreach ($this->propertyMap as $xmlName => $dbName) {
            if (isset($properties[$xmlName])) {
                $values[':' . $dbName] = $properties[$xmlName];
                $fieldNames[] = $dbName;
            }
        }

        $stmt = $this->pdo->prepare('INSERT INTO ' . $this->calendarInstancesTableName . ' (' . implode(', ', $fieldNames) . ') VALUES (' . implode(', ', array_keys($values)) . ')');



        $stmt->execute($values);

        return [
            $calendarId,
            $this->pdo->lastInsertId($this->calendarInstancesTableName . '_id_seq'),
        ];
    }
    






}