<div class="modal" id="rejectQuestModal" tabindex="-1" role="dialog" aria-labelledby="rejectQuestModal">
    <div class="modal-dialog" role="document">
        <form class="reject_quest" data-toggle="validator" style="display:inline" role="form" action="" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Quest rejection</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">Reject reason</label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="message" value="" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" title="Reject">
                        <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> Reject
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>