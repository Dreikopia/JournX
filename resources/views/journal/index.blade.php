<x-layout.app>
    <div>

        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Journal</h1>
            <p class="text-muted-foreground mt-2 text-sm">
                Start journaling your day
            </p>
            <x-card x-data @click="$dispatch('open-modal', 'create-journal')" as="button" type="button"
                class="mt-10 h-32 w-full cursor-pointer text-left text-4xl font-bold" data-test="create-journal">
                Create a journal
            </x-card>
        </header>

        <div>
            <a href='/journal' class="btn {{ request()->has('mood') ? 'btn-outlined' : '' }}">
                All
            </a>
            @foreach (App\JournalMood::cases() as $mood)
                <a href="/journal?mood={{ $mood->value }}"
                    class="btn {{ request('mood') === $mood->value ? '' : 'btn-outlined' }}">
                    {{ $mood->label() }}
                    <span class="pl-3 text-xs">
                        {{ $moodCounts->get($mood->value) }}
                    </span>
                </a>
            @endforeach
        </div>

        <div class="text-muted-foreground mt-10">
            <div class="mb-10 grid gap-6 md:grid-cols-3">
                @forelse ($journals as $journal)
                    <x-card href="{{ route('journal.show', $journal) }}">
                        @if ($journal->image_path)
                            <div class="mb-4 -mx-4 -mt-4 rounded-t-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $journal->image_path) }}" alt="{{ $journal->title }}"
                                    class="w-full h-48 object-cover">
                            </div>
                        @endif


                        <h1 class="text-foreground text-lg">{{ $journal->title }}</h1>

                        <div>
                            <x-mood-label mood="{{ $journal->mood }}">
                                {{ $journal->mood->label() }}
                            </x-mood-label>
                        </div>

                        <div class="mt-5 line-clamp-3">{{ $journal->description }}</div>

                        <div class="mt-4">{{ $journal->created_at->diffForHumans() }}</div>
                    </x-card>
                @empty
                    <x-card>
                        No Journals yet
                    </x-card>
                @endforelse
            </div>
        </div>

        {{-- Modal --}}
        <x-journal.modal />
    </div>
</x-layout.app>
