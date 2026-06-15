<x-layout.app>
<x-form title="Register now" description="Start journaling your day">

<form method="POST" action="/register" class="space-y-4">
    @csrf

    <x-form.field name="username" label="Username"/>
    <x-form.field type="email" name="email" label="Email"/>
    <x-form.field type="password" name="password" label="Password" />
    
        <button type="submit" class="btn mt-4 h-10 w-full">Create account</button>
</form>
    
</x-form>
</x-layout.app>