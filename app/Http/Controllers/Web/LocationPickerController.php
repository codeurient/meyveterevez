<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LocationPickerController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        if ($request->boolean('clear')) {
            session()->forget(['user_lat', 'user_lng']);
            return response()->json(['success' => true]);
        }

        $validated = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        session([
            'user_lat' => $validated['lat'],
            'user_lng' => $validated['lng'],
        ]);

        return response()->json(['success' => true]);
    }
}
