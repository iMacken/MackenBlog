@extends('admin.master')

@section('page_title',__('Viewing') . ' ' .$dataType->display_name_singular)

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> @lang('Viewing') {{ ucfirst($dataType->display_name_singular) }} &nbsp;

        <a href="{{ route('admin.'.$dataType->slug.'.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            @lang('Return to List')
        </a>
    </h1>
    @include('admin.multilingual.language-selector')
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    <!-- /.box-header -->
                    <!-- form start -->

                    @foreach($dataType->readRows as $row)
                        @php $rowDetails = json_decode($row->details); @endphp

                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">{{ $row->display_name }}</h3>
                        </div>

                        <div class="panel-body" style="padding-top:0;">
                            @if($row->type == "image")
                                <img class="img-responsive"
                                     src="{{ Admin::image($application->{$row->field}) }}">
                            @elseif($row->type == 'select_dropdown' && property_exists($rowDetails, 'options') &&
                                    !empty($rowDetails->options->{$application->{$row->field}})
                            )

                                <?php echo $rowDetails->options->{$application->{$row->field}};?>
                            @elseif($row->type == 'select_dropdown' && $application->{$row->field . '_page_slug'})
                                <a href="{{ $application->{$row->field . '_page_slug'} }}">{{ $application->{$row->field}  }}</a>
                            @elseif($application->{$row->field} && in_array($row->field, ['position_id', 'position_id_updated']))
                                {{ $application->position->name }}
                            @elseif($row->type == 'select_multiple')
                                @if(property_exists($rowDetails, 'relationship'))

                                    @foreach($application->{$row->field} as $item)
                                        @if($item->{$row->field . '_page_slug'})
                                        <a href="{{ $item->{$row->field . '_page_slug'} }}">{{ $item->{$row->field}  }}</a>@if(!$loop->last), @endif
                                        @else
                                        {{ $item->{$row->field}  }}
                                        @endif
                                    @endforeach

                                @elseif(property_exists($rowDetails, 'options'))
                                    @foreach($application->{$row->field} as $item)
                                     {{ $rowDetails->options->{$item} . (!$loop->last ? ', ' : '') }}
                                    @endforeach
                                @endif
                            @elseif($row->type == 'date')
                                {{ $rowDetails && property_exists($rowDetails, 'format') ? \Carbon\Carbon::parse($application->{$row->field})->formatLocalized($rowDetails->format) : $application->{$row->field} }}
                            @elseif($row->type == 'checkbox')
                                @if($rowDetails && property_exists($rowDetails, 'on') && property_exists($rowDetails, 'off'))
                                    @if($application->{$row->field})
                                    <span class="label label-info">{{ $rowDetails->on }}</span>
                                    @else
                                    <span class="label label-primary">{{ $rowDetails->off }}</span>
                                    @endif
                                @else
                                {{ $application->{$row->field} }}
                                @endif
                            @elseif($row->type == 'rich_text_box')
                                <p>{{ strip_tags($application->{$row->field}, '<b><i><u>') }}</p>
                            @elseif($row->type == 'file' && !empty($application->{$row->field}) )
                                <a target="_blank" href="/storage/{{ $application->{$row->field} }}">@lang('Download')</a>
                            @else
                                <p>{{ $application->{$row->field} }}</p>
                            @endif
                        </div><!-- panel-body -->
                        @if(!$loop->last)
                            <hr style="margin:0;">
                        @endif
                    @endforeach

                </div>
                <div class="panel-footer">
                    @if(Admin::can('edit_' . $dataType->name) && !in_array($application->status, ['OK', 'Pass']))
                    <button type="submit" data-id="{{ $application->id }}" class="btn btn-primary forward">转发简历</button>
                    @endif
                    @if (app('request')->input('assess_key'))
                    <button type="submit" class="btn btn-success assess-ok" data-id="{{$application->id}}" data-status="OK">合适</button>
                    <button type="submit" class="btn btn-warning assess-pass" data-id="{{$application->id}}" data-status="Pass">不合适</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('admin.position_applications.partials.forward_applications')

@stop

@section('javascript')
    <script>
        $(function() {


            $('.assess-ok,.assess-pass').click(function() {
                var url = "{{ route('admin.position-application.assess') }}";
                var data = {
                    id: $(this).data('id'),
                    status: $(this).data('status'),
                    assess_key: "{{ app('request')->input('assess_key') }}"
                };
                var result = data.status === 'OK' ? ' 合适 ' : ' 不合适 ';

                swal({
                        title: '',
                        text: '确定认为此简历' + result + '吗？',
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        cancelButtonText: '取消',
                        confirmButtonText: '确定',
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function () {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: data,
                            dataType: 'json',
                            success: function (res) {
                                if (res.result) {
                                    swal('操作成功', '', 'success');
                                } else {
                                    swal('不能重复操作', '', 'warning');
                                }
                            },
                            error: function (XMLHttpRequest) {
                                swal('操作失败', '', 'error');
                            }
                        })
                    });
            });

        })
    </script>
@stop
