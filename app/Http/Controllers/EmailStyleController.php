<?php

namespace App\Http\Controllers;

use App\Models\EmailStyle;
use Illuminate\Http\Request;

class EmailStyleController extends Controller
{
    public function index() {
        $styles = EmailStyle::all();
        return Response($styles, 200);
    }
}
