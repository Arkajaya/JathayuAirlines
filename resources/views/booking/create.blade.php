@extends('layouts.app')

@section('title', 'Pesan Tiket')

@section('content')
<div class="container mx-auto py-8 max-w-4xl px-4">
    <h1 class="text-2xl font-semibold mb-6">Pesan Tiket - {{ $service->departure_city }} → {{ $service->arrival_city }}</h1>

    <div class="bg-white shadow-sm rounded p-6">
        <div class="mb-4">
            <div class="text-sm text-gray-600">Kode Penerbangan</div>
            <div class="text-lg font-medium">{{ $service->flight_number }}</div>
        </div>

        <div class="mb-4">
            <div class="text-sm text-gray-600">Keberangkatan</div>
            <div class="font-medium">{{ $service->departure_time->format('d M Y H:i') }} - {{ $service->departure_city }}</div>
        </div>

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <div class="lg:col-span-2">
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Maskapai / Layanan</label>
                        <div class="text-lg font-medium">{{ $service->airline_name ?? '-' }} — {{ $service->flight_number }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Kelas</label>
                        <div class="mt-1 text-sm">{{ $service->class ?? 'Economy' }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jumlah Penumpang</label>
                        <div class="mt-1 text-sm">1 penumpang per booking</div>
                        <input type="hidden" name="passenger_count" value="1">
                        @php
                            $available = $service->available_seats ?? 0;
                        @endphp

                        @if($available <= 0)
                            <div class="mt-2 text-red-600">Maaf, tidak ada kursi tersedia untuk penerbangan ini.</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="special_request" class="block text-sm font-medium text-gray-700">Catatan (opsional)</label>
                        <textarea id="special_request" name="special_request" rows="3" class="mt-1 block w-full border rounded p-2">{{ old('special_request') }}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('bookings.index') }}" class="text-sm text-gray-600 hover:underline">Kembali ke daftar</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded @if($available <= 0) opacity-50 cursor-not-allowed pointer-events-none @endif" @if($available <= 0) disabled @endif>Pesan & Lanjut Pembayaran</button>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="mb-4 text-center">
                        <!-- simple plane icon -->
                        <svg class="mx-auto" width="120" height="60" viewBox="0 0 120 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0" y="0" width="120" height="60" rx="8" fill="#F8FAFC" />
                            <path d="M10 30 L60 15 L80 30 L60 45 Z" fill="#E6E7F2" />
                        </svg>
                        <div class="text-sm text-gray-600 mt-2">Peta Kursi</div>
                    </div>

                    <div class="mb-3">
                        @php
                            $capacity = $service->capacity ?? 0;
                            $occupied = $occupiedSeats ?? [];
                            $perRow = 4; // 2 seats left, aisle, 2 seats right
                            $rows = (int) ceil($capacity / $perRow);
                            $requiresSeatSelection = ($capacity) > 0;
                        @endphp

                        <div class="seat-map bg-white w-64 p-3 rounded shadow-sm overflow-hidden transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg -mt-2">
                            @php
                                $letters = ['A','B','C','D'];
                            @endphp
                            @php
                                $leftCount = (int) floor($perRow / 2);
                            @endphp
                            @for($r = 1; $r <= $rows; $r++)
                                <div class="flex items-center mb-2 justify-center">
                                    {{-- left seats --}}
                                    <div class="flex items-center gap-2">
                                    @for($c = 0; $c < $leftCount; $c++)
                                        @php
                                            $s = ($r - 1) * $perRow + $c + 1;
                                            if ($s > $capacity) break;
                                            $seatLabel = $r . ($letters[$c] ?? chr(65 + $c));
                                            $isOccupied = in_array($seatLabel, $occupied);
                                        @endphp
                                        <label class="flex items-center justify-center w-9 h-9 border rounded cursor-pointer select-none text-sm {{ $isOccupied ? 'bg-gray-200 cursor-not-allowed text-gray-500' : 'hover:bg-indigo-50' }} seat-label" data-seat="{{ $seatLabel }}">
                                            <input type="checkbox" name="seats[]" value="{{ $seatLabel }}" class="sr-only seat-checkbox" {{ $isOccupied ? 'disabled' : '' }}>
                                            <span class="w-full text-center text-xs">{{ $seatLabel }}</span>
                                        </label>
                                    @endfor
                                    </div>

                                    {{-- aisle --}}
                                    <div class="w-3 mx-2" aria-hidden="true"></div>

                                    {{-- right seats --}}
                                    <div class="flex items-center gap-2">
                                    @for($c = $leftCount; $c < $perRow; $c++)
                                        @php
                                            $s = ($r - 1) * $perRow + $c + 1;
                                            if ($s > $capacity) break;
                                            $seatLabel = $r . ($letters[$c] ?? chr(65 + $c));
                                            $isOccupied = in_array($seatLabel, $occupied);
                                        @endphp
                                        <label class="flex items-center justify-center w-9 h-9 border rounded cursor-pointer select-none text-sm {{ $isOccupied ? 'bg-gray-200 cursor-not-allowed text-gray-500' : 'hover:bg-indigo-50' }} seat-label" data-seat="{{ $seatLabel }}">
                                            <input type="checkbox" name="seats[]" value="{{ $seatLabel }}" class="sr-only seat-checkbox" {{ $isOccupied ? 'disabled' : '' }}>
                                            <span class="w-full text-center text-xs">{{ $seatLabel }}</span>
                                        </label>
                                    @endfor
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Kursi kosong berwarna putih, kursi terisi berwarna abu-abu. Arahkan kursor untuk melihat seluruh peta kursi.</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    function selectedCount(){
        return document.querySelectorAll('.seat-checkbox:checked').length;
    }

    function allowed(){
        // single passenger booking
        const hidden = document.querySelector('input[name="passenger_count"]');
        return hidden ? parseInt(hidden.value, 10) : 1;
    }

    function updateSeatLabels(){
        document.querySelectorAll('.seat-label').forEach(function(label){
            const cb = label.querySelector('.seat-checkbox');
            if(cb.disabled) return;
            if(cb.checked){
                label.classList.add('bg-indigo-600','text-white');
            } else {
                label.classList.remove('bg-indigo-600','text-white');
            }
        });
        // toggle submit allow when seats are required
        const submit = document.querySelector('button[type="submit"]');
        const requires = {{ $requiresSeatSelection ? 'true' : 'false' }};
        if(submit){
            if(requires){
                submit.disabled = selectedCount() < allowed();
                if(submit.disabled){
                    submit.classList.add('opacity-50','cursor-not-allowed');
                } else {
                    submit.classList.remove('opacity-50','cursor-not-allowed');
                }
            }
        }
    }

    // passenger_count is fixed to 1 so no change listeners needed

    document.querySelectorAll('.seat-label').forEach(function(label){
        label.addEventListener('click', function(e){
            const cb = label.querySelector('.seat-checkbox');
            if(cb.disabled) return;
            const max = allowed();
            if(!cb.checked && selectedCount() >= max){
                return;
            }
            cb.checked = !cb.checked;
            updateSeatLabels();
        });
    });

    // seat-map hover expand with staggered animation
    const seatMap = document.querySelector('.seat-map');
    if(seatMap){
        const seatLabels = Array.from(seatMap.querySelectorAll('.seat-label'));
        seatMap.addEventListener('mouseenter', function(){
            seatLabels.forEach(function(el, idx){
                el.style.transitionDelay = (idx * 0.03) + 's';
                el.classList.add('is-expanded');
            });
        });
        seatMap.addEventListener('mouseleave', function(){
            seatLabels.forEach(function(el){
                el.style.transitionDelay = '';
                el.classList.remove('is-expanded');
            });
        });
    }

});
</script>
@endpush

