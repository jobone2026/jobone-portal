<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class OsogController extends Controller
{
    public function index(Request $request)
    {
        // Security: Only allow access from localhost or specific IP
        $allowed_ips = ['127.0.0.1', '::1', '3.108.161.67'];
        if (!in_array($request->ip(), $allowed_ips)) {
            abort(403, 'Access denied');
        }

        $action = $request->get('action', 'menu');
        
        return view('osog.index', compact('action'));
    }
}
