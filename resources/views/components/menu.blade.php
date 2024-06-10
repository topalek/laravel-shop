<nav class="2xl:flex gap-8">
    @foreach($menu as $item)
        <a class="hover:text-pink font-bold {{$item->isActive() ? 'text-pink': 'text-white'}}" href="{{$item->link()}}">{{$item->label()}}</a>
    @endforeach
</nav>
