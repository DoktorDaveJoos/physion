<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function __invoke(Order $order)
    {
        $assetPath = Storage::disk('digitalocean')->url('Energieausweis_Pfennig_ENEV_20221207.pdf');

        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . basename($assetPath));
        header("Content-Type: application/pdf" );

        return readfile($assetPath);

    }
}
