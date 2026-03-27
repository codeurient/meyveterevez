<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Auth;

use App\Actions\Auth\RegisterAction;
use App\DTOs\Auth\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Location;
use App\Models\PhoneCountryCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        $countries  = Location::where('type', 'country')->where('is_active', true)->orderBy('name')->get();
        $cities     = Location::where('type', 'city')->where('is_active', true)->orderBy('name')->get();

        $phoneCodesJson = PhoneCountryCode::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(fn ($pc) => [
                'code'       => $pc->code,
                'phone_code' => $pc->phone_code,
                'name'       => $pc->translated_name,
            ]);

        return view('pages.auth.register', compact('countries', 'cities', 'phoneCodesJson'));
    }

    public function store(RegisterRequest $request, RegisterAction $action): RedirectResponse
    {
        $action->execute(RegisterDTO::fromRequest($request));

        return redirect()->route('home');
    }
}
