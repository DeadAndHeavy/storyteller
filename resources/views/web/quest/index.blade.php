@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Quests</div>

                <div class="panel-body">
                    @if (count($quests))
                        <table id="public_quests_table" class="table table-bordered">
                            <thead>
                                <tr class="active">
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Genre</th>
                                    <th>Author</th>
                                    <th>Rating</th>
                                    @if (Auth::check())
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @each('web/quest/partial/public_quest', $quests, 'quest')
                            </tbody>
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
