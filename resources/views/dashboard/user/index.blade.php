@extends('layout.dashboard')

@section('content')
    <div class="header">
        <div class="sidebar-toggler visible-xs">
            <i class="ion ion-navicon"></i>
        </div>
        <span class="uppercase">
            <i class="ion ion-ios-person-outline"></i> {{ trans('dashboard.team.profile') }}
        </span>
    </div>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                @include('dashboard.partials.errors')
                <form name="UserForm" class="form-vertical" role="form" action="/dashboard/user" method="POST">
                    {!! csrf_field() !!}
                    <fieldset>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <a href="https://gravatar.com"><img src="{{ $current_user->gravatar }}" class="img-responsive img-thumbnail" title="{{ trans('forms.user.gravatar') }}" data-toggle="tooltip"></a>
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('forms.user.username') }}</label>
                                    <input type="text" class="form-control" name="username" value="{{ $current_user->username }}" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('forms.user.email') }}</label>
                                    <input type="email" class="form-control" name="email" value="{{ $current_user->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('forms.user.password') }}</label>
                                    <input type="password" class="form-control password-strength" name="password" value="">
                                    <div class="strengthify-wrapper"></div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="checkbox-inline">
                                        <input type="hidden" name="google2fa" value="0">
                                        <input type='checkbox' name="google2fa" value="1" {{ $current_user->hasTwoFactor ? "checked" : "" }}>
                                        {{ trans('forms.setup.enable_google2fa') }}
                                    </label>
                                </div>
                                @if($current_user->hasTwoFactor)
                                <div class="form-group">
                                    <?php
                                    $google2fa_url = PragmaRX\Google2FA\Vendor\Laravel\Facade::getQRCodeGoogleUrl(
                                        'Cachet',
                                        $current_user->email,
                                        $current_user->google_2fa_secret
                                    );
                                    ?>
                                    <img src="{{ $google2fa_url }}" class="img-responsive">
                                    <span class='help-block'>{!! trans('forms.user.2fa.help') !!}</span>
                                </div>
                                @endif

                                <button type="submit" class="btn btn-success">{{ trans('forms.update') }}</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <form name="UserAPIForm" class="form-vertical" role="form" action="/dashboard/user/{{ $current_user->id }}/api/create" method="POST">
                    {!! csrf_field() !!}
                    <fieldset>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ trans('forms.user.api-token') }}</label>
                                    @foreach ($current_user->apiKeys as $api_key)
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="api_key" disabled value="{{ $api_key->api_key }} ({{ $api_key->description }})">
                                        <a href="/dashboard/user/{{ $current_user->id }}/api/revoke/{{ $api_key->id }}" class="input-group-addon btn btn-danger">{{ trans('cachet.api.revoke') }}</a>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                        <input type="text" class="form-control" name="description" placeholder="API Key Description e.g. 'Jenkins Job'" value="">
                                </div>
                                <button type="submit" class="btn btn-success">{{ trans('cachet.api.create') }}</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@stop
