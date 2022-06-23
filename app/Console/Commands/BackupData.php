<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
class BackupData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'back_up:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = storage_path('app/public/backup_data.csv');
        $file = fopen($path, "w") or die("Unable to open file!");
        $columns = array('ID', 'TITLE', 'PRICE','DESCRIPTION','USER_ID','CREARTED_AT','UPDATED_AT','STATUS');
        fputcsv($file, $columns,',');
        fclose($file);
        DB::table('products')
            ->orderBy('id')
            ->chunk(10, function ($products) {
                $path = storage_path('app/public/backup_data.csv');
                $file = fopen($path, "a") or die("Unable to open file!");
                foreach ($products as $product) {
                        fputcsv($file, [
                            $product->id,
                            $product->title,
                            $product->price,
                            $product->description,
                            $product->user_id,
                            $product->created_at,
                            $product->updated_at,
                            $product->status
                        ]);
                }
            fclose($file);
        });
    }
}
