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
                                        <a href="{{ route('edit_quest', ['id' => $quest->id]) }}" class="btn btn-primary">Update</a>
                                        <form class="visible-lg-inline-block delete_quest" role="form" action="{{ route('delete_quest', ['id' => $quest->id]) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{ csrf_field() }}
                                            <button onclick="return confirm('Are you sure you want to delete this quest?');" type="submit" class="btn btn-danger">Delete</button>
                                        </form>
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
