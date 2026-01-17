<form class="kt-form" enctype="multipart/form-data" method="POST" id="MainForm" name="MainForm">
    @csrf
    <input type="text" hidden name="parent_id" id="parent_id" value="{{@$translationParentId}}">
</form>

<div class="card mt-5">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                <tr class="bg-secondary">
                    <th class="text-center">{{__('admin.settings.translations.Key')}}</th>
                    @foreach(@$Sites as $site)
                        <th class="text-center">
                            {{$site->title}}
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    @if($item->full_path != null)
                        <tr>
                            <td class="px-2 border" style="width: 200px; max-width: 200px; word-wrap: break-word; white-space: normal; font-size: 0.875rem;">
                                <div style="word-break: break-word;">{{$item->translation_key}}</div>
                                <small class="text-muted" style="word-break: break-word;">{{$item->full_path}}</small>
                            </td>
                            @foreach(@$Sites as $site)
                                @if($site->lang <> 'en' && @json_decode(@$item->translations,true)[$site->lang] == @json_decode(@$item->translations,true)['en'])
                                    @php
                                        @$redFlag = 'table-danger';
                                    @endphp
                                @else
                                    @php
                                        @$redFlag = '';
                                    @endphp
                                @endif
                                <td class="text-center px-2 border {{@$redFlag}}">
                                    <div class="input-group input-group-sm">
                                        <button type="button"
                                                onclick="globalTranslation('{{$site->lang}}_{{$item->id}}','{{$item->translation_key}}','{{$site->lang}}')"
                                                class="btn btn-primary btn-sm">
                                            <em class="fas fa-globe"></em>
                                        </button>
                                        <input dir="{{$site->site_direction}}" id="{{$site->lang}}_{{$item->id}}"
                                               name="{{$site->lang}}_{{$item->id}}"
                                               onfocusout="updateTranslation(this,'{{$item->id}}','{{$site->lang}}')"
                                               value="{{@json_decode(@$item->translations,true)[$site->lang]}}" type="text"
                                               class="form-control form-control-sm">
                                        @if($site->id <> 1)
                                            <button type="button"
                                                    onclick="googleTranslation('{{$site->lang}}_{{$item->id}}','{{$item->id}}','{{$site->lang}}','{{$item->translation_key}}')"
                                                    class="btn btn-primary btn-sm">
                                                <em class="fas fa-language"></em>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
