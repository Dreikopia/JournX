<x-layout.app>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between items-center">
        <a href="{{ route('journal.index') }}" class="flex pb-2 items-center gap-x-2 text-sm font-medium">
            <x-icons.arrow-back/>
            Back to the journals
        </a>

        <div class="gap-x-3 flex items-center">
            <button class="btn btn-outlined">
                <x-icons.external/>
                Edit
            </button>

         <form method="POST" action="/journal/{{ $journal->id }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-outlined text-red-500">
                Delete
            </button>
          </form>
        </div>
    </div>
    
    <div class="mt-8 space-y-6">
        <h1 class="font-bold text-4xl">
            {{ $journal->title }}
        </h1>
        
        <div class="mt-2 flex gap-x-3 items-center">
            <x-mood-label :mood="$journal->mood->value">
                {{ $journal->mood->label() }}
            </x-mood-label>

        <div class="mt-2 text-muted-foreground text-sm">
            {{ $journal->created_at->diffForHumans() }}
        </div>
        </div>

        <x-card class="max-w-250">
            <div class="text-foreground max-w-none cursor-pointer">{{$journal->description}}</div>
        </x-card>

        @if ($journal->links->count())
            <div>
                <h3 class="font-bold text-lg">Links</h3>
                <div class="mt-3 space-y-2">
                    @foreach ($journal->links as $link )
                        <x-card :href="$link"
                         class="text-primary hover:underline font-medium flex gap-x-3 items-center">
                         <x-icons.external/>
                        {{ $link }}
                        </x-card>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
</x-layout.app>