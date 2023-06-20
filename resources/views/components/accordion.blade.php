<div class="card">
    <div class="card-header" id="heading-{{$idx}}">
        <h2 class="mb-0">
        <button class="btn  btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{$idx}}" aria-expanded="true" aria-controls="collapse-{{$idx}}">
           Pertanyaan - {{$questid}}
        </button>
        </h2>
    </div>

    <div id="collapse-{{$idx}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-penugasan">
        <div class="card-body">
            {{$slot}}
        </div>
    </div>
    </div>
