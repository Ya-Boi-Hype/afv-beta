<?php

namespace App\Http\Controllers;

class DownloadController extends Controller
{
    public function standalone()
    {
        return response()->download(storage_path('app/Audio For VATSIM.msi'));
    }

    public function euroscope()
    {
        return response()->download(storage_path('app/EuroscopeBeta32a21WithAFVShortcut.zip'));
    }
}
