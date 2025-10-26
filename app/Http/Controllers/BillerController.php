<?php

namespace App\Http\Controllers;

use App\Actions\AddBillerAction;
use App\Models\Biller;
use App\Services\DropdownService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class BillerController extends Controller
{
    public function __construct(
        private readonly DropdownService $dropdownService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $billers = Biller::query()
            ->with(['category'])
            ->where('is_active', true)
            ->orderBy('name')
            ->paginate(10);

        return Inertia::render('billers/index', [
            'billers' => $billers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $biller = new Biller;
        $categories = $this->dropdownService->getCategories();

        return Inertia::render('billers/create', [
            'biller' => $biller,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, AddBillerAction $addBillerAction): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $biller = $addBillerAction->execute($data);

        return redirect()->route('billers.show', $biller)
            ->with('success', 'Biller created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Biller $biller): Response
    {
        abort_if(! $biller->is_active, 404);
        $categories = $this->dropdownService->getCategories();

        return Inertia::render('billers/show', [
            'biller' => $biller,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Biller $biller): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $biller->update($data);

        return redirect()->route('billers.show', $biller)
            ->with('success', 'Biller updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Biller $biller): RedirectResponse
    {
        abort_if($biller->user_id !== Auth::user()->id, 403);

        $biller->update(['is_active' => false]);

        $biller->delete();

        return redirect()->route('billers.index')
            ->with('success', 'Biller deleted successfully');
    }
}
