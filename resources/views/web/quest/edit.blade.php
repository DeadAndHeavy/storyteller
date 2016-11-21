@extends('layouts.app')
@section('content')
<div class="container edit_quest_page">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Update Quest Info</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ url('/quest', ['id' => $quest->id]) }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="PATCH">
                        <input id="user_id" type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Quest title</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $quest->name }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('genre') ? ' has-error' : '' }}">
                            <label for="genre" class="col-md-2 control-label">Quest genre</label>

                            <div class="col-md-4">
                                <select id="genre" name="genre" class="form-control">
                                    <option disabled selected>@lang('quest.choose_genre')</option>
                                    @foreach ($genres as $key => $value)
                                        @if ($quest->genre == $key)
                                            <option selected value="{{ $key }}">{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('genre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('genre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('quest_image') ? ' has-error' : '' }}">
                            <label for="quest_image" class="col-md-2 control-label">Quest image</label>
                            <div class="col-md-10">
                                <label class="btn btn-default" for="quest_image">
                                    <input id="quest_image" type="file" style="display:none;" name="quest_image" onchange="$('#upload-file-info').html($(this).val());">
                                    Upload image
                                </label>
                                <span class='label label-success' id="upload-file-info"></span>
                                @if ($errors->has('quest_image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quest_image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <img class="episode_image_edit" src="{{ URL::asset('quests_images/' . $quest->id . '/quest_logo.jpg?mt=' . $imageModificationTime) }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-2 control-label">Quest description</label>

                            <div class="col-md-10">
                                <textarea id="description" class="form-control" noresize maxlength="3000" rows="14" spellcheck="false" name="description">{{ $quest->description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <a href="{{ route('own_quests') }}" class="btn btn-default">
                                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back to own quests
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
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
