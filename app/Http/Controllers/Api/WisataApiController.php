<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penginapan;
use App\Models\Wisata;
use App\Models\Restoran;
use Illuminate\Http\Request;

class WisataApiController extends Controller
{
    public function index_wisata(Request $request)
    {
        return Wisata::all();
    }
    public function index_penginapan(Request $request)
    {
        return Penginapan::all();
    }
    public function index_restoran(Request $request)
    {
        return Restoran::all();
}
}