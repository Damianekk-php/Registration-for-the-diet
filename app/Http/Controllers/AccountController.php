<?php

namespace App\Http\Controllers;

use App\Models\family;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();
        $family = family::where('user_id', $user->id)->get();
        return view('account.edit', compact('user', 'family'));
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

    public function inviteFamilyMember(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:family,email',
        ]);

        family::create([
            'user_id' => Auth::id(),
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'status' => 'Nieaktywny',
        ]);

        return redirect()->route('account.edit')->with('success', 'Zaproszenie zostało wysłane.');
    }

    public function destroyFamilyMember($id)
    {
        $familyMember = Family::findOrFail($id);

        if ($familyMember->user_id !== Auth::id()) {
            abort(403, 'Nie masz uprawnień do usunięcia tego członka rodziny.');
        }

        $familyMember->delete();

        return redirect()->route('account.edit')->with('success', 'Członek rodziny został usunięty.');
    }

    public function saveAllergens(Request $request)
    {
        $user = Auth::user();
        $allergens = $request->input('allergens', []);

        foreach ($allergens as $allergen) {
            DB::table('user_allergens')->updateOrInsert(
                ['user_id' => $user->id, 'allergen' => $allergen],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        return redirect()->back()->with('success', 'Alergeny zostały zapisane.');
    }

    public function savePhysicalActivity(Request $request)
    {
        $validated = $request->validate([
            'activity_level' => 'required|in:sitting,low,light,moderate,high,very_high',
        ]);

        $user = Auth::user();
        $user->activity_level = $request->input('activity_level');
        $user->save();

        return redirect()->back()->with('success', 'Poziom aktywności fizycznej został zapisany.');
    }

    public function saveSettings(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'Musisz być zalogowany, aby zapisać ustawienia.');
        }

        $user->disable_ads = $request->has('settings') && in_array('reklamy', $request->input('settings'));
        $user->disable_emails = $request->has('settings') && in_array('maile', $request->input('settings'));
        $user->save();

        return redirect()->back()->with('success', 'Ustawienia zostały zapisane.');
    }

    public function saveTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:default,themeA,themeB,themeC',
        ]);

        $user = Auth::user();
        $user->theme = $request->input('theme');
        $user->save();

        return redirect()->back()->with('success', 'Szablon został zapisany.');
    }



}


