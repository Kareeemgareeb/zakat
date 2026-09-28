<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileRenewalService;
use App\Models\FileRenewal;
use Illuminate\Support\Facades\Auth;

class FileRenewalController extends Controller
{
    protected $renewalService;

    public function __construct(FileRenewalService $renewalService)
    {
        $this->renewalService = $renewalService;
    }

    /**
     * Endpoint for Beneficiaries to submit their annual renewal.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'beneficiary_notes' => 'nullable|string|max:1000'
        ]);

        // Authenticated user must have a beneficiary profile
        $beneficiary = Auth::user()->beneficiary;
        
        if (!$beneficiary) {
            return response()->json(['error' => 'Access denied. You are not registered as a beneficiary.'], 403);
        }

        try {
            $renewal = $this->renewalService->submitRenewal($beneficiary, $request->beneficiary_notes);
            
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال طلب تجديد ملفك إلى الإدارة بنجاح.',
                'data' => $renewal
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Endpoint for Administrators to Approve or Reject a renewal.
     */
    public function review(Request $request, FileRenewal $renewal)
    {
        $request->validate([
            'status' => 'required|in:APPROVED,REJECTED'
        ]);

        // Assuming Route Middleware ensures only Admins reach this method
        $adminId = Auth::id(); 

        $updatedRenewal = $this->renewalService->reviewRenewal($renewal, $request->status, $adminId);

        return response()->json([
            'success' => true,
            'message' => 'The renewal status has been updated successfully.',
            'data' => $updatedRenewal
        ]);
    }
}
