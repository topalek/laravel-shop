@extends('layouts.app')
@section('title', $category->title ?? 'Каталог')

@section('content')
    <main class="py-16 lg:py-20">
        <div class="container">

            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
                <li><a class="text-body hover:text-pink text-xs" href="{{route('home')}}">Главная</a></li>
                @if($category->exists)
                    <li><a class="text-body hover:text-pink text-xs" href="{{route('shop')}}">Каталог</a></li>
                    <li><span class="text-body text-xs">{{$category->title}}</span></li>
                @else
                    <li><span class="text-body text-xs">Каталог</span></li>
                @endif
            </ul>

            <section>
                <!-- Section heading -->
                <h2 class="text-lg lg:text-[42px] font-black">Категории</h2>

                <!-- Categories -->
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3 sm:gap-4 md:gap-5 mt-8">
                    @each('catalog.shared.category', $categories, 'category')
                </div>
            </section>

            <section class="mt-16 lg:mt-24">
                <!-- Section heading -->
                <h2 class="text-lg lg:text-[42px] font-black">Каталог товаров</h2>

                <div class="flex flex-col lg:flex-row gap-12 lg:gap-6 2xl:gap-8 mt-8">

                    <!-- Filters -->
                    <aside class="basis-2/5 xl:basis-1/4">
                        <form
                            action="{{route('shop' ,$category)}}"
                            class="overflow-auto max-h-[320px] lg:max-h-[100%] space-y-10 p-6 2xl:p-8 rounded-2xl bg-card">
                            @foreach(filters() as $filter)
                                {!! $filter !!}
                            @endforeach


                            <!-- Filter item -->
                            <div>
                                <h5 class="mb-4 text-sm 2xl:text-md font-bold">Цвет</h5>
                                <div class="form-checkbox">
                                    <input id="filters-item-9" type="checkbox">
                                    <label class="form-checkbox-label" for="filters-item-9">Белый</label>
                                </div>
                                <div class="form-checkbox">
                                    <input id="filters-item-10" type="checkbox">
                                    <label class="form-checkbox-label" for="filters-item-10">Чёрный</label>
                                </div>
                                <div class="form-checkbox">
                                    <input id="filters-item-11" type="checkbox">
                                    <label class="form-checkbox-label" for="filters-item-11">Желтый</label>
                                </div>
                                <div class="form-checkbox">
                                    <input id="filters-item-12" type="checkbox">
                                    <label class="form-checkbox-label" for="filters-item-12">Розовый</label>
                                </div>
                                <div class="form-checkbox">
                                    <input id="filters-item-13" type="checkbox">
                                    <label class="form-checkbox-label" for="filters-item-13">Красный</label>
                                </div>
                                <div class="form-checkbox">
                                    <input id="filters-item-14" type="checkbox">
                                    <label class="form-checkbox-label" for="filters-item-14">Серый</label>
                                </div>
                            </div>
                            <!-- Filter item -->
                            <div>
                                <h5 class="mb-4 text-sm 2xl:text-md font-bold">Подсветка</h5>
                                <div class="form-checkbox">
                                    <input id="filters-item-7" type="checkbox">
                                    <label class="form-checkbox-label" for="filters-item-7">Без подсветки</label>
                                </div>
                                <div class="form-checkbox">
                                    <input id="filters-item-8" type="checkbox">
                                    <label class="form-checkbox-label" for="filters-item-8">З подсветкой</label>
                                </div>
                            </div>
                            <div>
                                <button class="w-full !h-16 btn btn-pink" type="submit">Поиск</button>
                            </div>
                            @if(request('filters'))
                                <div>
                                    <button class="w-full !h-16 btn btn-outline" type="reset">Сбросить фильтры</button>
                                </div>
                            @endif

                        </form>
                    </aside>

                    <div class="basis-auto xl:basis-3/4">
                        <!-- Sort by -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <a class="@if(is_catalog_view('grid')) pointer-events-none  text-pink @endif inline-flex items-center justify-center w-10 h-10 rounded-md bg-card"
                                       href="{{filter_url($category, ['view'=> 'grid'])}}">
                                        <x-icons.grid class="h-5 w5-"/>
                                    </a>
                                    <a class="@if(is_catalog_view('list')) pointer-events-none  text-pink @else text-white  @endif inline-flex items-center justify-center w-10 h-10 rounded-md bg-card  hover:text-pink"
                                       href="{{filter_url($category, ['view'=> 'list'])}}">
                                        <x-icons.list class="h-5 w5-"/>
                                    </a>
                                </div>
                                <div class="text-body text-xxs sm:text-xs">Найдено: {{$products->total()}} товаров</div>
                            </div>
                            <div x-data="{sort: '{{filter_url($category, ['sort'=>request('sort')])}}'}" class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <span class="text-body text-xxs sm:text-xs">Сортировать по</span>
                                <form
                                    x-ref="sortForm"
                                    action="{{filter_url($category, ['sort' => request('sort')])}}">
                                    <select
                                        name="sort"
                                        x-model="sort"
                                        x-on:change="window.location = sort"
                                        class="form-select w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xxs sm:text-xs shadow-transparent outline-0 transition">
                                        <option class="text-dark" value="{{ filter_url($category, ['sort' => '']) }}">умолчанию</option>
                                        <option class="text-dark" value="{{ filter_url($category, ['sort' => 'price']) }}">от дешевых к дорогим</option>
                                        <option class="text-dark" value="{{ filter_url($category, ['sort' => '-price']) }}">от дорогих к дешевым</option>
                                        <option class="text-dark" value="{{ filter_url($category, ['sort' => 'title']) }}">названию</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <!-- Products list -->
                        <div class="products grid grid-cols-1 gap-y-8 @if(is_catalog_view('grid')) sm:grid-cols-2 xl:grid-cols-3 gap-x-6 2xl:gap-x-8 lg:gap-y-10 2xl:gap-y-12 @endif ">
                            @each('catalog.shared.product'.(is_catalog_view('list') ? '-list' : ''), $products, 'product')
                        </div>

                        <!-- Page pagination -->
                        <div class="mt-12">
                            {{$products->withQueryString()->links()}}
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>
@endsection
