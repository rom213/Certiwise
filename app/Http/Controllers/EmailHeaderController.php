<?php

namespace App\Http\Controllers;

use App\Models\EmailHeader;
use Illuminate\Http\Request;

class EmailHeaderController extends Controller
{
    public function index() {
        $headers = EmailHeader::all();
        return Response($headers, 200);
    }
}
