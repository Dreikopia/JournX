@props([
    'name',
    'label',
    'type' => 'text',
    'preserveValue' => true])

<div class="space-y-2">
    <label for="{{ $name }}" class="label">{{ $label }}</label>
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        class="input" 
        value="{{ $preserveValue ? old($name) : '' }}"          
        {{ $attributes }}>

        <div class="min-h-5">
            @error($name)
                <p class="text-sm error">{{$message}}</p>
            @enderror
        </div>

</div>
