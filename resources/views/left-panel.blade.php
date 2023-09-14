<div class="flex flex-col gap-8 h-full">
    <div class="flex gap-3 items-center">
        <div class="w-12 h-12 rounded-full overflow-hidden">
            <img src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                alt="Avatar" height="15px" width="auto" class="object-cover w-full h-full">
        </div>
        <div class="flex flex-col">
            <span class="uppercase">{{ auth()->user()->name }}</span>
            <Link class=" text-sm underline underline-offset-2">Edit profile</Link>
        </div>
    </div>
    <hr class="border-teal-600">
    <div class="flex flex-col gap-5">
        <x-layouts.navigation-link resource="skill" action="index" label="Skills board"
            icon-path="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
        <x-layouts.navigation-link resource="contribution" action="index" label="My contributions"
            icon-path="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
    </div>
    <x-layouts.navigation-link resource="logout" label="Logout" icon-path="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
</div>
