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
    {$validated = $request->validate([
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

        $survey = Survey::where('user_id', auth()->id())->first();

        if ($survey) {
            $survey->update($validated);
        } else {
            $validated['user_id'] = auth()->id();
            Survey::create($validated);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Ankieta została zapisana.']);
        }

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

        DB::table('user_allergens')
            ->where('user_id', $user->id)
            ->whereNotIn('allergen', $allergens)
            ->delete();

        foreach ($allergens as $allergen) {
            DB::table('user_allergens')->updateOrInsert(
                ['user_id' => $user->id, 'allergen' => $allergen],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        return response()->json(['success' => true]);
    }

    public function getAllergens()
    {
        $user = Auth::user();
        $allergens = DB::table('user_allergens')
            ->where('user_id', $user->id)
            ->pluck('allergen');

        return response()->json([
            'allergens' => $allergens
        ]);
    }

    public function savePhysicalActivity(Request $request)
    {
        $validated = $request->validate([
            'activity_level' => 'required|string|in:sitting,low,light,moderate,high,very_high',
        ]);


        $user = Auth::user();
        $user->activity_level = $validated['activity_level'];
        $user->save();

    }

    public function saveSettings(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Musisz być zalogowany, aby zapisać ustawienia.'], 401);
        }

        $disableAds = $request->has('settings') && in_array('reklamy', $request->input('settings'));
        $disableEmails = $request->has('settings') && in_array('maile', $request->input('settings'));

        $user->disable_ads = $disableAds;
        $user->disable_emails = $disableEmails;
        $user->save();

    }

    public function saveTheme(Request $request)
    {

        $request->validate([
            'theme' => 'required|in:default,themeA,themeB,themeC',
        ]);


        $user = Auth::user();

        $user->theme = $request->input('theme');
        $user->save();


        return response()->json([
            'success' => true,
            'message' => 'Szablon został zapisany.'
        ]);
    }

    public function saveBackground(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('top_image')) {
            $path = $request->file('top_image')->store('public/backgrounds');
            $user->top_image = str_replace('public/', '/storage/public/', $path);
        }

        if ($request->hasFile('bottom_image')) {
            $path = $request->file('bottom_image')->store('public/backgrounds');
            $user->bottom_image = str_replace('public/', '/storage/public/', $path);
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Obrazy zostały zapisane.']);
    }

    public function detailsByEmail($email)
    {
        $member = family::where('email', $email)->firstOrFail();

        return view('members.details', compact('member'));
    }



}