@endsection

@push('styles')
<style>
    /* seat map collapsed by default to keep page height reasonable */
    .seat-map{
        max-height:260px;
        overflow:hidden;
        transition: max-height .28s ease, box-shadow .2s ease, transform .18s ease;
    }

    /* on desktop hover, keep same height but enable vertical scrolling only (no layout shift) */
    @media(min-width:1024px){
        .seat-map:hover{
            max-height:260px; /* keep same height */
            overflow-y:auto;
            overflow-x:hidden;
            box-shadow: 0 18px 40px rgba(16,24,40,0.08);
        }

        /* show only vertical scrollbar styling */
        .seat-map::-webkit-scrollbar { width: 8px; }
        .seat-map::-webkit-scrollbar-track { background: transparent; }
        .seat-map::-webkit-scrollbar-thumb { background: rgba(55,116,181,0.28); border-radius: 6px; }
        .seat-map { scrollbar-gutter: stable both-edges; }
    }

    .seat-label{ width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center; transition: background .12s ease, transform .22s cubic-bezier(.2,.9,.3,1), box-shadow .22s ease; }
    .seat-label:hover{ transform: translateY(-4px); }
    .seat-label.is-expanded{ transform: translateY(-8px) scale(1.04); box-shadow: 0 8px 26px rgba(16,24,40,0.10); }
</style>
@endpush
