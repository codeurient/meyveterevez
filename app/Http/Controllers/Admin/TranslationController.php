<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Translation\CreateTranslationAction;
use App\Actions\Admin\Translation\DeleteTranslationAction;
use App\Actions\Admin\Translation\UpdateTranslationAction;
use App\DTOs\Admin\TranslationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTranslationRequest;
use App\Http\Requests\Admin\UpdateTranslationRequest;
use App\Models\Locale;
use App\Models\Translation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TranslationController extends Controller
{
    private const GROUPS = ['button', 'nav', 'label', 'placeholder', 'message', 'heading', 'error', 'email', 'auth', 'admin'];

    public function index(Request $request): View
    {
        $query = Translation::query();

        if ($request->filled('locale')) {
            $query->where('locale', $request->input('locale'));
        }

        if ($request->filled('group')) {
            $query->where('group', $request->input('group'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(fn ($q) => $q->where('key', 'like', "%{$search}%")
                                       ->orWhere('value', 'like', "%{$search}%"));
        }

        $translations = $query->orderBy('group')->orderBy('key')->paginate(50)->withQueryString();
        $locales      = Locale::where('is_active', true)->orderBy('sort_order')->get();
        $groups       = self::GROUPS;

        return view('admin.translations.index', compact('translations', 'locales', 'groups'));
    }

    public function create(): View
    {
        $locales = Locale::where('is_active', true)->orderBy('sort_order')->get();
        $groups  = self::GROUPS;

        return view('admin.translations.create', compact('locales', 'groups'));
    }

    public function store(StoreTranslationRequest $request, CreateTranslationAction $action): RedirectResponse
    {
        $action->execute(TranslationDTO::fromRequest($request));

        return redirect()->route('admin.translations.index')
            ->with('success', __t('admin.translation_created'));
    }

    public function edit(Translation $translation): View
    {
        $locales = Locale::where('is_active', true)->orderBy('sort_order')->get();
        $groups  = self::GROUPS;

        return view('admin.translations.edit', compact('translation', 'locales', 'groups'));
    }

    public function update(UpdateTranslationRequest $request, Translation $translation, UpdateTranslationAction $action): RedirectResponse
    {
        $action->execute($translation, TranslationDTO::fromRequest($request));

        return redirect()->route('admin.translations.index')
            ->with('success', __t('admin.translation_updated'));
    }

    public function destroy(Translation $translation, DeleteTranslationAction $action): RedirectResponse
    {
        $action->execute($translation);

        return redirect()->route('admin.translations.index')
            ->with('success', __t('admin.translation_deleted'));
    }
}
