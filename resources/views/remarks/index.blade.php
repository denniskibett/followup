@extends('layouts.app')

@section('content')

<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">All Remarks</h1>

    <div class="bg-white shadow rounded p-4">
        @forelse($remarks as $remark)
            <div class="border p-3 rounded mb-3">
                <p>{{ $remark->remark }}</p>
                <small class="text-gray-500">Report #{{ $remark->report_id }}</small>
            </div>
        @empty
            <p class="text-gray-500">No remarks available.</p>
        @endforelse
    </div>
</div>
@endsection
