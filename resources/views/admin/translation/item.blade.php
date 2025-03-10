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
                            <td class="text-truncate px-2 border">
                                {{\Illuminate\Support\Str::limit($item->translation_key, 50)}}
                                <br/><small>{{\Illuminate\Support\Str::limit($item->full_path, 60)}}</small>
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
                                    <div class="input-group">
                                        <button type="button"
                                                onclick="globalTranslation('{{$site->lang}}_{{$item->id}}','{{$item->translation_key}}','{{$site->lang}}')"
                                                class="btn btn-primary btn-bold">
                                            <em class="fas fa-globe"></em>
                                        </button>
                                        <input dir="{{$site->site_direction}}" id="{{$site->lang}}_{{$item->id}}"
                                               name="{{$site->lang}}_{{$item->id}}"
                                               onfocusout="updateTranslation(this,'{{$item->id}}','{{$site->lang}}')"
                                               value="{{@json_decode(@$item->translations,true)[$site->lang]}}" type="text"
                                               class="form-control">
                                        @if($site->id <> 1)
                                            <button type="button"
                                                    onclick="googleTranslation('{{$site->lang}}_{{$item->id}}','{{$item->id}}','{{$site->lang}}','{{$item->translation_key}}')"
                                                    class="btn btn-primary btn-bold">
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
