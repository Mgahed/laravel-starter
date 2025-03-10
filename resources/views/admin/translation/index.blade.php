@extends('mgahed-laravel-starter::layouts.admin.master')

@section('pageCsCode')
    <link href="{{asset('assets/plugins/custom/jstree/jstree.bundle.css')}}" rel="stylesheet"
          type="text/css"/>

    <style>
        #map {
            height: 400px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
    </style>
@endsection

@section('pageContent')

    <div class="d-flex flex-column flex-column-fluid">

        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{__("admin.settings.translations.Translations")}}
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div class="d-flex ">
                        <a href="{{route('translations.scan')}}" class="btn btn-label-brand btn-bold">
                            <em class="fas fa-search"></em> {{__("admin.settings.translations.Scan translations")}}
                        </a>
                        <a href="{{route('translations.publish')}}" class="btn btn-default btn-bold">
                            <em class="fas fa-upload"></em> {{__("admin.settings.translations.Publish translations")}}
                        </a>
                        <a onclick="ajaxSubmit('{{route('translations.unpublished')}}','formData','GET')" class="btn btn-warning btn-bold">
                            {{__("admin.settings.translations.Unpublished items")}}&nbsp;
                            <span class="badge badge-light ">
                                {{@$unpublishedItems}}
                            </span>
                        </a>
                    </div>

                </div>
            </div>

        </div>

        <div class="row app-container container-fluid">
            <div class="col-lg-3">
                <div class="card shadow-sm app-content d-flex h-100 flex-column">
                    <div class="card-body">
                        <div class="kt-portlet__body">
                            <div id="kt_tree_translation" class="tree-demo">
                                <ul>
                                    <li>Root node 1
                                        <ul>
                                            <li id="child_node_1">Child node 1</li>
                                            <li>Child node 2</li>
                                        </ul>
                                    </li>
                                    <li>Root node 2</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                @include('mgahed-laravel-starter::admin.translation.filter')
                <br>
                @include('mgahed-laravel-starter::admin.translation.form')
                <div id="formData" class="col-lg-12">

                </div>
            </div>
        </div>
    </div>

@stop

@section('pageJsCode')
    <script src="{{asset('assets/plugins/custom/jstree/jstree.bundle.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#kt_tree_translation").jstree({
                "core" : {
                    'data' : {
                        'url' : function (node) {
                            return '{{route('jsonTranslation')}}';
                        },
                        'data' : function (node) {
                            return { 'parent' : node.id };
                        }
                    },
                    "themes" : {
                        "responsive": false
                    },
                    "check_callback" : true,
                },
                "state" : { "key" : "{{Request::url()}}" },
                "themes" : {
                    "responsive": true
                },
                "plugins" : ["wholerow","state"]
            });
        });

        $('#kt_tree_translation').on("select_node.jstree", function (e, data) {
            ajaxSubmit('{{route('translations-item')}}/' + data.node.id,'formData','GET')
        });

    </script>

    <script type="text/javascript">

        function updateTranslation($div,$id,$lang) {

            var formData = new FormData();
            formData.append('id', $id);
            formData.append('lang', $lang);
            formData.append('text', $div.value);

            ajaxFormSubmit('{{route('translations.update')}}','POST',formData)
        }

        function postForm() {
            form = document.getElementById("SearchForm");

            $url = '{{route('translations.search')}}/?site_id=' + form.site_id.value
                + '&translation_published=' + form.translation_published.value
                + '&find_in_value=' + form.find_in_value.value
                + '&find_in_field=' + form.find_in_field.value
                + '&find_in_operator=' + form.find_in_operator.value;

            ajaxSubmit($url,'formData','GET')
        }

        function googleTranslation($div,$id,$lang,$str,defaultLang = false) {
            var obj=document.getElementById($div);

            if(defaultLang == false){
                $.get('https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl='+$lang+'&dt=t&q='+$str, function(data, status){
                    obj.value=data[0][0][0];
                });
            } else {
                obj.value = $str;
            }
            document.getElementById($div).focus();

            // updateTranslation(obj,$id,$lang);

        }

        function globalTranslation($div,$id,$lang) {
            var obj=document.getElementById($div);

            if (confirm('{{__('admin.settings.translations.Are you sure you want to change all system translations as this')}}' + ' ['+ obj.value +']')) {

                var formData = new FormData();
                formData.append('id', $id);
                formData.append('lang', $lang);
                formData.append('text', obj.value);

                ajaxFormSubmit('{{route('translations.updateGlobal')}}', 'POST', formData)
            }
        }
    </script>

@stop

