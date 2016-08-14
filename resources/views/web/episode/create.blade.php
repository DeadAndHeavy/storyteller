@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Episode</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('store_episode', ['questId' => $quest->id ]) }}">
                        {{ csrf_field() }}
                        <input id="quest_id" type="hidden" name="quest_id" value="{{ $quest->id }}">

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-2 control-label">Episode short title</label>

                            <div class="col-md-10">
                                <input type="text" id="title" class="form-control" spellcheck="false" name="title" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content" class="col-md-2 control-label">Episode text</label>

                            <div class="col-md-10">
                                <textarea id="content" class="form-control" noresize rows="15" spellcheck="false" name="content">{{ old('content') }}</textarea>
                                @if ($errors->has('content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div id="episode_actions_container">
                            @if (old('action_content'))
                                @foreach (old('action_content') as $action_index => $action_content)
                                    @include('web/episode/partial/episode_action', ['episodes' => $episodes, 'action_index' => $action_index, 'action_content' => $action_content])
                                @endforeach
                            @else
                                @include('web/episode/partial/episode_action', ['episodes' => $episodes, 'action_index' => 1, 'action_content' => ''])
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <button id="add_episode_action" data-quest_id="{{ $quest->id }}" class="btn btn-success" type="button">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                                <button id="delete_episode_action" data-quest_id="{{ $quest->id }}" class="btn btn-danger" type="button">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
