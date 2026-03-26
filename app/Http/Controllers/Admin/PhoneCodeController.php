<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\PhoneCode\CreatePhoneCodeAction;
use App\Actions\Admin\PhoneCode\DeletePhoneCodeAction;
use App\Actions\Admin\PhoneCode\UpdatePhoneCodeAction;
use App\DTOs\Admin\PhoneCodeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePhoneCodeRequest;
use App\Http\Requests\Admin\UpdatePhoneCodeRequest;
use App\Models\PhoneCountryCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PhoneCodeController extends Controller
{
    public function index(): View
    {
        $codes = PhoneCountryCode::orderBy('name')->paginate(25);
        return view('admin.phone-codes.index', compact('codes'));
    }

    public function create(): View
    {
        return view('admin.phone-codes.create');
    }

    public function store(StorePhoneCodeRequest $request, CreatePhoneCodeAction $action): RedirectResponse
    {
        $action->execute(PhoneCodeDTO::fromRequest($request));

        return redirect()->route('admin.phone-codes.index')
            ->with('success', __t('admin.phone_code_created'));
    }

    public function edit(PhoneCountryCode $phoneCode): View
    {
        return view('admin.phone-codes.edit', compact('phoneCode'));
    }

    public function update(UpdatePhoneCodeRequest $request, PhoneCountryCode $phoneCode, UpdatePhoneCodeAction $action): RedirectResponse
    {
        $action->execute($phoneCode, PhoneCodeDTO::fromRequest($request));

        return redirect()->route('admin.phone-codes.index')
            ->with('success', __t('admin.phone_code_updated'));
    }

    public function destroy(PhoneCountryCode $phoneCode, DeletePhoneCodeAction $action): RedirectResponse
    {
        $action->execute($phoneCode);

        return redirect()->route('admin.phone-codes.index')
            ->with('success', __t('admin.phone_code_deleted'));
    }
}
