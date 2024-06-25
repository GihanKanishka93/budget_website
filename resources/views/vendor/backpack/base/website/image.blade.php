{{-- image column type --}}
@php
  if(isset($img)){
    $value = $img;
  } else {
    $value = data_get($entry, $column['name']);
  }
  if($value) {
    $column['height'] = $column['height'] ?? "50px";
    $column['width'] = $column['width'] ?? "auto";
    $column['prefix'] = $column['prefix'] ?? '';

    if (is_array($value)) {
      $value = json_encode($value);
    }

    if (preg_match('/^data\:image\//', $value)) { // base64_image
      $href = $src = $value;
    } elseif (isset($column['disk'])) { // image from a different disk (like s3 bucket)
      $href = $src = Storage::disk($column['disk'])->url($column['prefix'].$value);
    } else { // plain-old image, from a local disk
      $href = $src = asset( $column['prefix'] . $value);
    }

    $column['wrapper']['element'] = $column['wrapper']['element'] ?? 'a';
    $column['wrapper']['href'] = $column['wrapper']['href'] ?? $href;
    $column['wrapper']['target'] = $column['wrapper']['target'] ?? '_blank';
  }
@endphp

<span>
  @if( empty($value) )
    -
  @else
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        <img src="{{ $src }}" style="
        max-height: {{ $column['height'] }};
        width: {{ $column['width'] }};"
        />
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
  @endif
</span>
