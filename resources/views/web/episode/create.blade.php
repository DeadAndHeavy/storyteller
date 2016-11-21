@extends('layouts.app')
@section('content')
<div class="container create_episode_page">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Episode</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('store_episode', ['questId' => $quest->id ]) }}">
                        {{ csrf_field() }}
                        <input id="quest_id" type="hidden" name="quest_id" value="{{ $quest->id }}">

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-2 control-label">Episode short title</label>

                            <div class="col-md-8">
                                <input type="text" id="title" class="form-control" maxlength="100" spellcheck="false" name="title" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-2 control-label">Episode type</label>

                            <div class="col-md-3">
                                <select id="type" name="type" class="form-control">
                                    <option disabled selected>@lang('episode.choose_type')</option>
                                    @foreach ($types as $key => $value)
                                        @if (old('type') == $key)
                                            <option selected value="{{ $key }}">{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('episode_image') ? ' has-error' : '' }}">
                            <label for="episode_image" class="col-md-2 control-label">Episode image</label>
                            <div class="col-md-10">
                                <label class="btn btn-default" for="episode_image">
                                    <input id="episode_image" type="file" style="display:none;" name="episode_image" onchange="$('#upload-file-info').html($(this).val());">
                                    Upload image
                                </label>
                                <span class='label label-success' id="upload-file-info"></span>
                                @if ($errors->has('episode_image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('episode_image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content" class="col-md-2 control-label">Episode text</label>

                            <div class="col-md-10">
                                <textarea id="content" class="form-control" noresize maxlength="4000" rows="15" spellcheck="false" name="content">{{ old('content') }}</textarea>
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
                                        'episodes' => $episodes,
                                        'action_index' => $action_index,
                                        'action_content' => $action_data['content'],
                                        'quest_id' => $quest->id,
                                    ])
                                @endforeach
                            @else
                                @include('web/episode/partial/episode_action', [
                                    'episodes' => $episodes,
                                    'action_index' => 1,
                                    'action_content' => '',
                                    'quest_id' => $quest->id
                                ])
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <button id="add_episode_action" data-quest_id="{{ $quest->id }}" class="btn btn-success" type="button">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <a href="{{ route('all_episodes', ['questId' => $quest->id]) }}" class="btn btn-default">
                                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back to episodes
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Create episode
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
