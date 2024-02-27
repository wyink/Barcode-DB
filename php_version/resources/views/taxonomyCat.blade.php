@extends('layouts.layout')

@section('append_header')
    <link rel="stylesheet" href="/css/All_tax_table.css">
@endsection

@section('headerContent')
    <header>
        <div class="header-inner">
            <div class="Logo">Barcode DB</div>
            <div class="header-item">
                <nav class="nav1">
                    <ul>
                        <li><a href="/"> Top </a></li>
                        <li><a href="/download">DownLoad</a></li>
                        <li><a href="#">Taxonomy</a></li>
                        <li><a href="/help"> Help </a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="wrap_header">
        <p class="header">{{$alp}}</p>
    </div>
    <main>
        <ul class="accordion">
            <li class="alpha">
                <div class="table_wrap">
                    <table class="content">
                        <caption>{{$category}}/{{$alp}} </caption>
                        <caption></caption>
                        <tbody>
                            <tr>
                                <th>{{$alp}}</th>
                                <th>All included database</th>
                                <th>Curated DB</th>
                            </tr>
                            @if($items != null)
                                @if($category =='species')
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->speciesName}}</td>
                                        <td>{{$item->allIncludedCount}}</td>
                                        <td>{{$item->curatedDbCount}}</td>
                                    </tr>
                                    @endforeach
                                @elseif($category =='genus')
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->genusName}}</td>
                                        <td>{{$item->allIncludedCount}}</td>
                                        <td>{{$item->curatedDbCount}}</td>
                                    </tr>
                                    @endforeach
                                @elseif($category =='family')
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->familyName}}</td>
                                        <td>{{$item->allIncludedCount}}</td>
                                        <td>{{$item->curatedDbCount}}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </li>
        </ul>
    </main>
@endsection
