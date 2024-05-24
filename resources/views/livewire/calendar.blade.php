<div>
        <div class="center-block">
            <h2>Afficher Calendrier </h2>
            <div class="checkbox-container">
                <label class="checkbox-label">
                    <input type="checkbox" id="moi" name="affichage" value="moi" wire:model="choiceUser.user">
                    <span class="checkbox-custom"></span>
                    Moi
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" id="groupe" name="affichage" value="Groupe" wire:model="choiceUser.group">
                    <span class="checkbox-custom"></span>
                    Le groupe
                </label>
            </div>
        </div>
        <script>
            window.calendarUrls = @json($this->allUrlIcsEvents);
        </script>
        <div id="calendar-container" wire:ignore>
            <div id="calendar"></div>
        </div>
        @vite(['resources/js/calendar.js'])
    
  
    
</div>
