<div>
        <div class="center-block">
            <h2>Afficher Calendrier </h2>
            <div class="checkbox-container">
                <label class="checkbox-label">
                    <input type="checkbox" id="moi" name="affichage" value="moi" wire:click="checkboxChanged()" wire:model="choiceUser.User"  >
                    <span class="checkbox-custom"></span>
                    Moi
                </label>
                <label class="checkbox-label">
                    
                    <input type="checkbox" id="groupe" name="affichage" value="Groupe" wire:click="checkboxChanged()" wire:model="choiceUser.Group">
                    <span class="checkbox-custom"></span>
                    Le groupe
                </label>
            </div>
            @foreach ($calendarUrl as $item)
                {{$item}}
            @endforeach
           
        </div>
        
        <script>
            window.calendarUrls = @json($this->allIcsEvents);
        </script>
       
        
        <div id="calendar-container" wire:ignore>
            <div id="calendar"></div>
        </div>
      
        @vite(['resources/js/calendar.js'])
       
        
        
       
    
  
    
</div>

