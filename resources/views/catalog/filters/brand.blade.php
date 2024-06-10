<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{$filter->title()}}</h5>
    @foreach($filter->values() as $id => $title)
        <div class="form-checkbox">
            <input id="{{$filter->id($id)}}"
                   type="checkbox"
                   name="{{$filter->name($id)}}"
                   value="{{$id}}"
                @checked( $filter->requestValue($id))
            >
            <label class="form-checkbox-label" for="{{$filter->id($id)}}">{{$title}}</label>
        </div>
    @endforeach


</div>
