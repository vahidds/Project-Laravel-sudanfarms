@extends('dashboard.layout.app')

@section('content')

@section('title', __('dashboard.products')  .' - '. __('dashboard.add'))

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('dashboard.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('dashboard.dashboard')</a></li>
                <li><a href="{{ route('dashboard.products.index') }}"> @lang('dashboard.categorey')</a></li>
                <li class="active">@lang('dashboard.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('dashboard.add')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    {{-- @include('partials._errors') --}}

                    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        @php
                            $names  = ['name_ar','name_en'];
                            $descr  = ['description_ar','description_en'];
                            $qguard = ['quantity_guard_ar','quantity_guard_en'];
                        @endphp

                        @foreach ($names as $name)

                            <div class="form-group">
                                <label>@lang('dashboard.' . $name)</label>
                                <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name) }}">
                            </div>
                            
                        @endforeach

                        @foreach ($descr as $desc)

                            <div class="form-group">
                                <label>@lang('dashboard.' . $desc)</label>
                                <textarea type="text" name="{{ $desc }}" class="ckeditor form-control">{{ old($desc) }}</textarea>
                            </div>
                            
                        @endforeach

                        <div class="form-group">
                            <label>@lang('dashboard.categorey')</label>
                            <select name="sub_category_id" class="form-control">
                                <option value="">@lang('dashboard.all_categories')</option>
                                @foreach ($sub_categoreys as $category)
                                    <option value="{{ $category->id }}" {{ old('sub_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>@lang('dashboard.image')</label>
                            <input type="file" multiple name="image[]" class="form-control image">
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('uploads/product_image/default.jpg') }}"  style="width: 100px" class="img-thumbnail image-preview" alt="">
                        </div>

                        <div class="form-group">
                            <label>@lang('dashboard.price')</label>
                            <input type="number" step="0.01" step="any" name="price" class="form-control" value="{{ old('price') }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('dashboard.price_decount')</label>
                            <input type="number" step="0.01" step="any" name="price_decount" class="form-control" value="{{ old('price_decount') }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('dashboard.quantity')</label>
                            <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}">
                        </div>

                        @foreach ($qguard as $name)

                            <div class="form-group">
                                <label>@lang('dashboard.' . $name)</label>
                                <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name) }}">
                            </div>
                            
                        @endforeach

                        <div class="form-group">
                            <label>@lang('dashboard.start_time')</label>
                            <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('dashboard.end_time')</label>
                            <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('dashboard.stars')</label>
                            <select name="stars" class="form-control">
                                @for ($i = 1; $i < 7; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('dashboard.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection