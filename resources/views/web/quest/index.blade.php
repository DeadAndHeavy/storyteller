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
                                    <th class="col-md-2 text-center">Title</th>
                                    <th class="col-md-3 text-center">Description</th>
                                    <th class="col-md-1 text-center">Genre</th>
                                    <th class="col-md-1 text-center">Author</th>
                                    <th class="col-md-1 text-center">Rating</th>
                                    <th class="col-md-1 text-center">Comments</th>
                                    <th class="col-md-3 text-center">Actions</th>
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
@if (Auth::check() && Auth::user()->isAdmin())
    @include('web/modal/reject_quest')
@endif
@endsection
