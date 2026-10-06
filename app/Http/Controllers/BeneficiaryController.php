<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BeneficiaryController extends Controller
{
    /**
     * Show the beneficiary registration/application form.
     */
    public function create()
    {
        $user = Auth::user();

        // If user already has a beneficiary profile, redirect to dashboard
        if ($user->beneficiary) {
            return redirect()->route('dashboard');
        }

        return view('beneficiary.apply');
    }

    /**
     * Store new beneficiary application.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->beneficiary) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'gender' => ['required', 'in:MALE,FEMALE'],
            'birth_date' => ['required', 'string'],
            'marital_status' => ['required', 'in:SINGLE,MARRIED,WIDOWED,DIVORCED'],
            'family_members_count' => ['required', 'integer', 'min:1'],
            'city' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'bank_account_no' => ['nullable', 'string', 'max:34'],
        ]);

        // Auto-generate clean file number: ZAK-YEAR-USERID
        $fileNumber = 'SRT-' . date('Y') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);

        Beneficiary::create([
            'user_id' => $user->id,
            'file_number' => $fileNumber,
            'full_name' => $validated['full_name'],
            'gender' => $validated['gender'],
            'birth_date' => (function() use ($validated) {
                try {
                    return \Carbon\Carbon::createFromFormat('d/m/Y', $validated['birth_date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    return \Carbon\Carbon::parse($validated['birth_date'])->format('Y-m-d');
                }
            })(),
            'marital_status' => $validated['marital_status'],
            'family_members_count' => $validated['family_members_count'],
            'city' => $validated['city'],
            'address' => $validated['address'],
            'bank_name' => $validated['bank_name'] ?? null,
            'bank_account_no' => $validated['bank_account_no'] ?? null,
            'eligibility_status' => 'PENDING',
            'next_renewal_due' => Carbon::now()->addYear()->format('Y-m-d'),
        ]);

        return redirect()->route('dashboard')->with('status', 'تم تقديم طلب فتح الملف بنجاح! ملفك الآن قيد المراجعة والتدقيق.');
    }
}