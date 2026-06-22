@props(['journal' => new App\Models\Journal()])

<x-modal name="{{ $journal->exists ? 'edit-journal' : 'create-journal' }}"
    title="{{ $journal->exists ? 'Edit Journal' : 'Create Journal' }}">
    <form x-data="{
        mood: @js(old('mood', $journal->mood->value)),
        newLink: '',
        links: @js(old('links', $journal->links ?? [])),
        newTask: '',
        tasks: @js(old('tasks', $journal->tasks->map->only(['id', 'description', 'completed']))),
        hasImage: false
    }" method="POST"
        action="{{ $journal->exists ? route('journal.update', $journal) : route('journal.store') }}"
        x-bind:enctype="hasImage ? 'multipart/form-data' : false">
        @csrf

        @if ($journal->exists)
            @method('PATCH')
        @endif
        {{-- tasks: @js(old('tasks', $jurnal->links)) doesnt need to pluck becauase it s only a links array --}}
        <div>
            <x-form.field 
            name="title" 
            label="Title" 
            placeholder="Enter a title" 
            :value="$journal->title" />

            <div class="mb-4 space-y-2">
                <label for="mood" class="label">Mood</label>
                <div class="flex gap-x-3">
                    @foreach (App\JournalMood::cases() as $mood)
                        <button type="button" @click="mood = @js($mood->value)" class="btn h-10 flex-1"
                            :class="{ 'btn-outlined': mood !== @js($mood->value) }" data-test="button-mood-{{ $mood->value }}">
                            {{ $mood->label() }}
                        </button>
                    @endforeach
                    <input type="hidden" name="mood" :value="mood">
                </div>
                <x-form.error name="mood" />
            </div>

            <x-form.field 
            type="textarea" 
            name="description" 
            label="Description" 
            placeholder="What happen to your day?"
            :value="$journal->description" />

            @if ($journal->image_path)
                <div class="space-y-2">
                    <img src="{{ asset('storage/' . $journal->image_path) }}" alt="{{ $journal->title }}"
                        class="w-full h-48 object-cover">

                    <button 
                    form="delete-image-form" 
                    type="submit" 
                    class="btn btn-outlined w-full h-10">Remove
                        Image</button>
                </div>
            @endif

            <div class="space-y-2 mb-2">
                <label for="image" class="label">Featured Images</label>

                <input type="file" name="image" accept="image/*"
                    @change="hasImage = $event.target.files.length > 0">
                <x-form.error name="image" />
            </div>


            <div>
                <fieldset class="mb-4 space-y-3">
                    <legend class="label">Tasks</legend>

                    <template x-for="(task, index) in tasks" :key="index">
                        <div class="flex items-center gap-x-2">
                            <input 
                            type="text" 
                            :name="`tasks[${index}][description]`" 
                            x-model="tasks[index].description" 
                            class="input">

                            <input 
                            type="hidden" 
                            :name="`tasks[${index}][completed]`" 
                            :value="tasks[index].completed ? '1': '0'" 
                            class="input"
                            >

                            <button type="button" class="form-muted-icon" @click="tasks.splice(index, 1)">
                                <x-icons.close />
                            </button>
                        </div>
                    </template>

                    <div class="flex items-center gap-x-2">

                        <input 
                        x-model="newTask" 
                        type="text" 
                        id="newTask" 
                        data-test="new-task"
                        placeholder="What have you accomplished for today?" 
                        spellcheck="false" 
                        class="input">

                        <button @click="tasks.push({ description: newTask.trim(), completed: false }); newTask = '';"
                            :disabled="newTask . trim() . length === 0" data-test="submit-new-task-button" type="button" class="form-muted-icon">
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
                <input 
                x-model="newLink" 
                type="url" 
                id="newLink" 
                data-test="new-link"
                placeholder="http://example.com" 
                autocomplete="off" 
                spellcheck="false" 
                class="input"
                >

                <button @click="links.push(newLink.trim()); newLink = '';" :disabled="newLink . trim() . length === 0"
                    data-test="submit-new-link-button" type="button" class="form-muted-icon">
                    <x-icons.close class="rotate-45" />
                </button>

            </div>
            </fieldset>
        </div>

        <div class="mt-4 flex justify-end gap-x-3">

            <button type="button" class="btn btn-outlined" @click="$dispatch('close-modal')">
                Cancel
            </button>

            <button type="submit" class="btn" data-test="create-btn">
                {{ $journal->exists ? 'Save Changes' : 'Create' }}
            </button>
        </div>
    </form>

    {{-- run only if journal is exist --}}
    @if ($journal->image_path)
        <form method="POST" action="{{ route('journal.image.destroy', $journal) }}" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif

</x-modal>
