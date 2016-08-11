@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Quests</div>

                <div class="panel-body">
                    @if (count($quests))
                        <table class="table table-bordered">
                            <tr class="active">
                                <td class="col-md-2 text-center vertical-align">Quest name</td>
                                <td class="col-md-4 text-center vertical-align">Quest description</td>
                                <td class="col-md-1 text-center vertical-align">Quest genre</td>
                                <td class="col-md-2 text-center vertical-align">Actions</td>
                            </tr>
                            @foreach ($quests as $quest)
                                <tr>
                                    <td class="text-center vertical-align">{{ $quest->name }}</td>
                                    <td class="vertical-align">{{ $quest->description }}</td>
                                    <td class="text-center vertical-align">@lang('quest.genre_' . $quest->genre)</td>
                                    <td class="text-center vertical-align">
                                        <a href="{{ url('/quest/update') }}" class="btn btn-primary">Update</a>
                                        <a href="{{ url('/quest/delete') }}" class="btn btn-danger">Delete</a>
                                    </td>
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
