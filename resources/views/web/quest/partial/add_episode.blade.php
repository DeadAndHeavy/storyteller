<div class="episode col-md-12" data-episode_number="{{ $episode_number }}">
    <div class="panel panel-success">
        <div class="panel-heading">Episode {{ $episode_number }}</div>
        <div class="panel-body">
            <div class="form-group">
                <label for="episode_{{ $episode_number }}_content" class="col-md-2 control-label">Episode text</label>
                <div class="col-md-10">
                    <textarea id="episode_{{ $episode_number }}_content" class="form-control" rows="10" spellcheck="false" name="episodes[{{ $episode_number }}][content]"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>