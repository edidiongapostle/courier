<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class RateCalculatorController extends Controller
{
    public function show(): View
    {
        return view('rate.form');
    }

    public function calculate(Request $request): View
    {
        $request->validate([
            'origin_country' => 'required|string',
            'origin_province' => 'required|string',
            'dest_country' => 'required|string',
            'dest_province' => 'required|string',
            'goods_type' => 'required|string',
            'goods_name' => 'required|array|min:1',
            'goods_name.*' => 'required|string',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
            'weight' => 'required|array|min:1',
            'weight.*' => 'required|numeric|min:0.01',
            'length' => 'required|array|min:1',
            'length.*' => 'required|numeric|min:0.01',
            'width' => 'required|array|min:1',
            'width.*' => 'required|numeric|min:0.01',
            'height' => 'required|array|min:1',
            'height.*' => 'required|numeric|min:0.01',
            'service_type' => 'required|string',
        ]);

        // Calculate total weight
        $totalWeight = 0;
        foreach ($request->weight as $i => $w) {
            $qty = isset($request->quantity[$i]) ? (int)$request->quantity[$i] : 1;
            $totalWeight += ((float)$w) * $qty;
        }

        // Dummy base rate logic (customize as needed)
        $baseRate = match($request->service_type) {
            'Express' => 200,
            'Overnight' => 300,
            'Priority Overnight' => 350,
            'International Priority' => 500,
            default => 100,
        };
        $price = $baseRate + ($totalWeight * 50);
        $etaHours = match($request->service_type) {
            'Express' => 24,
            'Overnight' => 12,
            'Priority Overnight' => 8,
            'International Priority' => 48,
            default => 72,
        };
        $eta = now()->addHours($etaHours)->toDateTimeString();

        return view('rate.form', [
            'result' => [
                'price' => $price,
                'eta' => $eta,
                'origin' => $request->origin_country . ', ' . $request->origin_province . ($request->origin_address ? (', ' . $request->origin_address) : ''),
                'destination' => $request->dest_country . ', ' . $request->dest_province . ($request->dest_address ? (', ' . $request->dest_address) : ''),
                'weight' => $totalWeight,
                'service_type' => $request->service_type,
                'goods_type' => $request->goods_type,
                'parcels' => collect($request->goods_name)->map(function($name, $i) use ($request) {
                    return [
                        'goods_name' => $name,
                        'quantity' => $request->quantity[$i],
                        'weight' => $request->weight[$i],
                        'length' => $request->length[$i],
                        'width' => $request->width[$i],
                        'height' => $request->height[$i],
                    ];
                }),
            ]
        ]);
    }
} 