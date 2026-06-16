@props([
    'name',
    'label' => false,
    'type' => 'text',
    'preserveValue' => true])

<div class="space-y-2">

    @if($label)
    <label for="{{ $name }}" class="label">{{ $label }}</label>        
    @endif


    @if($type === 'textarea')
        <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        class="textarea focus:ring-2 focus:ring-primary"
        {{ $attributes }}
        >{{ old($name) }}</textarea>    
    @else

    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        class="input focus:ring-2 focus:ring-primary" 
        value="{{ $preserveValue ? old($name) : '' }}"          
        {{ $attributes }}>
    @endif

        <div class="min-h-5">
        <x-form.error :name="$name"/>
        </div>

</div>
