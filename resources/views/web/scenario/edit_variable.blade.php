@extends('layouts.app')
@section('content')
<div class="container create_variable_page">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Variable</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('update_quest_variable', ['questId' => $questId, 'variableId' => $variable->id]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <input id="quest_id" type="hidden" name="quest_id" value="{{ $questId }}">

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-2 control-label">Variable name</label>

                            <div class="col-md-8">
                                <input type="text" id="title" class="form-control" maxlength="100" spellcheck="false" name="title" value="{{ $variable->title }}">
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
                                    <option disabled selected>@lang('variable.choose_type')</option>
                                    @foreach ($types as $key => $value)
                                        @if ($variable->type == $key)
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

                        <div class="form-group{{ $errors->has('default_value') ? ' has-error' : '' }}">
                            <label for="default_value" class="col-md-2 control-label">Default value</label>

                            <div class="col-md-8">
                                <input type="text" id="default_value" class="form-control" maxlength="100" spellcheck="false" name="default_value" value="{{ $variable->default_value }}">
                                @if ($errors->has('default_value'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('default_value') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('track_state') ? ' has-error' : '' }}">
                            <label for="default_value" class="col-md-2 control-label">Track state</label>
                            <div class="col-md-8">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="track_state" id="track_state_yes" value="1" {{ $variable->track_state == 1 ? 'checked' : '' }}>
                                        Yes
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="track_state" id="track_state_no" value="0" {{ $variable->track_state == 0 ? 'checked' : '' }}>
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <a href="{{ route('quest_page', ['id' => $questId]) }}" class="btn btn-default">
                                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back to quest page
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update variable
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
