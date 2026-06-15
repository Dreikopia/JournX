<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>
<body class="bg-background text-foreground">
 
      <x-layout.nav/>

    <main class="max-w-7xl mx-auto mt-8 px-6">
        {{$slot}}
    </main>

    @session('success')
    <div 
    x-data="{ show:true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-transition.opacity.duration.700ms
    x-show="show"
    class="bg-primary px-4 py-3 absolute bottom-4 right-4 rounded-lg"
    >
        {{ $value }}
    </div>
    @endsession
</body>
</html>