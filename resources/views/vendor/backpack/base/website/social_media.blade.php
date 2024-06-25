{{-- enumerate the values in an array  --}}
@php
    $value = data_get($entry, $column['name']);
    $column['escaped'] = $column['escaped'] ?? false;

    // the value should be an array wether or not attribute casting is used
    if (!is_array($value)) {
        $value = json_decode($value, true);
    }
    
    $new_array = array();
    if(!$value) return false;
    foreach ($value as $to_obj)
    {
        $new_array[] = (object)$to_obj;
    }
    $value = $new_array;
    // dd($new_array[0]);
@endphp

<span>
    @foreach($value as $key => $text)        
        @if ($text->url)
            <p>
                <strong class="d-inline-flex">
                        {{$text->type}}
                </strong>
                <span>
                    - {{$text->url}}
                </span>
            </p>
        @endif
    @endforeach
</span>
