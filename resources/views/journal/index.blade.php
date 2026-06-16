<x-layout.app>
    <div>

        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Journal</h1>
            <p class="text-muted-foreground mt-2 text-sm">
                Start journaling your day
            </p>

            <x-card x-data @click="$dispatch('open-modal', 'create-journal')" 
            as="button" 
            type="button"
            class="mt-10 h-32 w-full cursor-pointer text-left text-4xl font-bold"
            data-test="create-journal">
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

        <x-modal name="create-journal" title="New Entry">
            <form x-data="{mood : 'neutral'}" method="POST" action="{{ route('journal.store') }}">
                @csrf

                <div>
                <x-form.field
                 name="title"
                 label="Title"
                 placeholder="Enter a title"
                 />

                    <div class="space-y-2 mb-4">
                        <label for="mood" class="label">Mood</label>
                        <div class="flex gap-x-3">
                            @foreach (App\JournalMood::cases() as $mood)
                                <button
                                type="button"
                                @click="mood = @js($mood->value)"
                                class="flex-1 h-10 btn"
                                :class="{'btn-outlined' : mood !== @js($mood->value)}"
                                data-test="button-mood-{{ $mood->value }}"
                                >
                                    {{ $mood->label() }}
                                </button>
                            @endforeach
                            <input type="hidden" name="mood" :value="mood">
                        </div>
                        <x-form.error name="mood"/>
                    </div>

                <x-form.field 
                 type="textarea"
                 name="description" 
                 label="Description"
                 placeholder="What happen to your day?"/>
                </div>

                <div class="flex justify-end gap-x-3">
                    <button type="button" class="btn btn-outlined" @click="$dispatch('close-modal')">Cancel</button>
                    <button type="submit" class="btn">Create</button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layout.app>