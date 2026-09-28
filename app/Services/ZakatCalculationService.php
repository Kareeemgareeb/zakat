<?php

namespace App\Services;

class ZakatCalculationService
{
    /**
     * Calculate Zakat for Gold, Silver, and Cash.
     * Nisab for Gold is 85 grams of 24K pure gold.
     * Zakat rate is 2.5% (1/40).
     */
    public function calculateWealth(float $amount, float $goldPricePerGram): array
    {
        $nisabValue = 85 * $goldPricePerGram;
        $isEligible = $amount >= $nisabValue;
        $zakatDue = $isEligible ? ($amount * 0.025) : 0;

        return [
            'is_eligible' => $isEligible,
            'nisab_threshold' => $nisabValue,
            'amount_evaluated' => $amount,
            'zakat_due' => round($zakatDue, 2),
            'currency' => 'دينار ليبي',
            'breakdown' => 'تم الحساب بنسبة 2.5% (ربع العشر)'
        ];
    }

    /**
     * Calculate Zakat for Agricultural Crops.
     * Nisab is 5 Wasqs (Approximately 653 kg).
     * Naturally watered (rain) = 10%
     * Artificially irrigated (machines) = 5%
     */
    public function calculateCrops(float $kilograms, bool $isIrrigated): array
    {
        $nisabKg = 653.0;
        $isEligible = $kilograms >= $nisabKg;
        
        $rate = $isIrrigated ? 0.05 : 0.10;
        $zakatDue = $isEligible ? ($kilograms * $rate) : 0;

        return [
            'is_eligible' => $isEligible,
            'nisab_threshold' => $nisabKg,
            'amount_evaluated' => $kilograms,
            'zakat_due' => round($zakatDue, 2),
            'unit' => 'كجم',
            'breakdown' => $isIrrigated ? '5% (سقي بالآلات - نصف العشر)' : '10% (سقي بماء السماء - العشر)'
        ];
    }

    /**
     * Calculate Zakat for Livestock (An'am) - Example: Sheep.
     * Nisab starts at 40 sheep.
     */
    public function calculateLivestock(string $animalType, int $count): array
    {
        if (strtolower($animalType) === 'sheep') {
            $zakatDue = 0;
            if ($count >= 40 && $count <= 120) $zakatDue = 1;
            elseif ($count >= 121 && $count <= 200) $zakatDue = 2;
            elseif ($count >= 201 && $count <= 300) $zakatDue = 3;
            elseif ($count > 300) {
                $zakatDue = floor($count / 100);
            }

            return [
                'is_eligible' => $count >= 40,
                'nisab_threshold' => 40,
                'amount_evaluated' => $count,
                'zakat_due' => $zakatDue,
                'unit' => 'شاة',
                'breakdown' => 'تم الحساب حسب أنصبة الغنم الشرعية'
            ];
        }

        return [
            'error' => 'Animal type not currently supported in this snippet.'
        ];
    }
}