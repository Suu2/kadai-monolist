@extends('layouts.app')

@section('content')
    <h1>Haveランキング</h1>
    <?php $type = 'have'; ?>
    @include('items.items', ['items', $items])
@endsection