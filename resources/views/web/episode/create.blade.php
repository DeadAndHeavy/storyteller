@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Episode</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/episode/store') }}">
                        {{ csrf_field() }}

                        <input id="quest_id" type="hidden" name="quest_id" value="{{ $quest->id }}">

                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content" class="col-md-4 control-label">Episode text</label>

                            <div class="col-md-6">
                                <input id="content" type="text" class="form-control" name="content" value="{{ old('content') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Episode actions</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" value="">
                                <button type="button">Add action</button>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Quest description</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" noresize maxlength="255" spellcheck="false" name="description">{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
