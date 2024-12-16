<?php



namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['allergens', 'survey']);

        if ($request->filled('gender')) {
            $query->whereHas('survey', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        if ($request->filled('activity_level')) {
            $query->where('activity_level', $request->activity_level);
        }

        if ($request->filled('allergen')) {
            $query->whereHas('allergens', function ($q) use ($request) {
                if ($request->allergen === 'wszystkie_rodzaje') {
                    $q->where('allergen', '!=', null);
                } else {
                    $q->where('allergen', $request->allergen);
                }
            });
        }

        $users = $query->paginate(10);

        return view('admin.users', compact('users'));
    }
}
