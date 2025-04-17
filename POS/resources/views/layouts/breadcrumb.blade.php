@php
    // Menetapkan breadcrumb default jika variabel breadcrumb belum didefinisikan
    $breadcrumb = $breadcrumb ?? (object)[
        'title' => 'Beranda',
        'list' => ['Home', 'Beranda']
    ];
@endphp

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ is_array($breadcrumb->title) ? json_encode($breadcrumb->title) : $breadcrumb->title }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          @foreach ($breadcrumb->list as $key => $item)
            @php
              $isLast = $key === array_key_last($breadcrumb->list);
            @endphp
        
            @if (is_array($item))
              @if ($isLast)
                <li class="breadcrumb-item active">{{ $item['name'] }}</li>
              @else
                <li class="breadcrumb-item">
                  <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                </li>
              @endif
            @else
              @if ($isLast)
                <li class="breadcrumb-item active">{{ $item }}</li>
              @else
                <li class="breadcrumb-item"><a href="#">{{ $item }}</a></li>
              @endif
            @endif
          @endforeach
        </ol>        
      </div>
    </div>
  </div>
</section>
