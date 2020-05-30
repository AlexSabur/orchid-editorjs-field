@foreach($blocks as $block)
    <div class="row">
        <div class="col-auto col-xs-12">
            {!! $block->build() ?? '' !!}
        </div>
    </div>
@endforeach
