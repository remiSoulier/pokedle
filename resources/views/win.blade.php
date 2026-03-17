@extends('layouts.app')

@section('title', 'Victoire')

@section('content')

    <div class="mx-auto max-w-2xl">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-10">

            <div class="text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-50 ring-1 ring-green-200">
                    <span class="text-2xl">🏆</span>
                </div>

                <h1 class="mt-4 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                    Félicitations, vous avez gagné en {{ $nbEssais }} essai{{ $nbEssais > 1 ? 's' : '' }} !
                </h1>

                <p class="mt-2 text-base text-gray-600">
                    Le Pokémon mystère était <span class="font-semibold text-gray-900">{{ $pokemon->name }}</span>.
                </p>
            </div>

            <div class="mt-8 flex justify-center">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <img
                        src="{{ $pokemon->image_url }}"
                        alt="{{ $pokemon->name }}"
                        class="h-56 w-56 rounded-xl object-cover shadow-sm"
                    >
                </div>
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                <form action="/reset" method="post">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-gray-800 active:bg-black sm:w-auto"
                    >
                        Rejouer
                    </button>
                </form>

                <a
                    href="/"
                    class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50 sm:w-auto"
                >
                    Retour à l’accueil
                </a>
            </div>

        </div>
    </div>

@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const duration = 3000;
            const end = Date.now() + duration;

            (function frame() {
                confetti({
                    particleCount: 5,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0 }
                });

                confetti({
                    particleCount: 5,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1 }
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        });
    </script>
@endpush
