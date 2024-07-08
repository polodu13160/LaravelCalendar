<?php

namespace App\Console\Commands;

use App\Models\Events;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VerifyEventsIcs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verify-database-events-ics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Events::orderBy('updated_at', 'desc')->get();
        $x = 0;

        foreach ($events as $event) {
            try {
                $ics = $event->calendarObject()->first();

                if ($ics == null) {
                    $event->createIcs();
                } elseif ($ics->lastmodified > $event->updated_at->getTimestamp()) {
                    $event->modificationIcsToEvent();
                } elseif ($ics->lastmodified < $event->updated_at->getTimestamp()) {
                    $event->modificationEventToIcs();
                }

                Log::channel('events-ics')->info(now()->format('j m Y H:i:s').' Succès : Mise à jour réussie pour l\'événement ID '.$event->id);

            } catch (\Exception $e) {

                Log::channel('events-ics')->error(now()->format('j m Y H:i:s').' Échec : Impossible de mettre à jour l\'événement ID '.$event->id.'. Erreur : '.$e->getMessage());
                $x++;

            }
        }
        if ($x == 0) {
            $this->info('Tous les événements ont été vérifiés et mis à jour avec succès.');

            return;
        } else {
            $this->error('Certains événements n\'ont pas pu être vérifiés et mis à jour. Veuillez consulter les logs pour plus d\'informations.'.$x.' événements n\'ont pas pu être mis à jour.');

            return;
        }

    }
}
