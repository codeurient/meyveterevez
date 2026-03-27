<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Locale\CreateLocaleAction;
use App\Actions\Admin\Locale\DeleteLocaleAction;
use App\Actions\Admin\Locale\UpdateLocaleAction;
use App\DTOs\Admin\LocaleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLocaleRequest;
use App\Http\Requests\Admin\UpdateLocaleRequest;
use App\Models\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class LocaleController extends Controller
{
    public function index(): View
    {
        $locales = Locale::orderBy('sort_order')->get();

        return view('admin.locales.index', compact('locales'));
    }

    public function create(): View
    {
        return view('admin.locales.create');
    }

    public function store(StoreLocaleRequest $request, CreateLocaleAction $action): RedirectResponse
    {
        $action->execute(LocaleDTO::fromRequest($request));

        return redirect()->route('admin.locales.index')
            ->with('success', __t('admin.locale_created'));
    }

    public function edit(Locale $locale): View
    {
        return view('admin.locales.edit', compact('locale'));
    }

    public function update(UpdateLocaleRequest $request, Locale $locale, UpdateLocaleAction $action): RedirectResponse
    {
        $action->execute($locale, LocaleDTO::fromRequest($request));

        return redirect()->route('admin.locales.index')
            ->with('success', __t('admin.locale_updated'));
    }

    public function destroy(Locale $locale, DeleteLocaleAction $action): RedirectResponse
    {
        try {
            $action->execute($locale);

            return redirect()->route('admin.locales.index')
                ->with('success', __t('admin.locale_deleted'));
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }
}
