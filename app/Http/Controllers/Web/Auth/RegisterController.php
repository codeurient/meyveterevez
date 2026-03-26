<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Auth;

use App\Actions\Auth\RegisterAction;
use App\DTOs\Auth\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('pages.auth.register');
    }

    public function store(RegisterRequest $request, RegisterAction $action): RedirectResponse
    {
        $action->execute(RegisterDTO::fromRequest($request));

        return redirect()->route('home');
    }
}
