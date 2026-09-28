<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ZakatCalculationService;
use App\Models\ZakatCalculation;
use Illuminate\Support\Facades\Auth;

class ZakatCalculatorController extends Controller
{
    protected $zakatService;

    public function __construct(ZakatCalculationService $zakatService)
    {
        $this->zakatService = $zakatService;
    }

    public function calculate(Request $request)
    {
        // 1. Validate the Request
        $validated = $request->validate([
            'calculation_type' => 'required|in:GOLD_SILVER,LIVESTOCK,CROPS_AGRICULTURE,CASH_WEALTH',
            'amount' => 'nullable|numeric|min:0',
            'kilograms' => 'nullable|numeric|min:0',
            'is_irrigated' => 'nullable|boolean',
            'animal_type' => 'nullable|string|in:sheep,camel,cow',
            'count' => 'nullable|integer|min:0',
            'gold_price_per_gram' => 'nullable|numeric|min:0'
        ]);

        $result = [];
        $type = $validated['calculation_type'];

        // 2. Call the ZakatCalculationService
        if ($type === 'CASH_WEALTH' || $type === 'GOLD_SILVER') {
            $goldPrice = $validated['gold_price_per_gram'] ?? 350.00; // Example fallback price in LYD
            $result = $this->zakatService->calculateWealth($validated['amount'] ?? 0, $goldPrice);
        } elseif ($type === 'CROPS_AGRICULTURE') {
            $result = $this->zakatService->calculateCrops($validated['kilograms'] ?? 0, $validated['is_irrigated'] ?? false);
        } elseif ($type === 'LIVESTOCK') {
            $result = $this->zakatService->calculateLivestock($validated['animal_type'] ?? 'sheep', $validated['count'] ?? 0);
        }

        // 3. Save the calculation to the database
        // donor_id will automatically be null if it's an anonymous/guest user
        $calculationRecord = ZakatCalculation::create([
            'donor_id' => Auth::id(), 
            'calculation_type' => $type,
            'input_parameters' => $validated,
            'computed_zakat_due' => $result['zakat_due'] ?? 0
        ]);

        // 4. Return standard JSON response for the Frontend
        return response()->json([
            'success' => true,
            'calculation_id' => $calculationRecord->id,
            'results' => $result
        ]);
    }
}
