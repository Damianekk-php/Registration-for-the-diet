<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey;

class AccountController extends Controller
{
    public function showForm()
    {
        return view('account.edit');
    }

    public function update(Request $request)
    {

        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
        ]);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->postal_code = $request->postal_code;

        $user->save();

        return redirect()->route('account.edit')->with('success', 'Dane zostały zaktualizowane');
    }

    public function storeSurvey(Request $request)
    {
        $validated = $request->validate([
            'gender' => 'required|string',
            'height' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'age' => 'nullable|integer',
            'is_pregnant' => 'nullable|boolean',
            'pregnancy_week' => 'nullable|integer|required_if:is_pregnant,1',
            'pre_pregnancy_weight' => 'nullable|numeric|required_if:is_pregnant,1',
            'delivery_date' => 'nullable|date|required_if:is_pregnant,1',
            'waist_circumference' => 'nullable|numeric',
            'hip_circumference' => 'nullable|numeric',
            'bust_circumference' => 'nullable|numeric',
            'neck_circumference' => 'nullable|numeric',
            'wrist_circumference' => 'nullable|numeric',
            'bicep_circumference' => 'nullable|numeric',
            'thigh_circumference' => 'nullable|numeric',
            'calf_circumference' => 'nullable|numeric',
        ]);

        $validated['user_id'] = auth()->id();

        Survey::create($validated);

        return redirect()->route('account.edit')->with('success', 'Ankieta została zapisana.');
    }

}


