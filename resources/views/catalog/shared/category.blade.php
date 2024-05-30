<a class="p-3 sm:p-4 2xl:p-6 rounded-xl hover:bg-pink text-xxs sm:text-xs lg:text-sm text-white font-semibold {{request()->is('catalog/'.$category->slug) ? 'bg-pink': 'bg-card'}}"
   href="{{route('catalog', $category)}}">{{$category->title}}</a>
