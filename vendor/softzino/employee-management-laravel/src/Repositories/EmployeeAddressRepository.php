<?php

namespace Softzino\EmployeeManagement\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeAddressRepositoryInterface;

class EmployeeAddressRepository implements EmployeeAddressRepositoryInterface
{
    public function storeAddress(Model $addressable, string $type, ?array $address): void
    {
        if (! $address || empty(array_filter($address))) {
            return;
        }

        $addressable->addresses()->create([
            'type' => $type,
            'country' => $address['country'] ?? null,
            'city' => $address['city'] ?? null,
            'street' => $address['street'] ?? $address['streetAddress'] ?? null,
            'state' => $address['state'] ?? $address['stateOrProvince'] ?? null,
            'postal_code' => $address['postal_code'] ?? $address['postcode'] ?? null,
            'lat' => $address['lat'] ?? null,
            'lng' => $address['lng'] ?? null,
        ]);
    }

    public function updateAddress(Model $addressable, string $type, ?array $address): void
    {
        if (! $address || empty(array_filter($address))) {
            return;
        }

        $existingAddress = $addressable->addresses()->where('type', $type)->first();

        if ($existingAddress) {
            $existingAddress->update([
                'country' => $address['country'] ?? null,
                'city' => $address['city'] ?? null,
                'street' => $address['street'] ?? $address['streetAddress'] ?? null,
                'state' => $address['state'] ?? $address['stateOrProvince'] ?? null,
                'postal_code' => $address['postal_code'] ?? $address['postcode'] ?? null,
                'lat' => $address['lat'] ?? null,
                'lng' => $address['lng'] ?? null,
            ]);
        } else {
            $this->storeAddress($addressable, $type, $address);
        }
    }

    public function deleteAddress(Model $addressable, ?string $type = null): void
    {
        $query = $addressable->addresses();

        if ($type) {
            $query->where('type', $type);
        }

        $query->delete();
    }

    public function getAddress(Model $addressable, string $type): ?Model
    {
        return $addressable->addresses()->where('type', $type)->with('countryRelation')->first();
    }

    public function getAllAddresses(Model $addressable): Collection
    {
        return $addressable->addresses()->with('countryRelation')->get();
    }
}
