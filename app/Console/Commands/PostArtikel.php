<?php

namespace App\Console\Commands;

use App\Http\Controllers\ArtikelController;
use Illuminate\Console\Command;
use App\Http\Controllers\DiskusiController;
use Illuminate\Support\Facades\App;

class PostArtikel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:artikel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirimkan data JSON dari public/js/data/artikel.json ke function store di ArtikelController';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = public_path('js/data/artikel.json');

        if (!file_exists($filePath)) {
            $this->error("File tidak ditemukan: {$filePath}");
            return Command::FAILURE;
        }

        // Baca file JSON
        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Gagal membaca file JSON. Pastikan formatnya valid.');
            return Command::FAILURE;
        }

        // Panggil function store di ArtikelController
        $controller = App::make(ArtikelController::class);
        $response = $controller->store(new \Illuminate\Http\Request($data));

        $this->info('Data berhasil dikirim ke function store di ArtikelController.');
        $this->line('Response: ' . json_encode($response->getData()));

        return Command::SUCCESS;
    }
}
