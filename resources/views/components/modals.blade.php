<div class="modal fade" id="{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog {{$size ?? ""}}  {{$position}}" role="document" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{$title}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body"  style="max-height: 70vh;overflow:auto">
            {{$slot}}
        </div>
        <div class="modal-footer">
           @if ($custombtn != null)

           @endif
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="{{$btnsv}}" class="btn btn-sm btn-primary" {{$attr}}>Save changes</button>
        </div>
      </div>
    </div>
</div>
