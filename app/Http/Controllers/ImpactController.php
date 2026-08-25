<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use App\Models\ImpactLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImpactController extends Controller
{
    /**
     * Create impact log after processing is confirmed.
     */
    public function createImpactLog(Offer $offer, array $data)
    {
        $listing = $offer->listing;
        $deviceCategory = $listing->category ?: ($listing->deviceType->name ?? 'unknown');

        // Get material breakdown from data
        $materials = $data['material_breakdown'] ?? [];
        $materialWeights = $this->processMaterialBreakdown($materials);

        // Calculate CO2 saved using the formula
        $carbonFootprint = $listing->carbon_footprint ?? $this->calculateCarbonFootprint($listing);
        $co2Saved = $carbonFootprint; // Full carbon footprint is saved by diverting from landfill

        // Calculate total materials recovered
        $totalMaterialsRecovered = array_sum($materialWeights);

        $impactLog = ImpactLog::create([
            'listing_id' => $listing->id,
            'seller_id' => $listing->user_id,
            'buyer_id' => $offer->buyer_id,
            'offer_id' => $offer->id,
            'device_category' => $deviceCategory,
            'device_weight' => $listing->estimated_weight,
            'processing_method' => $data['processing_method'],
            'co2_saved' => $co2Saved,
            'landfill_diverted_weight' => $listing->estimated_weight,
            'materials_recovered_weight' => $totalMaterialsRecovered,
            'gold_recovered' => $materialWeights['gold'] ?? 0,
            'copper_recovered' => $materialWeights['copper'] ?? 0,
            'plastic_recovered' => $materialWeights['plastic'] ?? 0,
            'aluminum_recovered' => $materialWeights['aluminum'] ?? 0,
            'rare_earth_recovered' => $materialWeights['rare_earth'] ?? 0,
            'status' => 'pending',
        ]);

        // Update seller's impact metrics
        $this->updateSellerImpact($listing->user_id, $impactLog);

        // Certify impact
        $impactLog->certify();
        $this->generateCertificate($impactLog);

        return $impactLog;
    }

    /**
     * Process material breakdown from form data.
     */
    private function processMaterialBreakdown(array $materials): array
    {
        $breakdown = [
            'gold' => 0,
            'copper' => 0,
            'plastic' => 0,
            'aluminum' => 0,
            'rare_earth' => 0,
        ];

        foreach ($materials as $material) {
            if (isset($material['type']) && isset($material['weight'])) {
                $type = strtolower($material['type']);
                if (array_key_exists($type, $breakdown)) {
                    $breakdown[$type] = (float) $material['weight'];
                }
            }
        }

        return $breakdown;
    }

    /**
     * Calculate carbon footprint for a listing.
     */
    private function calculateCarbonFootprint(Listing $listing): float
    {
        // Approximate CO2 emissions coefficient: 15 kg CO2 per kg of e-waste
        $coefficient = 15;
        return round($listing->estimated_weight * $coefficient, 2);
    }

    /**
     * Update seller's impact metrics.
     */
    private function updateSellerImpact(int $sellerId, ImpactLog $impactLog): void
    {
        $seller = User::find($sellerId);

        if ($seller) {
            $seller->increment('items_processed');
            $seller->increment('total_weight_diverted', $impactLog->device_weight);
            $seller->increment('total_co2_saved', $impactLog->co2_saved);

            // Calculate impact score (impact points per item + bonus metrics)
            $impactScore = ($impactLog->co2_saved * 0.1) + ($impactLog->materials_recovered_weight ?? 0);
            $seller->increment('total_impact_score', $impactScore);
        }
    }

    /**
     * Generate PDF Certificate.
     */
    public function generateCertificate(ImpactLog $impactLog): void
    {
        // TODO: Implement PDF generation using Laravel PDF library
        // For now, create a simple text certificate

        $certificateContent = $this->generateCertificateContent($impactLog);

        $certificatePath = 'certificates/' . $impactLog->certificate_token . '.html';
        Storage::put($certificatePath, $certificateContent);

        $impactLog->update(['certificate_path' => $certificatePath]);
    }

    /**
     * Generate certificate content.
     */
    private function generateCertificateContent(ImpactLog $impactLog): string
    {
        $seller = $impactLog->seller;
        $buyer = $impactLog->buyer;
        $escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
        $certificateToken = $escape($impactLog->certificate_token);
        $issuedDate = $escape($impactLog->certified_at?->format('Y-m-d'));
        $deviceCategory = $escape($impactLog->device_category);
        $processingMethod = $escape($impactLog->processing_method);
        $deviceWeight = $escape($impactLog->device_weight);
        $sellerName = $escape($seller?->name);
        $buyerName = $escape($buyer?->business_name ?: $buyer?->name);
        $co2Saved = $escape($impactLog->co2_saved);
        $landfillWeight = $escape($impactLog->landfill_diverted_weight);
        $materialsWeight = $escape($impactLog->materials_recovered_weight);
        $materialBreakdown = $this->renderMaterialBreakdown($impactLog);

        $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>E-Benta Certificate of Responsible Disposal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .certificate { border: 2px solid #27ae60; padding: 40px; max-width: 800px; margin: 20px auto; background: white; }
        .header { text-align: center; color: #1a7a4d; font-size: 24px; font-weight: bold; margin-bottom: 20px; }
        .subtitle { text-align: center; color: #5a6c7d; margin-bottom: 30px; }
        .content { line-height: 1.8; color: #333; }
        .section { margin-bottom: 20px; }
        .label { font-weight: 600; color: #1a7a4d; display: inline-block; width: 200px; }
        .value { color: #333; }
        .impact-metrics { background: #f0f8f5; padding: 20px; border-radius: 5px; margin-top: 20px; border-left: 4px solid #27ae60; }
        .metric { display: flex; justify-content: space-between; margin: 10px 0; align-items: center; }
        .metric .label { color: #1a7a4d; font-weight: 600; }
        .footer { text-align: center; margin-top: 40px; color: #7f8c8d; font-size: 12px; border-top: 1px solid #e0e0e0; padding-top: 20px; }
        .token { text-align: center; color: #95a5a6; font-size: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">E-BENTA</div>
        <div class="header" style="font-size: 18px; margin-bottom: 5px;">Certificate of Responsible E-Waste Disposal</div>
        <div class="subtitle">Circular Economy Initiative</div>

        <div class="content">
            <div class="section">
                <p><span class="label">Certificate ID:</span> <span class="value">{$certificateToken}</span></p>
                <p><span class="label">Issued Date:</span> <span class="value">{$issuedDate}</span></p>
            </div>

            <div class="section">
                <p><span class="label">Device Type:</span> <span class="value">{$deviceCategory}</span></p>
                <p><span class="label">Processing Method:</span> <span class="value">{$processingMethod}</span></p>
                <p><span class="label">Device Weight:</span> <span class="value">{$deviceWeight} kg</span></p>
            </div>

            <div class="section">
                <p><span class="label">Seller:</span> <span class="value">{$sellerName}</span></p>
                <p><span class="label">Processing Partner:</span> <span class="value">{$buyerName}</span></p>
            </div>

            <div class="impact-metrics">
                <h3 style="text-align: center; color: #1a7a4d; margin-top: 0;">Environmental Impact Summary</h3>
                <div class="metric">
                    <span class="label">CO₂ Diverted from Atmosphere:</span>
                    <span class="value">{$co2Saved} kg CO₂</span>
                </div>
                <div class="metric">
                    <span class="label">E-Waste Diverted from Landfill:</span>
                    <span class="value">{$landfillWeight} kg</span>
                </div>
                <div class="metric">
                    <span class="label">Materials Recovered:</span>
                    <span class="value">{$materialsWeight} kg</span>
                </div>

                <h4 style="margin-top: 15px; color: #1a7a4d;">Materials Breakdown:</h4>
                {$materialBreakdown}
            </div>

            <div class="footer">
                <p>This certificate verifies that the above electronic device has been responsibly processed according to international e-waste management standards.</p>
                <p>E-Benta - Circular Economy-Based Marketplace for Responsible Electronic Waste Management</p>
                <div class="token">Token: {$certificateToken}</div>
            </div>
        </div>
    </div>
</body>
</html>
HTML;

        return $html;
    }

    /**
     * Render material breakdown in HTML.
     */
    private function renderMaterialBreakdown(ImpactLog $impactLog): string
    {
        $materials = [];

        if ($impactLog->gold_recovered > 0) {
            $materials[] = "<div class='metric'><span>Gold:</span> <span>{$impactLog->gold_recovered} kg</span></div>";
        }
        if ($impactLog->copper_recovered > 0) {
            $materials[] = "<div class='metric'><span>Copper:</span> <span>{$impactLog->copper_recovered} kg</span></div>";
        }
        if ($impactLog->plastic_recovered > 0) {
            $materials[] = "<div class='metric'><span>Plastic:</span> <span>{$impactLog->plastic_recovered} kg</span></div>";
        }
        if ($impactLog->aluminum_recovered > 0) {
            $materials[] = "<div class='metric'><span>Aluminum:</span> <span>{$impactLog->aluminum_recovered} kg</span></div>";
        }
        if ($impactLog->rare_earth_recovered > 0) {
            $materials[] = "<div class='metric'><span>Rare Earth Elements:</span> <span>{$impactLog->rare_earth_recovered} kg</span></div>";
        }

        return implode('', $materials) ?: "<div class='metric'><span>No materials specified</span></div>";
    }

    /**
     * Show impact certificate.
     */
    public function showCertificate(ImpactLog $impactLog)
    {
        $user = Auth::user();
        if (!$user || ($user->id !== $impactLog->buyer_id && $user->id !== $impactLog->seller_id && !$user->isAdmin())) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        if (!$impactLog->isCertified()) {
            return redirect('/')->with('error', 'Certificate not found');
        }

        $content = Storage::get($impactLog->certificate_path);

        return response($content)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * Get admin dashboard analytics.
     */
    public function getAdminAnalytics()
    {
        $totalCo2Saved = ImpactLog::sum('co2_saved');
        $totalWasteDiverted = ImpactLog::sum('landfill_diverted_weight');
        $totalItemsProcessed = ImpactLog::count();
        $activeSellers = User::where('role', 'seller')->where('items_processed', '>', 0)->count();
        $activeBuyers = User::where('role', 'buyer')->where('is_verified', true)->count();

        // Monthly breakdown
        $monthlyData = ImpactLog::selectRaw('MONTH(created_at) as month, SUM(co2_saved) as co2, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        // Top materials recovered
        $materialsRecovered = [
            'gold' => ImpactLog::sum('gold_recovered'),
            'copper' => ImpactLog::sum('copper_recovered'),
            'plastic' => ImpactLog::sum('plastic_recovered'),
            'aluminum' => ImpactLog::sum('aluminum_recovered'),
            'rare_earth' => ImpactLog::sum('rare_earth_recovered'),
        ];

        return [
            'total_co2_saved' => $totalCo2Saved,
            'total_waste_diverted' => $totalWasteDiverted,
            'total_items_processed' => $totalItemsProcessed,
            'active_sellers' => $activeSellers,
            'active_buyers' => $activeBuyers,
            'monthly_data' => $monthlyData,
            'materials_recovered' => $materialsRecovered,
        ];
    }

    /**
     * Get seller's impact statistics.
     */
    public function getSellerImpact(User $seller)
    {
        $impactLogs = ImpactLog::where('seller_id', $seller->id)->get();

        return [
            'total_co2_saved' => $seller->total_co2_saved,
            'total_weight_diverted' => $seller->total_weight_diverted,
            'items_processed' => $seller->items_processed,
            'impact_score' => $seller->total_impact_score,
            'impact_logs' => $impactLogs,
        ];
    }
}
