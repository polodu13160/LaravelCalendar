<div>
   {{-- {{ dd($this->invitation) }} --}}
   @foreach ($this->invitation as $invite)
        
        <div class="card">
            <div class="card-header">
                <h3>{{ $invite->team->name }}</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p>{{ $invite->userCreateInvite->name }} vous a invité en tant que {{ $invite->role }} </p>
                        <div>
                            <button wire:click="acceptInvitation({{ $invite }},1)" class="btn btn-success">Accept</button>
                            <button wire:click="acceptInvitation({{ $invite }},0)" class="btn btn-danger">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
       
   @endforeach
</div>
