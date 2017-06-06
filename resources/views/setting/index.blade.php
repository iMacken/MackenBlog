@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <br>
            @include('partials.errors')
            <div class="panel panel-default">
                <div class="panel-heading">设置</div>
                <div class="panel-body">
                    <form role="form" id="setting-form" class="form-horizontal" action="{{ route('settings.save') }}" method="POST">
                        <div class="form-group">
                            <div class="radio">
                                <label class="col-sm-offset-2">
                                    <input type="radio"
                                           {{ isset($google_analytics) && $google_analytics == 'true' ? ' checked ':'' }}
                                           name="google_analytics"
                                           value="true">启用谷歌分析
                                </label>
                            </div>
                            <div class="radio">
                                <label class="col-sm-offset-2">
                                    <input type="radio"
                                           {{ isset($google_analytics) && $google_analytics == 'true' ? '':' checked ' }}
                                           name="google_analytics"
                                           value="false">禁用谷歌分析
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="radio">
                                <label class="col-sm-offset-2">
                                    <input type="radio"
                                           {{ isset($enable_mail_notification) && $enable_mail_notification == 'true' ? ' checked ':'' }}
                                           name="enable_mail_notification"
                                           value="true">启用邮件通知
                                </label>
                            </div>
                            <div class="radio">
                                <label class="col-sm-offset-2">
                                    <input type="radio"
                                           {{ isset($enable_mail_notification) && $enable_mail_notification == 'true' ? '':' checked ' }}
                                           name="enable_mail_notification"
                                           value="false">禁用邮件通知
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="radio">
                                <label class="col-sm-offset-2">
                                    <input type="radio"
                                           {{ (isset($comment_show) && $comment_show === 'true') ? ' checked ':'' }}
                                           name="comment_show"
                                           value="true">显示评论
                                </label>
                            </div>
                            <div class="radio">
                                <label class="col-sm-offset-2">
                                    <input type="radio"
                                           {{ (!isset($comment_show) || $comment_show === 'false') ? ' checked ':'' }}
                                           name="comment_show"
                                           value="false">隐藏评论
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label class="col-sm-offset-2">
                                    <input type="radio"
                                           {{ (!isset($allow_comment) || $allow_comment == 'true') ? ' checked ':'' }}
                                           name="allow_comment"
                                           value="true">允许评论(仍会显示已有评论)
                                </label>
                            </div>
                            <div class="radio">
                                <label class="col-sm-offset-2">
                                    <input type="radio"
                                           {{ (isset($allow_comment) && $allow_comment == 'false') ? ' checked ':'' }}
                                           name="allow_comment"
                                           value="false">禁止评论(仍会显示已有评论)
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label class="col-sm-offset-2">
                                    <input type="radio"
                                           {{ isset($open_pay) && $open_pay == 'true' ? ' checked ':'' }}
                                           name="open_pay"
                                           value="true">开启赞赏
                                </label>
                            </div>
                            <div class="radio">
                                <label class="col-sm-offset-2">
                                    <input type="radio"
                                           {{ isset($open_pay) && $open_pay == 'true' ? '':' checked ' }}
                                           name="open_pay"
                                           value="false">关闭赞赏
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="google_trace_id" class="col-sm-2 control-label">跟踪ID</label>
                            <div class="col-sm-8">
                                <input type="text" name="google_trace_id" class="form-control" id="google_trace_id"
                                       placeholder="谷歌跟踪ID"
                                       value="{{ $google_trace_id or ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="site_title"
                                       value="{{ $site_title or ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">关键字</label>
                            <div class="col-sm-8">
                                <input placeholder="网站关键字" class="form-control" type="text" name="site_keywords"
                                       value="{{ $site_keywords or ''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">网站描述</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="site_description"
                                       value="{{ $site_description or '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">每页数量</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number" name="page_size"
                                       value="{{ $page_size or 7 }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">赞赏描述</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="pay_description"
                                       value="{{ $pay_description or '写的不错，赞助一下主机费'}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">支付宝支付二维码</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="alipay_image_url"
                                       value="{{ $alipay_image_url or ''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">微信支付二维码</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="wechatpay_image_url"
                                       value="{{ $wechatpay_image_url or ''}}">
                            </div>
                        </div>

                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" class="btn bg-primary">
                                    保存
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
@endsection

@section('scripts')
    {!! Toastr::message() !!}
@endsection
