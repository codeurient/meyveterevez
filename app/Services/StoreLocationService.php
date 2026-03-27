<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Location;
use App\Models\StoreProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class StoreLocationService
{
    private const RADIUS_KM   = 50;
    private const STORE_LIMIT = 8;

    /**
     * Resolve which stores to show, with the following priority:
     *
     * 1. User placed a pin on the map → stores within 50 km (Haversine)
     * 2. User has a registered city   → stores in that city
     * 3. No stores in city            → stores from the same country + warning
     * 4. No stores in country         → globally popular stores
     */
    public function resolve(?User $user, ?float $lat, ?float $lng): array
    {
        // ── Priority 1: explicit geo pin ─────────────────────────────────
        if ($lat !== null && $lng !== null) {
            $stores = $this->byGeo($lat, $lng);
            if ($stores->isNotEmpty()) {
                return $this->result($stores, 'nearby', null);
            }
        }

        // ── Priority 2 & 3: registered user location ─────────────────────
        if ($user && $user->location_id) {
            $city = $user->location;

            if ($city) {
                // 2a. Stores in the exact city
                $stores = $this->byCity($city->id);
                if ($stores->isNotEmpty()) {
                    return $this->result($stores, 'nearby', null);
                }

                // 2b. Stores in the same country (city had no stores)
                $countryId = $this->countryIdFor($city);
                if ($countryId) {
                    $stores = $this->byCountry($countryId);
                    if ($stores->isNotEmpty()) {
                        return $this->result($stores, 'popular', 'no_stores_in_city');
                    }
                }
            }
        }

        // ── Priority 4: global popular stores ────────────────────────────
        $stores = StoreProfile::active()
            ->verified()
            ->with('location')
            ->orderByDesc('rating_avg')
            ->take(self::STORE_LIMIT)
            ->get();

        return $this->result($stores, 'popular', null);
    }

    // ── Private helpers ──────────────────────────────────────────────────

    /** Haversine query — stores whose location is within RADIUS_KM km. */
    private function byGeo(float $lat, float $lng): Collection
    {
        return StoreProfile::active()
            ->verified()
            ->with('location')
            ->join('locations', 'store_profiles.location_id', '=', 'locations.id')
            ->whereNotNull('locations.latitude')
            ->whereNotNull('locations.longitude')
            ->selectRaw(
                'store_profiles.*,
                 (6371 * ACOS(
                     COS(RADIANS(?)) * COS(RADIANS(locations.latitude))
                     * COS(RADIANS(locations.longitude) - RADIANS(?))
                     + SIN(RADIANS(?)) * SIN(RADIANS(locations.latitude))
                 )) AS distance',
                [$lat, $lng, $lat]
            )
            ->having('distance', '<=', self::RADIUS_KM)
            ->orderBy('distance')
            ->take(self::STORE_LIMIT)
            ->get();
    }

    /** Stores registered at the given city location. */
    private function byCity(int $cityId): Collection
    {
        return StoreProfile::active()
            ->verified()
            ->with('location')
            ->where('location_id', $cityId)
            ->orderByDesc('rating_avg')
            ->take(self::STORE_LIMIT)
            ->get();
    }

    /** Stores in any city belonging to the given country, plus country-level stores. */
    private function byCountry(int $countryId): Collection
    {
        $locationIds = Location::where('parent_id', $countryId)
            ->where('type', 'city')
            ->pluck('id')
            ->push($countryId); // include stores registered at country level

        return StoreProfile::active()
            ->verified()
            ->with('location')
            ->whereIn('location_id', $locationIds)
            ->orderByDesc('rating_avg')
            ->take(self::STORE_LIMIT)
            ->get();
    }

    /**
     * Traverse the location hierarchy upward to find the country id.
     * Handles: city → country (two levels).
     */
    private function countryIdFor(Location $location): ?int
    {
        if ($location->isCountry()) {
            return $location->id;
        }

        if ($location->parent_id) {
            $parent = Location::find($location->parent_id);
            if ($parent?->isCountry()) {
                return $parent->id;
            }
        }

        return null;
    }

    /**
     * Build the return array.
     *
     * @param  'nearby'|'popular'  $titleKey
     * @param  string|null         $warning   translation key suffix or null
     */
    private function result(Collection $stores, string $titleKey, ?string $warning): array
    {
        $headingMap = [
            'nearby'  => [
                'title' => 'heading.nearby_stores',
                'desc'  => 'heading.nearby_stores_desc',
            ],
            'popular' => [
                'title' => 'heading.popular_stores',
                'desc'  => 'heading.popular_stores_desc',
            ],
        ];

        return [
            'stores'  => $stores,
            'title'   => $headingMap[$titleKey]['title'],
            'desc'    => $headingMap[$titleKey]['desc'],
            'warning' => $warning ? "heading.{$warning}" : null,
        ];
    }
}
