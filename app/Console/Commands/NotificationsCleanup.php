<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NotificationsCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    /**
     * The console command description.
     *
     * @var string
     */
    protected $signature = 'notifications:cleanup';
    protected $description = 'Eliminar notificaciones leídas después de un cierto tiempo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Eliminar notificaciones leídas después de, por ejemplo, 7 días esta con 1 dia
        $daysToKeep = 1;
        $cutoffDate = now()->subDays($daysToKeep);

        DB::table('notifications')
            ->whereNotNull('read_at')
            ->where('read_at', '<', $cutoffDate)
            ->delete();

        $this->info('Notificaciones leídas eliminadas con éxito.');
    }
}
