<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ShipmentStatusLog;

class ShipmentController extends Controller
{
    // Show shipment request form
    public function create()
    {
        return view('shipments.create');
    }

    // Store a new shipment request
    public function store(Request $request)
    {
        $request->validate([
            'service_type' => 'required|string',
            'packages' => 'required|array|min:1',
            'packages.*.weight' => 'required|numeric|min:0.1',
            'packages.*.length' => 'required|numeric|min:0.1',
            'packages.*.width' => 'required|numeric|min:0.1',
            'packages.*.height' => 'required|numeric|min:0.1',
        ]);

        $totalWeight = collect($request->packages)->sum('weight');
        $shipment = Shipment::create([
            'user_id' => Auth::id(),
            'tracking_number' => strtoupper(Str::random(10)),
            'status' => 'Pending',
            'service_type' => $request->service_type,
            'total_weight' => $totalWeight,
            'price' => 0, // To be calculated/approved by admin
            'approved' => false,
        ]);

        foreach ($request->packages as $pkg) {
            Package::create([
                'shipment_id' => $shipment->id,
                'barcode' => strtoupper(Str::random(12)),
                'weight' => $pkg['weight'],
                'length' => $pkg['length'],
                'width' => $pkg['width'],
                'height' => $pkg['height'],
                'status' => 'Pending',
            ]);
        }

        return redirect()->route('dashboard')->with('status', 'Shipment request submitted!');
    }

    // Admin: List all pending shipment requests
    public function pending()
    {
        $shipments = Shipment::where('approved', false)->get();
        return view('admin.shipments.pending', compact('shipments'));
    }

    // Admin: View details of a pending shipment
    public function show($id)
    {
        $shipment = Shipment::with('user', 'packages')->findOrFail($id);
        return view('admin.shipments.show', compact('shipment'));
    }

    // Admin: Approve a shipment request
    public function approve(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->approved = true;
        $shipment->status = 'In Transit';
        $shipment->price = $request->input('price');
        $shipment->eta = $request->input('eta');
        $shipment->save();
        // Log status change
        ShipmentStatusLog::create([
            'shipment_id' => $shipment->id,
            'status' => 'In Transit',
            'changed_at' => now(),
            'updated_by' => auth('admin')->id() ?? auth()->id(),
            'note' => 'Shipment approved',
        ]);
        return redirect()->route('admin.shipments.pending')->with('status', 'Shipment approved!');
    }

    // Admin: Reject a shipment request
    public function reject($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete();
        return redirect()->route('admin.shipments.pending')->with('status', 'Shipment rejected and deleted.');
    }

    // User: View shipment history
    public function history()
    {
        $shipments = Shipment::with('packages')->where('user_id', auth()->id())->orderByDesc('created_at')->get();
        return view('shipments.history', compact('shipments'));
    }

    // User: View details of a specific shipment
    public function userShow($id)
    {
        $shipment = Shipment::with('packages')->where('user_id', auth()->id())->findOrFail($id);
        return view('shipments.show', compact('shipment'));
    }

    // Admin: Show create shipment form
    public function adminCreate()
    {
        return view('admin.shipments.create');
    }

