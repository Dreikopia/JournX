@props(['name', 'label' => false, 'type' => 'text', 'preserveValue' => true, 'value' => null])

<div class="space-y-2">

    @if ($label)
        <label for="{{ $name }}" class="label">{{ $label }}</label>
    @endif


    @if ($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" class="textarea focus:ring-2 focus:ring-primary"
            {{ $attributes }}>{{ old($name, $value) }}</textarea>
    @else
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
            class="input focus:ring-2 focus:ring-primary" value="{{ $preserveValue ? old($name, $value) : '' }}"
            {{ $attributes }}>
    @endif

    <div>
        <x-form.error :name="$name" />
    </div>

</div>
