@foreach($entries as $entry)
<option data-subtext="{{Str::title($entry->label)}}" value="{{$entry->id}}">
    @for ($i = 0; $i < $level; $i++) - @endfor {{$entry->name}} </option>
    @if(count($entry->childInstitutions) != 0)
        @include ('components.option-tree', ['entries' => $entry->childInstitutions, 'level'=>$level+1])
    @endif
@endforeach


