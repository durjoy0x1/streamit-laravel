@extends('backend.layouts.app')

@section('content')

<x-back-button-component route="backend.episodes.index" />
<p class="text-danger" id="error_message"></p>
        {{ html()->form('PUT' ,route('backend.episodes.update', $data->id))
        ->attribute('enctype', 'multipart/form-data')
        ->attribute('data-toggle', 'validator')
        ->attribute('id', 'form-submit')  // Add the id attribute here
        ->attribute('novalidate', 'novalidate')  // Disable default browser validation
        ->class('requires-validation')  // Add the requires-validation class
        ->open()
    }}

        @csrf
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6>{{__('customer.about')}} {{__('episode.episode')}}</h6>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6 col-lg-3">
                        <input type="hidden" name="tmdb_id" id="tmdb_id" value="{{ $tmdb_id }}">
                        <div class="position-relative">
                            {{ html()->label(__('movie.lbl_poster'), 'poster')->class('form-label') }}

                            <div class="input-group btn-file-upload">
                                {{ html()->button(__('<i class="ph ph-image"></i>'.__('messages.lbl_choose_image')))
                                    ->class('input-group-text form-control')
                                    ->type('button')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainer2')
                                    ->attribute('data-hidden-input', 'file_url2')
                                }}

                                {{ html()->text('image_input2')
                                    ->class('form-control')
                                    ->placeholder(__('placeholder.lbl_image'))
                                    ->attribute('aria-label', 'Image Input 2')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainer2')
                                    ->attribute('data-hidden-input', 'file_url2')
                                    ->attribute('aria-describedby', 'basic-addon1')
                                }}
                            </div>

                            <div class="uploaded-image" id="selectedImageContainer2">
                                @if ($data->poster_url)
                                    <img
                                        src="{{ old('poster_url', isset($data) ? $data->poster_url : '') }}" alt="feature-image"
                                        class="img-fluid mb-2 avatar-80 "/>

                                    <span class="remove-media-icon"
                                          style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                                          onclick="removeImage('file_url2', 'remove_image_flag')">×</span>
                                @else
                                    <p>No image selected.</p>
                                @endif
                            </div>

                            {{ html()->hidden('poster_url')->id('file_url2')->value($data->poster_url) }}
                            {{ html()->hidden('remove_image')->id('remove_image_flag')->value(0) }}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <input type="hidden" name="tmdb_id" id="tmdb_id" value="{{ $tmdb_id }}">
                        <div class="position-relative">
                            {{ html()->label(__('movie.lbl_poster_tv'), 'poster_tv')->class('form-label') }}

                            <div class="input-group btn-file-upload">
                                {{ html()->button(__('<i class="ph ph-image"></i>'.__('messages.lbl_choose_image')))
                                    ->class('input-group-text form-control')
                                    ->type('button')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerTv')
                                    ->attribute('data-hidden-input', 'file_urltv')
                                }}

                                {{ html()->text('image_input_tv')
                                    ->class('form-control')
                                    ->placeholder(__('placeholder.lbl_image'))
                                    ->attribute('aria-label', 'Image Input Tv')
                                    ->attribute('data-bs-toggle', 'modal')
                                    ->attribute('data-bs-target', '#exampleModal')
                                    ->attribute('data-image-container', 'selectedImageContainerTv')
                                    ->attribute('data-hidden-input', 'file_urltv')
                                    ->attribute('aria-describedby', 'basic-addon1')
                                }}
                            </div>

                            <div class="uploaded-image" id="selectedImageContainerTv">
                                @if ($data->poster_tv_url)
                                    <img
                                        src="{{ old('poster_tv_url', isset($data) ? $data->poster_tv_url : '') }}" alt="feature-image"
                                        class="img-fluid mb-2 avatar-80 "/>

                                    <span class="remove-media-icon"
                                          style="cursor: pointer; font-size: 24px; position: absolute; top: 0; right: 0; color: red;"
                                          onclick="removeTvImage('file_urltv', 'remove_image_flag_tv')">×</span>
                                @else
                                    <p>No image selected.</p>
                                @endif
                            </div>

                            {{ html()->hidden('poster_tv_url')->id('file_urltv')->value($data->poster_tv_url) }}
                            {{ html()->hidden('remove_image')->id('remove_image_flag_tv')->value(0) }}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                {{ html()->label(__('season.lbl_tv_shows') . ' <span class="text-danger">*</span>', 'type')->class('form-label') }}
                                {{ html()->select(
                                        'entertainment_id',
                                        $tvshows->pluck('name', 'id')->prepend(__('placeholder.lbl_select_tvshow'),''), $data->entertainment_id)->class('form-control select2')->id('entertainment_id')->attribute('required','required') }}
                                @error('entertainment_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">TV Show field is required</div>
                            </div>
                            <div class="col-md-6">
                                {{ html()->label(__('placeholder.lbl_select_season') . ' <span class="text-danger">*</span>', 'season_id')->class('form-label') }}
                                {{ html()->select(
                                        'season_id',
                                        $seasons->pluck('name', 'id')->prepend(__('placeholder.lbl_select_season'),''),$data->season_id)->class('form-control select2')->id('season_id')->attribute('required','required') }}
                                @error('season_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Season field is required</div>
                            </div>
                            <div class="col-md-6">
                                {{ html()->label(__('movie.lbl_name') . ' <span class="text-danger">*</span>', 'name')->class('form-label') }}
                                {{ html()->text('name')->attribute('value', $data->name)->placeholder(__('placeholder.lbl_episode_name'))->class('form-control')->attribute('required','required') }}
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Name field is required</div>
                            </div>
                            <div class="col-md-6">
                                {{ html()->label(__('plan.lbl_status'), 'status')->class('form-label') }}
                                <div class="d-flex justify-content-between align-items-center form-control">
                                    {{ html()->label(__('messages.active'), 'status')->class('form-label mb-0 text-body') }}
                                    <div class="form-check form-switch">
                                        {{ html()->hidden('status', 0) }}
                                        {{ html()->checkbox('status', $data->status)->class('form-check-input')->id('status') }}
                                    </div>
                                </div>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                {{ html()->label(__('movie.lbl_movie_access') , 'access')->class('form-label') }}
                                <div class="d-flex align-items-center gap-3">
                                    <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                    <div >
                                        <input class="form-check-input" type="radio" name="access" id="paid" value="paid"
                                            onchange="showPlanSelection(this.value === 'paid')"
                                            {{ $data->access == 'paid' ? 'checked' : '' }} checked>
                                        <span class="form-check-label" >{{__('movie.lbl_paid')}}</span>
                                    </div>
                                </label>
                                <label class="form-check form-check-inline form-control px-5 cursor-pointer">
                                    <div>
                                        <input class="form-check-input" type="radio" name="access" id="free" value="free"
                                            onchange="showPlanSelection(this.value === 'paid')"
                                            {{ $data->access == 'free' ? 'checked' : '' }}>
                                        <span class="form-check-label" >{{__('movie.lbl_free')}}</span>
                                    </div>
                                </div>
                              </label>
                                @error('access')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6  {{ old('access', 'paid') == 'free' ? 'd-none' : '' }}" id="planSelection">
                                {{ html()->label(__('movie.lbl_select_plan'). ' <span class="text-danger">*</span>', 'type')->class('form-label') }}
                                {{ html()->select('plan_id', $plan->pluck('name', 'id')->prepend(__('placeholder.lbl_select_plan'), ''), $data->plan_id)->class('form-control select2')->id('plan_id') }}
                                @error('plan_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="invalid-feedback" id="name-error">Plan field is required</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            {{ html()->label(__('movie.lbl_short_desc'), 'short_desc')->class('form-label') }}
                            <span class="text-primary cursor-pointer" id="GenrateshortDescription" ><i class="ph ph-info" data-bs-toggle="tooltip" title="{{ __('messages.chatgpt_info') }}"></i> {{ __('messages.lbl_chatgpt') }}</span>
                        </div>
                        {{ html()->textarea('short_desc',$data->short_desc)->class('form-control')->id('short_desc')->placeholder(__('placeholder.episode_short_desc'))->rows('8') }}
                        @error('short_desc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            {{ html()->label(__('movie.lbl_description'). '<span class="text-danger"> *</span>', 'description')->class('form-label mb-0') }}
                            <span class="text-primary cursor-pointer" id="GenrateDescription" ><i class="ph ph-info" data-bs-toggle="tooltip" title="{{ __('messages.chatgpt_info') }}"></i> {{ __('messages.lbl_chatgpt') }}</span>
                        </div>
                        {{ html()->textarea('description',$data->description)->class('form-control')->id('description')->placeholder(__('placeholder.lbl_movie_description'))->attribute('required','required') }}
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="desc-error">Description field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_trailer_url_type'). ' <span class="text-danger">*</span>', 'type')->class('form-label') }}
                        {{ html()->select(
                                'trailer_url_type',
                                $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_type'), ''),
                                old('trailer_url_type', $data->trailer_url_type ?? '')
                            )->class('form-control select2')->id('trailer_url_type') }}
                        @error('trailer_url_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Trailer Type field is required</div>

                    </div>
                    <div class="col-md-6 col-lg-4 d-none" id="url_input">
                        {{ html()->label(__('movie.lbl_trailer_url'). ' <span class="text-danger">*</span>', 'trailer_url')->class('form-label') }}
                        {{ html()->text('trailer_url')->attribute('value', $data->trailer_url)->placeholder(__('placeholder.lbl_trailer_url'))->class('form-control') }}
                        @error('trailer_url')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="trailer-url-error">Video URL field is required</div>
                        <div class="invalid-feedback" id="trailer-pattern-error" style="display:none;">
                        Please enter a valid URL starting with http:// or https://.
                    </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-none" id="url_file_input">
                        {{ html()->label(__('movie.lbl_trailer_video'). ' <span class="text-danger">*</span>', 'trailer_video')->class('form-label') }}
                        <div class="mb-3" id="selectedImageContainer3">
                                @if (Str::endsWith($data->trailer_url, ['.jpeg', '.jpg', '.png', '.gif']))
                                    <img class="img-fluid mb-2" src="{{ $data->trailer_url }}" style="max-width: 100px; max-height: 100px;">
                                @else
                                <video width="400" controls="controls" preload="metadata" >
                                    <source src="{{ $data->trailer_url }}" type="video/mp4" >
                                    </video>
                                @endif
                        </div>

                        <div class="input-group btn-video-link-upload">
                            {{ html()->button(__('placeholder.lbl_select_file').'<i class="ph ph-upload"></i>')
                                ->class('input-group-text form-control')
                                ->type('button')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainer3')
                                ->attribute('data-hidden-input', 'file_url3')
                            }}

                            {{ html()->text('image_input3')
                                ->class('form-control')
                                ->placeholder(__('placeholder.lbl_select_file'))
                                ->attribute('aria-label', 'Image Input 3')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainer3')
                                ->attribute('data-hidden-input', 'file_url3')
                            }}
                        </div>

                        {{ html()->hidden('trailer_video')->id('file_url3')->value($data->trailer_url)->attribute('data-validation', 'iq_video_quality') }}


                        @error('trailer_video')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="trailer-file-error">Video File field is required</div>

                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h5>{{ __('movie.lbl_basic_info') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_duration') . ' <span class="text-danger">*</span>', 'duration')->class('form-label') }}
                        {{ html()->time('duration')->attribute('value',  $data->duration)->placeholder(__('movie.lbl_duration'))->class('form-control  min-datetimepicker-time')->attribute('required','required') }}
                        @error('time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="duration-error">Duration field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_imdb_rating') . ' <span class="text-danger">*</span>', 'IMDb_rating')->class('form-label') }}
                        {{ html()->text('IMDb_rating')
                                ->attribute('value', old('IMDb_rating', $data->IMDb_rating)) // Use old value or the existing movie value
                                ->placeholder(__('movie.lbl_imdb_rating'))
                                ->class('form-control')
                                ->required() }}

                        @error('IMDb_rating')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="imdb-error">IMDB Rating field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_release_date'). ' <span class="text-danger">*</span>' , 'release_date')->class('form-label') }}
                        {{ html()->date('release_date')->attribute('value', $data->release_date)->placeholder(__('movie.lbl_release_date'))->class('form-control datetimepicker')->attribute('required','required') }}
                        @error('release_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="release_date-error">Release Date field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_content_rating') . '<span class="text-danger">*</span>', 'content_rating')->class('form-label') }}
                        {{ html()->text('content_rating')->attribute('value', $data->content_rating)->placeholder(__('placeholder.lbl_content_rating'))->class('form-control')->attribute('required','required') }}

                        @error('content_rating')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Content Rating field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_age_restricted'), 'is_restricted')->class('form-label') }}
                        <div class="d-flex justify-content-between align-items-center form-control">
                            {{ html()->label(__('movie.lbl_child_content'), 'is_restricted')->class('form-label mb-0 text-body') }}
                            <div class="form-check form-switch">
                                {{ html()->hidden('is_restricted', 0) }}
                                {{ html()->checkbox('is_restricted', $data->is_restricted)->class('form-check-input')->id('is_restricted') }}
                            </div>
                        </div>
                        @error('is_restricted')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{ html()->label(__('movie.lbl_download_status'), 'download_status')->class('form-label') }}
                        <div class="d-flex justify-content-between align-items-center form-control">
                            {{ html()->label(__('messages.on'), 'download_status')->class('form-label mb-0 text-body') }}
                            <div class="form-check form-switch">
                                {{ html()->hidden('download_status', 0) }}
                                {{ html()->checkbox('download_status', !empty($data) && $data->download_status == 1)->class('form-check-input')->id('download_status')->value(1) }}
                            </div>
                        </div>
                        @error('download_status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h5>{{ __('movie.lbl_video_info') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6 col-lg-6">
                        {{ html()->label(__('movie.lbl_video_upload_type'). '<span class="text-danger">*</span>', 'video_upload_type')->class('form-label') }}
                        {{ html()->select(
                                'video_upload_type',
                                $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), ''),
                                old('video_upload_type', $data->video_upload_type ?? ''),
                            )->class('form-control select2')->id('video_upload_type') }}
                        @error('video_upload_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="name-error">Video Type field is required</div>
                    </div>
                    <div class="col-md-6 col-lg-6 d-none" id="video_url_input_section">
                        {{ html()->label(__('movie.video_url_input'). '<span class="text-danger">*</span>', 'video_url_input')->class('form-label') }}
                        {{ html()->text('video_url_input')->attribute('value', $data->video_url_input)->placeholder(__('placeholder.video_url_input'))->class('form-control') }}
                        @error('video_url_input')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="url-error">Video URL field is required</div>
                        <div class="invalid-feedback" id="url-pattern-error" style="display:none;">
                            Please enter a valid URL starting with http:// or https://.
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 d-none" id="video_file_input_section">
                        {{ html()->label(__('movie.video_file_input'). '<span class="text-danger">*</span>', 'video_file')->class('form-label') }}
                        <div class="mb-3" id="selectedImageContainer4">
                            @if (Str::endsWith($data->video_url_input, ['.jpeg', '.jpg', '.png', '.gif']))
                                <img class="img-fluid" src="{{ $data->video_url_input }}" style="width: 10rem; height: 10rem;">
                            @else
                            <video width="400" controls="controls" preload="metadata" >
                                <source src="{{ $data->video_url_input }}" type="video/mp4" >
                                </video>
                            @endif
                        </div>

                        <div class="input-group btn-video-link-upload">
                            {{ html()->button(__('placeholder.lbl_select_file').'<i class="ph ph-upload"></i>')
                                ->class('input-group-text form-control')
                                ->type('button')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainer4')
                                ->attribute('data-hidden-input', 'file_url4')
                            }}

                            {{ html()->text('image_input4')
                                ->class('form-control')
                                ->placeholder(__('placeholder.lbl_select_file'))
                                ->attribute('aria-label', 'Image Input 3')
                                ->attribute('data-bs-toggle', 'modal')
                                ->attribute('data-bs-target', '#exampleModal')
                                ->attribute('data-image-container', 'selectedImageContainer4')
                                ->attribute('data-hidden-input', 'file_url4')
                            }}
                        </div>

                        {{ html()->hidden('video_file_input')->id('file_url4')->value($data->video_url_input)->attribute('data-validation', 'iq_video_quality')  }}


                        @error('video')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="invalid-feedback" id="file-error">Video File field is required</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 mb-3">
            <h5>{{ __('movie.lbl_quality_info') }}</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-lg-12">
                        <label for="enable_quality" class="form-label">{{ __('movie.lbl_enable_quality') }}</label>
                        <div class="d-flex justify-content-between align-items-center form-control">
                            <label for="enable_quality" class="form-label mb-0 text-body">{{ __('movie.lbl_enable_quality') }}</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="enable_quality" value="0">
                                <input type="checkbox" name="enable_quality" id="enable_quality" class="form-check-input" value="1" onchange="toggleQualitySection()" {{!empty($data) && $data->enable_quality == 1 ? 'checked' : ''}} >
                            </div>
                        </div>
                        @error('enable_quality')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="enable_quality_section" class="col-md-12 enable_quality_section d-none">
                        <div id="video-inputs-container-parent">
                            @if(!empty($data['EpisodeStreamContentMapping']) && count($data['EpisodeStreamContentMapping']) > 0)
                            @foreach($data['EpisodeStreamContentMapping'] as $mapping)
                            <div class="row gy-3 video-inputs-container">
                                <div class="col-md-4">
                                    {{ html()->label(__('movie.lbl_video_upload_type'), 'video_quality_type')->class('form-label') }}
                                    {{ html()->select(
                                            'video_quality_type[]',
                                            $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), ''),
                                            $mapping->type,
                                        )->class('form-control select2 video_quality_type')->id('video_quality_type_' . $mapping->id) }}
                                    @error('video_quality_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 video-input">
                                    {{ html()->label(__('movie.lbl_video_quality'), 'video_quality')->class('form-label') }}
                                    {{ html()->select(
                                            'video_quality[]',
                                            $video_quality->pluck('name', 'value')->prepend(__('placeholder.lbl_select_quality'), ''),
                                            $mapping->quality // Populate the select with the existing quality
                                        )->class('form-control select2')->id('video_quality_' . $mapping->id) }}
                                    @error('video_quality')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 video-url-input quality_video_input" id="quality_video_input">
                                    {{ html()->label(__('movie.video_url_input'), 'quality_video_url_input')->class('form-label') }}
                                    {{ html()->text('quality_video_url_input[]', $mapping->url) // Populate the input with the existing URL
                                        ->placeholder(__('placeholder.video_url_input'))->class('form-control') }}
                                    @error('quality_video_url_input')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-3 mb-3 d-none video-file-input quality_video_file_input">
                                    {{ html()->label(__('movie.video_file_input'), 'quality_video')->class('form-label') }}

                                    <div class="input-group btn-video-link-upload">
                                        {{ html()->button(__('placeholder.lbl_select_file').'<i class="ph ph-upload"></i>')
                                            ->class('input-group-text form-control')
                                            ->type('button')
                                            ->attribute('data-bs-toggle', 'modal')
                                            ->attribute('data-bs-target', '#exampleModal')
                                            ->attribute('data-image-container', 'selectedImageContainer6')
                                            ->attribute('data-hidden-input', 'file_url5')
                                        }}

                                        {{ html()->text('image_input6')
                                            ->class('form-control')
                                            ->placeholder('Select Image')
                                            ->attribute('aria-label', 'Image Input 5')
                                            ->attribute('data-bs-toggle', 'modal')
                                            ->attribute('data-bs-target', '#exampleModal')
                                            ->attribute('data-image-container', 'selectedImageContainer6')
                                            ->attribute('data-hidden-input', 'file_url5')
                                        }}
                                    </div>
                                    <div class="mt-3" id="selectedImageContainer6">
                                        @if (Str::endsWith(setBaseUrlWithFileName($mapping->url), ['.jpeg', '.jpg', '.png', '.gif']))
                                            <img class="img-fluid" src="{{ setBaseUrlWithFileName($mapping->url) }}" style="max-width: 100px; max-height: 100px;">
                                        @else
                                        <video width="400" controls="controls" preload="metadata" >
                                            <source src="{{ setBaseUrlWithFileName($mapping->url) }}" type="video/mp4" >
                                            </video>
                                        @endif
                                    </div>

                                    {{ html()->hidden('quality_video[]')->id('file_url5')->value(setBaseUrlWithFileName($mapping->url))->attribute('data-validation', 'iq_video_quality') }}

                                    @error('quality_video')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-12 text-end mb-3">
                                    <button type="button" class="btn btn-secondary-subtle btn-sm fs-4 remove-video-input"><i class="ph ph-trash align-middle"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @else
                        <div class="row gy-3 video-inputs-container">
                            <div class="col-md-4">
                                {{ html()->label(__('movie.lbl_video_upload_type'), 'video_quality_type')->class('form-label') }}
                                {{ html()->select(
                                        'video_quality_type[]',
                                        $upload_url_type->pluck('name', 'value')->prepend(__('placeholder.lbl_select_video_type'), ''),
                                        old('video_quality_type', 'Local'),
                                    )->class('form-control select2 video_quality_type') }}
                                @error('video_quality_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 video-input">
                                {{ html()->label(__('movie.lbl_video_quality'), 'video_quality')->class('form-label') }}
                                {{ html()->select(
                                        'video_quality[]',
                                        $video_quality->pluck('name', 'value')->prepend(__('placeholder.lbl_select_quality'), ''),
                                        null // No existing quality
                                    )->class('form-control select2')->id('video_quality_new') }}
                                @error('video_quality')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 video-url-input quality_video_input" id="quality_video_input">
                                {{ html()->label(__('movie.video_url_input'), 'quality_video_url_input')->class('form-label') }}
                                {{ html()->text('quality_video_url_input[]', null) // No existing URL
                                    ->placeholder(__('placeholder.video_url_input'))->class('form-control') }}
                                @error('quality_video_url_input')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 d-none video-file-input quality_video_file_input">
                                {{ html()->label(__('movie.video_file_input'), 'quality_video')->class('form-label') }}
                                <div id="selectedImageContainer5">
                                    @if ($data->quality_video)
                                        <img src="{{ setBaseUrlWithFileName($data->quality_video) }}" class="img-fluid mb-2" style="max-width: 100px; max-height: 100px;">
                                    @endif
                                </div>

                                <div class="input-group btn-video-link-upload">
                                    {{ html()->button(__('placeholder.lbl_select_file').'<i class="ph ph-upload"></i>')
                                        ->class('input-group-text form-control')
                                        ->type('button')
                                        ->attribute('data-bs-toggle', 'modal')
                                        ->attribute('data-bs-target', '#exampleModal')
                                        ->attribute('data-image-container', 'selectedImageContainer5')
                                        ->attribute('data-hidden-input', 'file_url5')
                                    }}

                                    {{ html()->text('image_input5')
                                        ->class('form-control')
                                        ->placeholder(__('placeholder.lbl_select_file'))
                                        ->attribute('aria-label', 'Image Input 5')
                                        ->attribute('data-bs-toggle', 'modal')
                                        ->attribute('data-bs-target', '#exampleModal')
                                        ->attribute('data-image-container', 'selectedImageContainer5')
                                        ->attribute('data-hidden-input', 'file_url5')
                                    }}
                                </div>

                                {{ html()->hidden('quality_video[]')->id('file_url5')->value(setBaseUrlWithFileName($data->quality_video))->attribute('data-validation', 'iq_video_quality') }}
                                @error('quality_video')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-12 text-end mb-3">
                                <button type="button" class="btn btn-secondary-subtle btn-sm fs-4 remove-video-input d-none"><i class="ph ph-trash align-middle"></i></button>
                            </div>
                        </div>
                    @endif
                        </div>
                        <div class="text-end">
                            <a id="add_more_video" class="btn btn-sm btn-primary"><i class="ph ph-plus-circle"></i> {{__('episode.lbl_add_more')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid d-sm-flex justify-content-sm-end gap-3 mb-5">

            <button type="submit" class="btn btn-primary" id="submit-button">{{__('messages.save')}}</button>
        </div>
    </form>
    @include('components.media-modal')
@endsection
@push('after-scripts')
    <script>

document.addEventListener('DOMContentLoaded', function () {
        flatpickr('.min-datetimepicker-time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // Format for time (24-hour format)
            time_24hr: true // Enable 24-hour format

        });

        flatpickr('.datetimepicker', {
            dateFormat: "Y-m-d", // Format for date (e.g., 2024-08-21)

        });
    });

tinymce.init({
         selector: '#description',
         plugins: 'link image code',
         toolbar: 'undo redo | styleselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | removeformat | code | image',
         setup: function(editor) {
                // Setup TinyMCE to listen for changes
                editor.on('change', function(e) {
                    // Get the editor content
                    const content = editor.getContent().trim();
                    const $textarea = $('#description');
                    const $error = $('#desc-error');

                    // Check if content is empty
                    if (content === '') {
                        $textarea.addClass('is-invalid'); // Add invalid class if empty
                        $error.show(); // Show validation message

                    } else {
                        $textarea.removeClass('is-invalid'); // Remove invalid class if not empty
                        $error.hide(); // Hide validation message
                    }
                });
            }
     });

     $(document).on('click', '.variable_button', function() {
         const textarea = $(document).find('.tab-pane.active');
         const textareaID = textarea.find('textarea').attr('id');
         tinyMCE.activeEditor.selection.setContent($(this).attr('data-value'));
     });



        document.addEventListener('DOMContentLoaded', function() {

            function handleTrailerUrlTypeChange(selectedValue) {
                var FileInput = document.getElementById('url_file_input');
                var URLInput = document.getElementById('url_input');
                var trailerfile = document.querySelector('input[name="trailer_video"]');
                var trailerfileError = document.getElementById('trailer-file-error');
                var urlError = document.getElementById('trailer-url-error');
                var URLInputField = document.querySelector('input[name="trailer_url"]');

                if (selectedValue === 'Local') {
                    FileInput.classList.remove('d-none');
                    URLInput.classList.add('d-none');
                    trailerfile.setAttribute('required', 'required');
                    trailerfileError.style.display = 'block';
                    URLInputField.removeAttribute('required');

                } else if (selectedValue === 'URL' || selectedValue === 'YouTube' || selectedValue === 'HLS' || selectedValue === 'x265' ||
                    selectedValue === 'Vimeo') {
                    URLInput.classList.remove('d-none');
                    FileInput.classList.add('d-none');
                    URLInputField.setAttribute('required', 'required');
                    trailerfile.removeAttribute('required');
                    validateTrailerUrlInput()
                } else {
                    FileInput.classList.add('d-none');
                    URLInput.classList.add('d-none');
                    URLInputField.removeAttribute('required');
                    trailerfile.removeAttribute('required');
                }
            }

            function validateTrailerUrlInput() {
                    var URLInput = document.querySelector('input[name="trailer_url"]');
                    var urlPatternError = document.getElementById('trailer-pattern-error');
                    selectedValue = document.getElementById('trailer_url_type').value;
                    if (selectedValue === 'YouTube') {
                        urlPattern = /^(https?:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/;
                        urlPatternError.innerText = '';
                        urlPatternError.innerText='Please enter a valid Youtube URL'
                    } else if (selectedValue === 'Vimeo') {
                        urlPattern = /^(https?:\/\/)?(www\.vimeo\.com)\/.+$/;
                        urlPatternError.innerText = '';
                        urlPatternError.innerText='Please enter a valid Vimeo URL'
                    } else {
                        // General URL pattern for other types
                        urlPattern = /^https?:\/\/.+$/;
                         urlPatternError.innerText='Please enter a valid URL'
                    }
                        if (!urlPattern.test(URLInput.value)) {
                            urlPatternError.style.display = 'block';
                            return false;
                        } else {
                            urlPatternError.style.display = 'none';
                            return true;
                        }
                    }
            var initialSelectedValue = document.getElementById('trailer_url_type').value;
            handleTrailerUrlTypeChange(initialSelectedValue);
            $('#trailer_url_type').change(function() {
                var selectedValue = $(this).val();
                handleTrailerUrlTypeChange(selectedValue);
            });
            var URLInput = document.querySelector('input[name="trailer_url"]');
                if (URLInput) {
                    URLInput.addEventListener('input', function() {
                        validateTrailerUrlInput();
                    });
                }
        });

        function showPlanSelection(show) {
            var planIdSelect = document.getElementById('plan_id');
            var planSelection = document.getElementById('planSelection');
            if (show) {
                planSelection.classList.remove('d-none');
                planIdSelect.setAttribute('required', 'required');
            } else {
                planSelection.classList.add('d-none');
                planIdSelect.removeAttribute('required');
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            var movieAccessPaid = document.getElementById('paid');
            var movieAccessFree = document.getElementById('free');

            if (movieAccessPaid.checked) {
                showPlanSelection(true);
            } else if (movieAccessFree.checked) {
                showPlanSelection(false);
            }
        });


        function toggleQualitySection() {

var enableQualityCheckbox = document.getElementById('enable_quality');
var enableQualitySection = document.getElementById('enable_quality_section');

if (enableQualityCheckbox.checked) {

enableQualitySection.classList.remove('d-none');

} else {

enableQualitySection.classList.add('d-none');
}
}
document.addEventListener('DOMContentLoaded', function () {
toggleQualitySection();
});

document.addEventListener('DOMContentLoaded', function() {

function handleVideoUrlTypeChange(selectedtypeValue) {
    var VideoFileInput = document.getElementById('video_file_input_section');
    var VideoURLInput = document.getElementById('video_url_input_section');
    var vfi = document.querySelector('input[name="image_input4"]');
    var vui = document.getElementById('video_url_input');
    var videofile = document.querySelector('input[name="video_file_input"]');
    var videourl = document.querySelector('input[name="video_url_input"]');
    var fileError = document.getElementById('file-error');
    var urlError = document.getElementById('url-error');
    var urlPatternError = document.getElementById('url-pattern-error');

    if (selectedtypeValue === 'Local') {
        VideoFileInput.classList.remove('d-none');
        VideoURLInput.classList.add('d-none');
        videofile.setAttribute('required', 'required');
        videourl.removeAttribute('required');
        if (videofile.value !== '') {
            fileError.style.display = 'none';
        } else {
            vfi.setAttribute('required', 'required');
            fileError.style.display = 'block';
        }
        videourl.value = '';
        urlError.style.display = 'none';
        urlPatternError.style.display = 'none';
    } else if (selectedtypeValue === 'URL' || selectedtypeValue === 'YouTube' || selectedtypeValue === 'HLS' ||  selectedtypeValue === 'Vimeo' || selectedtypeValue === 'x265') {
        VideoURLInput.classList.remove('d-none');
        VideoFileInput.classList.add('d-none');
        videourl.setAttribute('required', 'required');
        videofile.removeAttribute('required');
        videofile.value = '';

        validateVideoUrlInput();
    } else {
        VideoFileInput.classList.add('d-none');
        VideoURLInput.classList.add('d-none');
        videofile.value = '';
        videourl.value = '';
        urlError.style.display = 'none';
        urlPatternError.style.display = 'none';
    }
}

function validateVideoUrlInput() {
    var videourl = document.querySelector('input[name="video_url_input"]');
    var urlError = document.getElementById('url-error');
    var urlPatternError = document.getElementById('url-pattern-error');

    if (videourl.value === '') {
        urlError.style.display = 'block';
        urlPatternError.style.display = 'none';
        return false;
    } else {
        urlError.style.display = 'none';
        selectedValue = document.getElementById('video_upload_type').value;
                    if (selectedValue === 'YouTube') {
                        urlPattern = /^(https?:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/;
                        urlPatternError.innerText = '';
                        urlPatternError.innerText='Please enter a valid Youtube URL'
                    } else if (selectedValue === 'Vimeo') {
                        urlPattern = /^(https?:\/\/)?(www\.vimeo\.com)\/.+$/;
                        urlPatternError.innerText = '';
                        urlPatternError.innerText='Please enter a valid Vimeo URL'
                    } else {
                        // General URL pattern for other types
                        urlPattern = /^https?:\/\/.+$/;
                         urlPatternError.innerText='Please enter a valid URL starting with http:// or https://.'
                    }
        if (!urlPattern.test(videourl.value)) {
            urlPatternError.style.display = 'block';
            return false;
        } else {
            urlPatternError.style.display = 'none';
            return true;
        }
    }
}

var initialSelectedValue = document.getElementById('video_upload_type').value;
handleVideoUrlTypeChange(initialSelectedValue);
$('#video_upload_type').change(function() {
    var selectedtypeValue = $(this).val();
    handleVideoUrlTypeChange(selectedtypeValue);
});

// Real-time validation while typing
var videourl = document.querySelector('input[name="video_url_input"]');
if (videourl) {
    videourl.addEventListener('input', function() {
        validateVideoUrlInput();
    });
}

});

        function getSeasons(entertainmentId, selectedSeasonId = "") {
       var get_seasons_list = "{{ route('backend.seasons.index_list', ['entertainment_id' => '']) }}" + entertainmentId;
       get_seasons_list = get_seasons_list.replace('amp;', '');

       $.ajax({
           url: get_seasons_list,
           success: function(result) {

               var formattedResult = result.map(function(season) {
                   return { id: season.id, text: season.name };
               });

               $('#season_id').select2({
                   width: '100%',
                   placeholder: "{{ trans('messages.select_name', ['select' => trans('messages.season')]) }}",
                   data: formattedResult
               });

               if (selectedSeasonId != "") {
                   $('#season_id').val(selectedSeasonId).trigger('change');
               }
           }
       });
    }

    $(document).ready(function() {
    $('#entertainment_id').change(function() {
        var entertainmentId = $(this).val();
        if (entertainmentId) {
            $('#season_id').empty().select2({
                width: '100%',
                placeholder: "{{ trans('messages.select_name', ['select' => trans('messages.season')]) }}"
            });

            getSeasons(entertainmentId);
        } else {
            $('#season_id').empty().select2({
                width: '100%',
                placeholder: "{{ trans('messages.select_name', ['select' => trans('messages.season')]) }}"
            });
        }
    });
});


$(document).ready(function() {

$('#GenrateshortDescription').on('click', function(e) {

    e.preventDefault();

    var description = $('#short_desc').val();
    var name = $('#name').val();
    var tvshow = $('#entertainment_id').val();
    var season = $('#season_id').val();
    var type = 'short_desc';



    var generate_discription = "{{ route('backend.episodes.generate-description') }}";
        generate_discription = generate_discription.replace('amp;', '');

    if (!description && !name) {
         return;
     }

     $('#short_desc').text('Loading...')


  $.ajax({

       url: generate_discription,
       type: 'POST',
       headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
       data: {
               description: description,
               name: name,
               tvshow: tvshow,
               season:season,
               type:type
             },
       success: function(response) {

           $('#short_desc').text('')

            if(response.success){

             var data = response.data;
             $('#short_desc').html(data)

            } else {
                $('#error_message').text(response.message || 'Failed to get Description.');
            }
        },
       error: function(xhr) {
         $('#error_message').text('Failed to get Description.');
         $('#short_desc').text('');
           if (xhr.responseJSON && xhr.responseJSON.message) {
               $('#error_message').text(xhr.responseJSON.message);
           } else {
               $('#error_message').text('An error occurred while fetching the movie details.');
           }
        }
    });
  });
});

$(document).ready(function() {

$('#GenrateDescription').on('click', function(e) {

    e.preventDefault();

    var description = $('#description').val();
    var name = $('#name').val();
    var tvshow = $('#entertainment_id').val();
    var season = $('#season_id').val();
    var type = null;


    var generate_discription = "{{ route('backend.episodes.generate-description') }}";
        generate_discription = generate_discription.replace('amp;', '');

    if (!description && !name) {
         return;
     }

    tinymce.get('description').setContent('Loading...');

  $.ajax({

       url: generate_discription,
       type: 'POST',
       headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
       data: {
               description: description,
               name: name,
               tvshow: tvshow,
               season:season

             },
       success: function(response) {

          tinymce.get('description').setContent('');

            if(response.success){

             var data = response.data;

             tinymce.get('description').setContent(data);

            } else {
                $('#error_message').text(response.message || 'Failed to get Description.');
            }
        },
       error: function(xhr) {
         $('#error_message').text('Failed to get Description.');
         tinymce.get('description').setContent('');

           if (xhr.responseJSON && xhr.responseJSON.message) {
               $('#error_message').text(xhr.responseJSON.message);
           } else {
               $('#error_message').text('An error occurred while fetching the movie details.');
           }
        }
    });
 });
});

function removeImage(hiddenInputId, removedFlagId) {
            var container = document.getElementById('selectedImageContainer2');
            var hiddenInput = document.getElementById(hiddenInputId);
            var removedFlag = document.getElementById(removedFlagId);

            container.innerHTML = '';
            hiddenInput.value = '';
            removedFlag.value = 1;
        }
        function removeTvImage(hiddenInputId, removedFlagId) {
            var container = document.getElementById('selectedImageContainerTv');
            var hiddenInput = document.getElementById(hiddenInputId);
            var removedFlag = document.getElementById(removedFlagId);

            container.innerHTML = '';
            hiddenInput.value = '';
            removedFlag.value = 1;
        }
    </script>


    <style>
        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
        }

        .close-icon {
            top: -13px;
            left: 54px;
            background: rgba(255, 0, 0, 0.6);
            border: none;
            border-radius: 50%;
            color: white;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            line-height: 25px;
        }
    </style>
@endpush
