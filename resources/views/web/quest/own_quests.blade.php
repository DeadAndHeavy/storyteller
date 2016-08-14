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
                            @each('web/quest/partial/quest', $quests, 'quest')
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
