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
        <x-modal name="create-journal" title="New Entry">
            <form x-data="{
                mood: 'neutral',
                newLink: '',
                links: [],
                newTask: '',
                tasks: [],
                hasImage: false
            }" method="POST" action="{{ route('journal.store') }}"
                x-bind:enctype="hasImage ? 'multipart/form-data' : false">
                @csrf

                <div>
                    <x-form.field name="title" label="Title" placeholder="Enter a title" />

                    <div class="mb-4 space-y-2">
                        <label for="mood" class="label">Mood</label>
                        <div class="flex gap-x-3">
                            @foreach (App\JournalMood::cases() as $mood)
                                <button type="button" @click="mood = @js($mood->value)"
                                    class="btn h-10 flex-1"
                                    :class="{ 'btn-outlined': mood !== @js($mood->value) }"
                                    data-test="button-mood-{{ $mood->value }}">
                                    {{ $mood->label() }}
                                </button>
                            @endforeach
                            <input type="hidden" name="mood" :value="mood">
                        </div>
                        <x-form.error name="mood" />
                    </div>

                    <x-form.field type="textarea" name="description" label="Description"
                        placeholder="What happen to your day?" />


                    <div class="space-y-2 mb-2">
                        <label for="image" class="label">Featured Images</label>

                        <input type="file" name="image" accept="image/*"
                            @change="hasImage = $event.target.files.length > 0">
                        <x-form.error name="image" />
                    </div>


                    <div>
                        <fieldset class="mb-4 space-y-3">
                            <legend class="label">Tasks</legend>

                            <template x-for="(task, index) in tasks">
                                <div class="flex items-center gap-x-2">
                                    <input type="text" name="tasks[]" x-model="tasks[index]" class="input">
                                    <button type="button" class="form-muted-icon" @click="tasks.splice(index, 1)">
                                        <x-icons.close />
                                    </button>
                                </div>
                            </template>

                            <div class="flex items-center gap-x-2">
                                <input x-model="newTask" type="text" id="newTask" data-test="new-task"
                                    placeholder="What have you accomplished for today?" spellcheck="false"
                                    class="input">

                                <button @click="tasks.push(newTask.trim()); newTask = '';"
                                    :disabled="newTask.trim().length === 0" data-test="submit-new-task-button"
                                    type="button" class="form-muted-icon">
                                    <x-icons.close class="rotate-45" />
                                </button>
                            </div>
                        </fieldset>
                    </div>

                    <div>
                        <fieldset class="space-y-3">
                            <legend class="label">Links</legend>
                            <template x-for="(link, index) in links">
                                <div class="flex items-center gap-x-2">
                                    <input type="text" name="links[]" x-model="links[index]" class="input">
                                    <button type="button" class="form-muted-icon" @click="links.splice(index, 1)">
                                        <x-icons.close />
                                    </button>
                                </div>
                            </template>
                        </fieldset>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <input x-model="newLink" type="url" id="newLink" data-test="new-link"
                            placeholder="http://example.com" autocomplete="off" spellcheck="false" class="input">

                        <button @click="links.push(newLink.trim()); newLink = '';"
                            :disabled="newLink.trim().length === 0" data-test="submit-new-link-button" type="button"
                            class="form-muted-icon">
                            <x-icons.close class="rotate-45" />
                        </button>
                    </div>
                    </fieldset>
                </div>

                <div class="mt-4 flex justify-end gap-x-3">
                    <button type="button" class="btn btn-outlined" @click="$dispatch('close-modal')">Cancel</button>
                    <button type="submit" class="btn" data-test="create-btn">Create</button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layout.app>
