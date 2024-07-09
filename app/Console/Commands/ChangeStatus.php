<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
class ChangeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to change-status number';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders=Order::get();
        foreach($orders as $order){
            $order->update([
                'status_number'=>1
                ]);
        }
    }
}