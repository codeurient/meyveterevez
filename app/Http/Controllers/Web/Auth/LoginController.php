<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('pages.auth.login');
    }

    public function store(LoginRequest $request, LoginAction $action): RedirectResponse
    {
        $action->execute(
            $request,
            $request->validated('email'),
            $request->validated('password'),
            (bool) $request->validated('remember'),
        );

        return redirect()->intended(route('home'));
    }

    public function destroy(Request $request, LogoutAction $action): RedirectResponse
    {
        $action->execute($request);

        return redirect()->route('home');
    }
}
