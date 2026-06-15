<x-layout.app>
    <x-form title="Log in" description="Start journaling your day">
    
    <form method="POST" action="/login" class="space-y-4">
        @csrf
    
        <x-form.field name="login" label="Username or email address"/>
        <x-form.field type="password" name="password" label="Password" :preserveValue="false"/>        
            <button type="submit" class="btn mt-4 h-10 w-full">Sign in</button>
        @error('credentials')
            <p class="text-sm error">{{$message}}</p>
        @enderror
    </form>
        
    </x-form>
</x-layout.app>