@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Quests</div>

                <div class="panel-body">
                    @if (count($questsForApproving))
                        <table class="table table-bordered">
                            <tr class="active">
                                <td class="col-md-4 text-center vertical-align">Quest name</td>
                                <td class="col-md-2 text-center vertical-align">Author</td>
                                <td class="col-md-2 text-center vertical-align">Approve Actions</td>
                            </tr>
                            @foreach ($questsForApproving as $questForApproving)
                                <tr class="active">
                                    <td class="text-center vertical-align">
                                        <a href="{{ route('quest_page', ['questId' => $questForApproving->quest_id]) }}">{{ $questForApproving->quest->name }}</a>
                                    </td>
                                    <td class="text-center vertical-align">{{ $questForApproving->quest->author->name }}</td>
                                    <td class="text-center">
                                        <form class="approve_quest" style="display:inline" role="form" action="{{ route('approve_quest', ['questId' => $questForApproving->quest_id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="PATCH">
                                            <button type="submit" class="btn btn-success" title="Approve">
                                                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Approve
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-danger" data-reject_route="{{ route('reject_quest', ['questId' => $questForApproving->quest_id]) }}" data-toggle="modal" data-target="#rejectQuestModal">
                                            <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> Reject
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        No quests for approving
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('web/modal/reject_quest')
@endsection
