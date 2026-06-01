<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $validated = $request->validated();

    $address = [
        'cep'        => preg_replace('/\D/', '', $validated['cep'] ?? ''),
        'street'     => $validated['street'] ?? null,
        'number'     => $validated['number'] ?? null,
        'complement' => $validated['complement'] ?? null,
        'city'       => $validated['city'] ?? null,
        'state'      => strtoupper($validated['state'] ?? ''),
    ];

    $user = $request->user();
    $user->fill([
        'name'         => $validated['name'],
        'trading_name' => $validated['trading_name'] ?? null,
        'contact_name' => $validated['contact_name'],
        'phone'        => $validated['phone'],
        'document'     => $validated['document'],
    ]);

    $user->address = $address;
    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
