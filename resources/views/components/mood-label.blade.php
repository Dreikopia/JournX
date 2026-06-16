@php
    $baseClasses = 'inline-block rounded-full border mt-2 px-2 py-1 text-xs font-medium';
    
    $moodClasses = match($mood) {
        'neutral' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
        'good' => 'bg-green-500/10 text-green-500 border-green-500/20',
        'bad' => 'bg-red-500/10 text-red-500 border-red-500/20',
        default => 'bg-gray-500/10 text-gray-500 border-gray-500/20',
    };
    
    $classes = "$baseClasses $moodClasses";
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
