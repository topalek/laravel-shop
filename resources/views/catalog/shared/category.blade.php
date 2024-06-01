<a class="p-3 sm:p-4 2xl:p-6 rounded-xl hover:bg-pink text-xxs sm:text-xs lg:text-sm text-white font-semibold flex text-center justify-center items-center {{request()->is('shop/'.$category->slug) ? 'bg-pink': 'bg-card'}}"
   href="{{route('shop', $category)}}">{{$category->title}}</a>
