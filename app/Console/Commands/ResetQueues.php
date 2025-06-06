<?php

namespace App\Console\Commands;

use App\Models\Queues;
use Illuminate\Console\Command;

class ResetQueues extends Command
{
     protected $signature = 'queues:reset';
    protected $description = 'Soft-delete all queues with status selesai, sehingga nomor antrian kembali ke A-001';

    public function handle()
    {
         $count = Queues::where('status', 'selesai')->delete();
        $this->info("{$count} queue(s) with status 'selesai' have been reset.");
    }
}
