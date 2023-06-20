 <div class="modal fade" id="{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog {{$size ?? ""}}" role="document" >
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{$title}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"  style="max-height: 70vh;overflow:auto">
                @foreach ($forms as $item)
                <div class="form-group">
                    @if ($item->label != 'notes')
                    <label for="" class="text-capitalize">{{str_replace("_", " ",$item->label)}}</label>
                    @endif
                    @switch($item->type)
                        @case('notes_warning')
                            <div style="border: 2px dashed rgb(222, 180, 43);background: rgba(224, 191, 28, 0.35);border-radius: 8px;padding:10px;">
                                <h5 class="text-uppercase">{{$item->label}}</h5>
                                <p style="font-size: 10pt;font-style: italic">
                                    {{$item->description}}
                                </p>
                            </div>
                            @break
                        @case('text')
                            <input type="text" class="form-control form-control-sm" id="{{$item->label}}">
                            @break
                        @case('number')
                            <input type="number" class="form-control form-control-sm" id="{{$item->label}}">
                            @break
                        @case('textarea')
                            <textarea class="form-control form-control-sm"  id="{{$item->label}}" cols="30" rows="10"></textarea>
                            @break
                        @case('file')
                            <iframe src="" id="iframe_{{$item->label}}" frameborder="0" style="width: 100%;height:600px;display:none"></iframe>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="{{$item->label}}" accept="{{App\Helpers\CheckType::accFiles($item->accept)}}" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01" id="label-{{$item->label}}">Choose file</label>
                            </div>
                            <small class="small" style="font-style: italic"></small>
                                @if ($item->accept == 'pdf')
                                    <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                                @endif
                            @break
                        @case('date')
                            <input type="date" class="form-control form-control-sm" id="{{$item->label}}">
                            @break
                        @case('dropdown')
                            <select name="name" class="form-control form-control-sm" id="{{$item->label}}">
                                <option value="" disabled selected> -- Pilih Kelas --</option>
                                @foreach ($item->items as $kelas)
                                    <option value="{{$kelas->id}}">{{$kelas->name}}</option>
                                @endforeach
                            </select>
                            @break
                        @default
                    @endswitch
                </div>
                @endforeach
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="{{$btnsv}}" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
</div>
