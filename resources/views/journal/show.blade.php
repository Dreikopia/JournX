<x-layout.app>
    <div class="mx-auto max-w-4xl py-8">
        <div class="flex items-center justify-between">
            <a href="{{ route("journal.index") }}" class="flex items-center gap-x-2 pb-2 text-sm font-medium">
                <x-icons.arrow-back />
                Back to the journals
            </a>

            <div class="flex items-center gap-x-3">
                <button class="btn btn-outlined">
                    <x-icons.external />
                    Edit
                </button>

                <form method="POST" action="/journal/{{ $journal->id }}">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-outlined text-red-500">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-8 space-y-6">
            <h1 class="text-4xl font-bold">
                {{ $journal->title }}
            </h1>

            <div class="mt-2 flex items-center gap-x-3">
                <x-mood-label :mood="$journal->mood->value">
                    {{ $journal->mood->label() }}
                </x-mood-label>

                <div class="text-muted-foreground mt-2 text-sm">
                    {{ $journal->created_at->diffForHumans() }}
                </div>
            </div>

            <x-card class="max-w-250">
                <div class="text-foreground max-w-none cursor-pointer">{{ $journal->description }}</div>
            </x-card>

            @if ($journal->links && $journal->links->count())
                <div>
                    <h3 class="text-lg font-bold">Links</h3>
                    <div class="mt-3 space-y-2">
                        @foreach ($journal->links as $link)
                            <x-card :href="$link"
                                class="text-primary flex items-center gap-x-3 font-medium hover:underline">
                                <x-icons.external />
                                {{ $link }}
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-layout.app>
