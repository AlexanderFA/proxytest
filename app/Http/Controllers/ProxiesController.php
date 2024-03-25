<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Models\BulkChecker;
use App\Interfaces\AsyncClientInterface;

class ProxiesController extends Controller
{
    public function index(AsyncClientInterface $client)
    {
        // TODO get these results by ajax
        // TODO create some request validator
        $sockets = preg_split('/\s+/', request()->post('sockets'), -1, PREG_SPLIT_NO_EMPTY);
        $checker = new BulkChecker($sockets, $client);
        $checker->process();
        
        return View::make('index', compact('checker'));
    }
}
