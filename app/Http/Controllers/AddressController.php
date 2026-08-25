<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display all addresses for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->ordered()->paginate(10);

        return view('addresses.index', compact('addresses'));
    }

    /**
     * Show form to create a new address
     */
    public function create()
    {
        return view('addresses.create');
    }

    /**
     * Store a new address
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'special_instructions' => 'nullable|string|max:1000',
            'type' => 'required|in:pickup,dropoff,both',
            'is_primary' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();

        $address = Address::create($validated);

        // If marking as primary, unset other primary addresses
        if ($request->boolean('is_primary')) {
            $address->markAsPrimary();
        }

        return redirect()->route('addresses.index')
            ->with('success', 'Address saved successfully!');
    }

    /**
     * Show address details
     */
    public function show(Address $address)
    {
        $this->authorize('view', $address);

        return view('addresses.show', compact('address'));
    }

    /**
     * Show form to edit an address
     */
    public function edit(Address $address)
    {
        $this->authorize('update', $address);

        return view('addresses.edit', compact('address'));
    }

    /**
     * Update an address
     */
    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'special_instructions' => 'nullable|string|max:1000',
            'type' => 'required|in:pickup,dropoff,both',
            'is_primary' => 'boolean',
        ]);

        $address->update($validated);

        // If marking as primary, unset other primary addresses
        if ($request->boolean('is_primary') && !$address->is_primary) {
            $address->markAsPrimary();
        }

        return redirect()->route('addresses.index')
            ->with('success', 'Address updated successfully!');
    }

    /**
     * Delete an address
     */
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        $address->delete();

        return redirect()->route('addresses.index')
            ->with('success', 'Address deleted successfully!');
    }

    /**
     * Mark an address as primary
     */
    public function markAsPrimary(Address $address)
    {
        $this->authorize('update', $address);

        $address->markAsPrimary();

        return redirect()->route('addresses.index')
            ->with('success', 'Address marked as primary!');
    }

    /**
     * Get addresses for a specific type via API
     */
    public function getByType(Request $request)
    {
        $type = $request->query('type', 'both');
        $userId = Auth::id();

        $addresses = Address::forUser($userId)
            ->when($type !== 'both', function ($query) use ($type) {
                return $query->whereIn('type', [$type, 'both']);
            })
            ->ordered()
            ->get();

        return response()->json($addresses);
    }
}
