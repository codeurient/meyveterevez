<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\PhoneCountryCode;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalUsers'     => User::count(),
            'totalLocations' => Location::count(),
            'totalCountries' => Location::countries()->count(),
            'totalCities'    => Location::cities()->count(),
            'totalCodes'     => PhoneCountryCode::count(),
        ]);
    }
}
