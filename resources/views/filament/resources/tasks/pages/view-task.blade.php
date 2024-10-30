<x-filament-panels::page>
    @if ($this->hasInfolist())
    {{ $this->infolist }}
    @else
    {{ $this->form }}
    @endif


    @livewire('comment', ['taskId' => $this->record->id])


    {{-- @vite('resources/js/app.js')
    <script>
        setTimeout(() => {
            window.Echo.channel('commentChannel')
            .listen('commentEvent', (e) => {
                console.log(e);
                console.log(e.user);
                console.log(e.user.name);
                console.log(e.user.avatar);
                console.log(e.comment);
            })
        }, 200);
    </script> --}}






    @if (count($relationManagers = $this->getRelationManagers()))
    <x-filament-panels::resources.relation-managers :active-manager="$this->activeRelationManager"
        :managers="$relationManagers" :owner-record="$record" :page-class="static::class" />
    @endif
</x-filament-panels::page>
