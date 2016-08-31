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
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Genre</th>
                                    <th class="text-center">Author</th>
                                    <th class="text-center">Rating</th>
                                    @if (Auth::check())
                                        <th class="text-center">Actions</th>
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
