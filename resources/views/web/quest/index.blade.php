@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Quests</div>

                <div class="panel-body">
                    @if (count($quests))
                        <table class="table table-bordered">
                            <tr>
                                <td>Quest name</td>
                                <td>Quest description</td>
                                <td>Author</td>
                            </tr>
                            @foreach ($quests as $quest)
                                <tr>
                                    <td>{{ $quest->name }}</td>
                                    <td>{{ $quest->description }}</td>
                                    <td>{{ $quest->author->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        No quests
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
