<?php

namespace App\Services;

use App\Models\FileRenewal;
use App\Models\Beneficiary;
use Carbon\Carbon;

class FileRenewalService
{
    /**
     * Beneficiary submits a new annual renewal request.
     */
    public function submitRenewal(Beneficiary $beneficiary, ?string $notes)
    {
        $currentYear = Carbon::now()->year;

        // Prevent submitting multiple pending requests for the same year
        $existing = $beneficiary->fileRenewals()
            ->where('renewal_year', $currentYear)
            ->where('status', 'PENDING')
            ->first();

        if ($existing) {
            throw new \Exception("A renewal request for this year is already pending.");
        }

        return $beneficiary->fileRenewals()->create([
            'renewal_year' => $currentYear,
            'submission_date' => Carbon::now(),
            'status' => 'PENDING',
            'beneficiary_notes' => $notes
        ]);
    }

    /**
     * Admin or Case Officer reviews the request.
     */
    public function reviewRenewal(FileRenewal $renewal, string $status, int $adminId)
    {
        $renewal->update([
            'status' => $status,
            'reviewed_by' => $adminId
        ]);

        // If approved, strictly update the Beneficiary's due date to exactly 1 year from now
        if ($status === 'APPROVED') {
            $renewal->beneficiary->update([
                'next_renewal_due' => Carbon::now()->addYear()->format('Y-m-d')
            ]);
        }

        return $renewal;
    }
}
