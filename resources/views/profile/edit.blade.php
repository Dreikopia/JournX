<x-layout.app>
    
    <x-form title="Edit your profile" description="Need some tweaking">

        <form method="POST" action="" class="space-y-4">
            
            @csrf
            @method('PATCH')
            <x-form.field name="username" label="Username" :value="$user->username"/>
            <x-form.field type="email" name="email" label="Email" :value="$user->email" />
            <x-form.field type="password" name="password" label="Password" />

            <button type="submit" class="btn mt-4 h-10 w-full" data-test="create-account">Save changes</button>
        </form>
    </x-form>

</x-layout.app>
