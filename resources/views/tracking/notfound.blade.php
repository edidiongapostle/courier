@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-6 rounded shadow text-center">
        <h1 class="text-2xl font-bold mb-4">Tracking Not Found</h1>
        <p class="mb-4">Sorry, we could not find a shipment or package with that tracking number or barcode.</p>
        <a href="/tracking" class="text-blue-600">Try Again</a>
    </div>
</div>
@endsection 