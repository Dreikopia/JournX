<x-layout.app>
    <div>

        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Journal</h1>
            <p class="text-muted-foreground text-sm mt-2">
                Start journaling your day
            </p>

            <x-card 
             x-data
             @click="$dispatch('open-modal', 'create-journal')"
             as="button"
             type="button"
             class="mt-10 cursor-pointer h-32 w-full text-4xl font-bold text-left">
                Create a journal
            </x-card>

        </header>
        <div>
            <a href='/journal' class="btn {{ request()->has('mood') ? 'btn-outlined' : ''}}">
            All
            </a>

            @foreach (App\JournalMood::cases() as $mood)
            <a href="/journal?mood={{ $mood->value }}"
               class="btn {{ request('mood') === $mood->value ? '' : 'btn-outlined' }}">
                {{ $mood->label() }} 
                <span class="text-xs pl-3">
                    {{ $moodCounts->get($mood->value) }}
                </span>
            </a>
        @endforeach
        </div>


        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-3 gap-6 mb-10">
            @forelse ( $journals as $journal )
                <x-card href="{{ route('journal.show', $journal) }}">
                    <h1 class="text-foreground text-lg">{{$journal->title}}</h1>
                    <div>
                        <x-mood-label mood="{{ $journal->mood }}">
                            {{ $journal->mood->label() }}
                        </x-mood-label>
                    </div>
                    <div class="mt-5 line-clamp-3">{{$journal->description}}</div>
                    <div class="mt-4">{{$journal->created_at->diffForHumans()}}</div>
                 </x-card>
            @empty
            <x-card>
                No Journals yet
            </x-card>
            @endforelse
        </div>
    </div>

    <x-modal name="create-journal" title="Create a new journal"/>
    

 </div>
</x-layout.app>