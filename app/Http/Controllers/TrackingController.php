<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Package;

class TrackingController extends Controller
{
    // Show tracking results for a shipment or package
    public function show(Request $request)
    {
        $tracking = $request->input('tracking');
        if (!$tracking) {
            return view('tracking.form');
        }
        $shipment = Shipment::with(['packages', 'user', 'statusLogs'])->where('tracking_number', $tracking)->first();
        $package = null;
        if (!$shipment) {
            $package = Package::where('barcode', $tracking)->first();
            if ($package) {
                $shipment = $package->shipment()->with(['packages', 'user', 'statusLogs'])->first();
            }
        }
        if (!$shipment) {
            return view('tracking.notfound');
        }
        return view('tracking.show', compact('shipment', 'package'));
    }

    // Generate QR code for a shipment
    public function qrShipment($tracking)
    {
        $renderer = new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(256),
            new \BaconQrCode\Renderer\Image\ImagickImageBackEnd()
        );
        $writer = new \BaconQrCode\Writer($renderer);
        $qr = $writer->writeString(url('/tracking?tracking=' . $tracking));
        return response($qr)->header('Content-Type', 'image/png');
    }

    // Generate QR code for a package
    public function qrPackage($barcode)
    {
        $renderer = new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(256),
            new \BaconQrCode\Renderer\Image\ImagickImageBackEnd()
        );
        $writer = new \BaconQrCode\Writer($renderer);
        $qr = $writer->writeString(url('/tracking?tracking=' . $barcode));
        return response($qr)->header('Content-Type', 'image/png');
    }
} 