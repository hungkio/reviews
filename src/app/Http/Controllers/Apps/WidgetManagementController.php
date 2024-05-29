<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WidgetManagementController extends Controller
{
    public function index()
    {
        return view('pages/apps.manage.widget.list');
    }

    public function previewWall()
    {
        return view('pages/apps.manage.widget.review-wall');
    }
    public function previewBadge()
    {
        return view('pages/apps.manage.widget.badge');
    }
    public function previewToast()
    {
        return view('pages/apps.manage.widget.toast');
    }
    public function previewCarousel()
    {
        return view('pages/apps.manage.widget.carousel');
    }
}
