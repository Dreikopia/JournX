<div class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex align-center items-center justify-between">
        
        <div>
            <a href="/">
                <img src="{{ asset('images/JournX.logo.png') }}" width="150" alt="logo">            </a>
        </div>

      

        @auth
        <div>
        
            <h1>{{ ucfirst(Auth::user()->username) }}</h1>
        </div>
        <div class="flex gap-x-5 items-center font-bold">
            <form method="POST" action="/logout">
            @csrf
                <button type="submit" class="btn bg-red-500 font-bold hover:bg-red-800">
                    Log out
                </button>
            </form>
        </div>    
        @endauth
        
        @guest()
        <div class="flex gap-x-5 items-center font-bold">
            <a href="/login">Sign in</a>
            <a href="/register" class="btn text-neutral">Register</a>
        </div>
        @endguest

    </div>
</div>