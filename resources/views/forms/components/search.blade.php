<x-dynamic-component
    :component="Search"
    :id="$getId()"
    :label="ค้นหาทะเบียนรถ"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer }">
        <label for="search">ค้นหาทะเบียนรถ</label>
       <input type="search" name="search" id="search" />
    </div>
</x-dynamic-component>