    // Admin: Store new shipment
    public function adminStore(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'service_type' => 'required|string',
            'total_weight' => 'required|numeric|min:0.1',
            'price' => 'required|numeric|min:0',
            'eta' => 'nullable|date',
        ]);
        $shipment = \App\Models\Shipment::create([
            'user_id' => $request->user_id ?: null,
            'tracking_number' => strtoupper(Str::random(10)),
            'status' => 'Pending',
            'service_type' => $request->service_type,
            'total_weight' => $request->total_weight,
            'price' => $request->price,
            'eta' => $request->eta,
            'approved' => true,
            // New fields
            'sender_name' => $request->sender_name ?? null,
            'sender_phone' => $request->sender_phone ?? null,
            'sender_email' => $request->sender_email ?? null,
            'sender_country' => $request->sender_country ?? null,
            'sender_street' => $request->sender_street ?? null,
            'sender_city' => $request->sender_city ?? null,
            'sender_state' => $request->sender_state ?? null,
            'sender_postal_code' => $request->sender_postal_code ?? null,
            'receiver_name' => $request->receiver_name ?? null,
            'receiver_phone' => $request->receiver_phone ?? null,
            'receiver_email' => $request->receiver_email ?? null,
            'receiver_country' => $request->receiver_country ?? null,
            'receiver_street' => $request->receiver_street ?? null,
            'receiver_city' => $request->receiver_city ?? null,
            'receiver_state' => $request->receiver_state ?? null,
            'receiver_postal_code' => $request->receiver_postal_code ?? null,
            'shipment_type' => $request->shipment_type ?? null,
            'document_category' => $request->document_category ?? null,
            'length' => $request->length ?? null,
            'width' => $request->width ?? null,
            'height' => $request->height ?? null,
            'contents_description' => $request->contents_description ?? null,
            'declared_value' => $request->declared_value ?? null,
            'commodity_code' => $request->commodity_code ?? null,
            'insurance_enabled' => $request->has('insurance_enabled'),
            'insurance_value' => $request->insurance_value ?? null,
            'insurance_cost' => $request->insurance_cost ?? null,
        ]);
        // Optionally handle packages creation here
        return redirect()->route('admin.shipments.all')->with('status', 'Shipment created successfully.');
    }

    // Admin: Show edit shipment form
    public function adminEdit($id)
    {
        $shipment = \App\Models\Shipment::with('packages')->findOrFail($id);
        return view('admin.shipments.edit', compact('shipment'));
    }

    // Admin: Update shipment
    public function adminUpdate(Request $request, $id)
    {
        $shipment = \App\Models\Shipment::findOrFail($id);
        $request->validate([
            'service_type' => 'required|string',
            'total_weight' => 'required|numeric|min:0.1',
            'price' => 'required|numeric|min:0',
            'eta' => 'nullable|date',
            'status' => 'required|string',
        ]);
        $oldStatus = $shipment->status;
        $shipment->update([
            'service_type' => $request->service_type,
            'total_weight' => $request->total_weight,
            'price' => $request->price,
            'eta' => $request->eta,
            'status' => $request->status,
            // New fields
            'sender_name' => $request->sender_name ?? null,
            'sender_phone' => $request->sender_phone ?? null,
            'sender_email' => $request->sender_email ?? null,
            'sender_country' => $request->sender_country ?? null,
            'sender_street' => $request->sender_street ?? null,
            'sender_city' => $request->sender_city ?? null,
            'sender_state' => $request->sender_state ?? null,
            'sender_postal_code' => $request->sender_postal_code ?? null,
            'receiver_name' => $request->receiver_name ?? null,
            'receiver_phone' => $request->receiver_phone ?? null,
            'receiver_email' => $request->receiver_email ?? null,
            'receiver_country' => $request->receiver_country ?? null,
            'receiver_street' => $request->receiver_street ?? null,
            'receiver_city' => $request->receiver_city ?? null,
            'receiver_state' => $request->receiver_state ?? null,
            'receiver_postal_code' => $request->receiver_postal_code ?? null,
            'shipment_type' => $request->shipment_type ?? null,
            'document_category' => $request->document_category ?? null,
            'length' => $request->length ?? null,
            'width' => $request->width ?? null,
            'height' => $request->height ?? null,
            'contents_description' => $request->contents_description ?? null,
            'declared_value' => $request->declared_value ?? null,
            'commodity_code' => $request->commodity_code ?? null,
            'insurance_enabled' => $request->has('insurance_enabled'),
            'insurance_value' => $request->insurance_value ?? null,
            'insurance_cost' => $request->insurance_cost ?? null,
        ]);
        if ($oldStatus !== $request->status) {
            ShipmentStatusLog::create([
                'shipment_id' => $shipment->id,
                'status' => $request->status,
                'changed_at' => now(),
                'updated_by' => auth('admin')->id() ?? auth()->id(),
                'note' => 'Status updated via admin',
            ]);
        }
        return redirect()->route('admin.shipments.all')->with('status', 'Shipment updated successfully.');
    }

    // Admin: Show form to update package status
    public function packageStatusForm($packageId)
    {
        $package = \App\Models\Package::with('shipment')->findOrFail($packageId);
        $statuses = ['Pending', 'In Transit', 'On Hold', 'Dispatched for Delivery', 'Delivered'];
        return view('admin.packages.status', compact('package', 'statuses'));
    }

    // Admin: Update package status and log it
    public function updatePackageStatus(\Illuminate\Http\Request $request, $packageId)
    {
        $request->validate([
            'status' => 'required|string',
            'note' => 'nullable|string',
        ]);
        $package = \App\Models\Package::findOrFail($packageId);
        $package->status = $request->status;
        $package->save();
        \App\Models\PackageStatusLog::create([
            'package_id' => $package->id,
            'status' => $request->status,
            'updated_by' => auth('admin')->id(),
            'note' => $request->note,
        ]);
        return redirect()->back()->with('status', 'Package status updated!');
    }

    // Admin: View package status log
    public function packageStatusLog($packageId)
    {
        $package = \App\Models\Package::with('shipment')->findOrFail($packageId);
        $logs = \App\Models\PackageStatusLog::where('package_id', $packageId)->orderByDesc('changed_at')->get();
        return view('admin.packages.status_log', compact('package', 'logs'));
    }

    // Admin: Show form to update shipment ETA
    public function shipmentEtaForm($shipmentId)
    {
        $shipment = \App\Models\Shipment::findOrFail($shipmentId);
        return view('admin.shipments.eta', compact('shipment'));
    }

    // Admin: Update shipment ETA
    public function updateShipmentEta(\Illuminate\Http\Request $request, $shipmentId)
    {
        $request->validate(['eta' => 'required|date']);
        $shipment = \App\Models\Shipment::findOrFail($shipmentId);
        $shipment->eta = $request->eta;
        $shipment->save();
        return redirect()->back()->with('status', 'Shipment ETA updated!');
    }

    // Admin: Show form to update package ETA
    public function packageEtaForm($packageId)
    {
        $package = \App\Models\Package::with('shipment')->findOrFail($packageId);
        return view('admin.packages.eta', compact('package'));
    }

    // Admin: Update package ETA
    public function updatePackageEta(\Illuminate\Http\Request $request, $packageId)
    {
        $request->validate(['eta' => 'required|date']);
        $package = \App\Models\Package::findOrFail($packageId);
        $package->eta = $request->eta;
        $package->save();
        return redirect()->back()->with('status', 'Package ETA updated!');
    }

    // Admin: List all shipments
    public function adminAll()
    {
        $shipments = \App\Models\Shipment::with('user')->orderByDesc('created_at')->paginate(20);
        return view('admin.shipments.all', compact('shipments'));
    }

    // Allowed statuses and transitions
    private $statusWorkflow = [
        'pending' => ['processing', 'cancelled', 'on_hold'],
        'processing' => ['shipped', 'cancelled', 'on_hold'],
        'shipped' => ['in_transit', 'returned', 'on_hold'],
        'in_transit' => ['delivered', 'returned', 'on_hold'],
        'on_hold' => ['processing', 'shipped', 'in_transit', 'cancelled'],
        'delivered' => [],
        'cancelled' => [],
        'returned' => [],
    ];

    public function getValidNextStatuses($currentStatus)
    {
        $currentStatus = strtolower($currentStatus);
        return $this->statusWorkflow[$currentStatus] ?? [];
    }

    // Update shipment status (called from status update form)
    public function updateShipmentStatus(Request $request, $shipmentId)
    {
        $shipment = \App\Models\Shipment::findOrFail($shipmentId);
        $nextStatus = $request->input('status');
        $shipment->status = $nextStatus;
        $shipment->save();
        // Log status change
        ShipmentStatusLog::create([
            'shipment_id' => $shipment->id,
            'status' => $nextStatus,
            'changed_at' => now(),
            'updated_by' => auth('admin')->id() ?? auth()->id(),
            'note' => 'Status updated via admin',
        ]);
        return redirect()->back()->with('status', 'Shipment status updated successfully!');
    }
} 