<div>
    <input wire:model="search" type="text" placeholder="Search mails..."/>
 
    <ul>
        @foreach($usersMails as $user)
            <li>{{ $user->email }}</li>
        @endforeach
    </ul>
</div>
