@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Episode</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('update_episode', ['questId' => $questId, 'episodeId' => $episode->id ]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <input id="quest_id" type="hidden" name="quest_id" value="{{ $questId }}">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-2 control-label">Episode short title</label>

                            <div class="col-md-10">
                                <input type="text" id="title" class="form-control" spellcheck="false" name="title" value="{{ $episode->title }}">
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
                                <textarea id="content" class="form-control" noresize rows="15" spellcheck="false" name="content">{{ $episode->content }}</textarea>
                                @if ($errors->has('content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div id="episode_actions_container">
                            @if (old('actions_list'))
                                @foreach (old('actions_list') as $action_index => $action_data)
                                    @include('web/episode/partial/episode_action', [
                                        'action_index' => $action_index,
                                        'action_content' => $action_data['content'],
                                        'action_id' => $action_data['action_id'],
                                        'quest_id' => $questId
                                    ])
                                @endforeach
                            @else
                                @foreach ($episode->episodeActions as $action_index => $action)
                                    @include('web/episode/partial/episode_action', [
                                        'action_index' => $action_index + 1,
                                        'action_content' => $action->content,
                                        'action_id' => $action->id,
                                        'quest_id' => $questId
                                    ])
                                @endforeach
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <button id="add_episode_action" data-quest_id="{{ $questId }}" class="btn btn-success" type="button">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update episode
                                </button>
                                <a href="{{ route('all_episodes', ['questId' => $questId]) }}" class="btn btn-info">
                                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back to episodes
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
